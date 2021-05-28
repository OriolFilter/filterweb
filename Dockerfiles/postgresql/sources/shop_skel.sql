-- REVOKE ALL ON SCHEMA shop_db FROM PUBLIC;
-- REVOKE ALL ON DATABASE shop_db FROM PUBLIC;
-- Tables
-- Users Related

-- Customers table



CREATE TABLE if not exists users (
    user_id serial,
    username VARCHAR ( 20 ) UNIQUE NOT NULL, /* instead of searching by lower(username) create index of all lower(usernames) with all passwords to check login credentials, or index of just lower(usernames) or lower(email) to check if username or email already exists*/
    password VARCHAR ( 60 ) NOT NULL, /* encrypted and salted, returns 60 length */
    email VARCHAR ( 255 ) UNIQUE NOT NULL /* https://stackoverflow.com/questions/386294/what-is-the-maximum-length-of-a-valid-email-address */,
    created_on TIMESTAMP DEFAULT now() NOT NULL,
    updated_on TIMESTAMP DEFAULT now() NOT NULL,
    last_login TIMESTAMP DEFAULT now() NOT NULL,
    PRIMARY KEY (user_id)
);

-- Activate account tokens
CREATE TABLE if not exists activate_account_tokens (
    activation_account_token_id serial,
    activation_account_token VARCHAR (200) NOT NULL UNIQUE,
    user_id integer NOT NULL,
    used_bool bool DEFAULT false NOT NULL,
    created_on TIMESTAMP DEFAULT now(),
    expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
    PRIMARY KEY (activation_account_token_id),
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

CREATE table if not exists activated_accounts (
    activated_users_id serial,
    user_id integer NOT NULL,
    activated_bool boolean NOT NULL DEFAULT FALSE,
    activation_date TIMESTAMP DEFAULT NULL,
    PRIMARY KEY (activated_users_id),
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);
-- reset_password table
CREATE TABLE if not exists change_password_tokens (
    change_password_token_id serial,
    change_password_token VARCHAR (200) NOT NULL UNIQUE,
    user_id integer NOT NULL,
    used_bool bool DEFAULT false NOT NULL,
    created_on TIMESTAMP DEFAULT now(),
    expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
    PRIMARY KEY (change_password_token_id),
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);
CREATE TABLE if not exists session_tokens (
    session_token_id serial,
    session_token VARCHAR (200) NOT NULL UNIQUE,
    user_id integer NOT NULL,
    created_on TIMESTAMP DEFAULT now(),
    expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
    PRIMARY KEY (session_token_id),
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- User Payment methods

CREATE TABLE if not exists user_payment_methods (
    user_payment_method_id serial PRIMARY KEY ,
    user_payment_method_name varchar (40) NOT NULL, /*Varchar only */
    user_id integer NOT NULL,
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Shipping address

CREATE TABLE if not exists shipping_address (
    shipping_address_id serial PRIMARY KEY ,
    shipping_address_country varchar (2) NOT NULL, /* ES, CA, FR */
    shipping_address_city varchar NOT NULL,
    shipping_address_postal_code varchar NOT NULL, /* https://en.wikipedia.org/wiki/Postal_code */
    shipping_address_line1 varchar NOT NULL, /* Undefined length */
    shipping_address_line2 varchar,
    shipping_address_line3 varchar,
    user_id integer NOT NULL,
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

CREATE EXTENSION if not exists pgcrypto; -- Crypt extension

-- https://www.postgresql.org/docs/8.3/pgcrypto.html

    /* General Functions */

create or replace function return_crypted_pass(v_txt varchar) returns varchar
as $$
begin
    return crypt(v_txt, gen_salt('bf',8));
end;
$$ language plpgsql;

-- Generate random string (will be used to generate random tokens)
-- stolen from here:
-- https://stackoverflow.com/questions/3970795/how-do-you-create-a-random-string-thats-suitable-for-a-session-id-in-postgresql
Create or replace function random_string(length integer) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;

    /* Regex */

CREATE or replace procedure validate_username(p_uname varchar)
as $$
declare
begin
    case when not exists (select regexp_matches(p_uname,'^[a-zA-Z0-9._.-.+.]{6,20}$'))
        then raise exception
            using errcode = 'P3100',
                message = 'The username given does not meet the requirements.',
                hint = 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."';

        else
            null;
        end case; /*raises exception if username not matches regex*/
end; $$ language plpgsql;

CREATE or replace procedure validate_password(p_passwd varchar)
as $$
declare
begin
    /* Add must contain one of the followings! */
    case when not exists (
            select regexp_matches(p_passwd,'^[a-zA-Z0-9$%.,?!+_=-]{6,20}$')
        )
        then
--         raise exception 'not_valid_email';
            raise exception
                using errcode = 'P3200',
                    message = 'The password given does not meet the requirements.',
                    hint = 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%/.,?!+_=-"';

        else null;
        end case ; /*raises exception if password not matches regex*/
    /* text@text.text */
end; $$ language plpgsql;

CREATE or replace procedure validate_mail(p_mail varchar)
as $$
declare
    v_mail bool;
begin
    case when not exists (
            select regexp_matches(p_mail,'^[a-zA-Z0-9.!#$%&''*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$')) then
        raise exception
            using errcode = 'P3300',
                message = 'The email given does not meet the requirements.',
                hint = 'Email seems to be invalid';
        else null;
        end case ; /* not raises exception if email matches regex */
    /* text@text.text */
end; $$ language plpgsql;

    /* Check for ALREADY existing values */
/* Username exists*/
CREATE OR REPLACE function func_check_user_exists(p_uname varchar) returns boolean
as $$
begin
    case when exists(select lower(username) from users where lower(username)=lower(p_uname))
        then return true;
        else return false;
    end case;
end;
$$ language plpgsql;

CREATE OR REPLACE function func_check_email_exists(p_email varchar) returns bool
as $$
begin
    case when exists(select lower(email) from users where lower(email)=lower(p_email))
        then return true;
        else return false;
    end case;
end;
$$ language plpgsql;

CREATE OR REPLACE procedure proc_check_user_exists(p_uname varchar)
as $$
begin
    case when exists(select lower(username) from users where lower(username)=lower(p_uname))
        then raise exception
            using errcode = 'P6101',
                message = 'This username is already in use';
        else null;
    end case;
end;
$$ language plpgsql;

CREATE OR REPLACE procedure proc_check_email_exists(p_email varchar)
as $$
begin
    case when exists(select lower(email) from users where lower(email)=lower(p_email))
        then raise exception
            using errcode = 'P6102',
                message = 'This email is already in use';
        else null;
    end case;
end;
$$ language plpgsql;

    /* Activate account */

/* Activation */
create or replace procedure proc_generate_activation_code(p_uid integer)
as $$
declare
    v_string varchar(60);
begin
    /*check user not enabled*/
    case when exists(select true from activated_accounts where user_id=p_uid and activated_bool=true)
        then raise exception
            using errcode = 'P7200',
                message = 'This account is already activated';
        else null;
    end case;
    select into v_string random_string(60);
    while (select true from activate_account_tokens where activation_account_token=v_string) loop
            select into v_string random_string(60);
        end loop;
    insert into activate_account_tokens(user_id,activation_account_token) values(p_uid,v_string);
exception
    when sqlstate '23503' then
        raise exception
            using errcode = 'P6210',
                message = 'User_id was not found';
/*     raise notice e'ERROR: User with u_id [%] wasn''t found',p_uid;*/
end;
$$ LANGUAGE plpgsql;

create or replace procedure proc_generate_activation_code(p_username varchar)
as $$
declare
    v_uid integer;
begin
    /*get uid then call the other command*/
    case when not exists(select user_id from users where lower(username)=lower(p_username))
        then raise exception
            using errcode = 'P6210',
                message = 'The given username wasn''t found';
        else
            select into v_uid user_id from users where lower(username)=lower(p_username);
        end case;
    call proc_generate_activation_code(v_uid);

end;
$$ LANGUAGE plpgsql;

create or replace function func_return_activation_code(p_uid integer) returns varchar(60)
as $$
declare
    v_string varchar(60);
begin
    /* uses u_id*/
    /*check user not enabled*/
    case when exists(select true from activated_accounts where user_id=p_uid and activated_bool=true)
        then raise exception
            using errcode = 'P7200',
                message = 'This account is already activated';
        else null;
        end case;
    /* Generates and insert token*/
    select into v_string random_string(60);
    while (select true from activate_account_tokens where activation_account_token=v_string) loop
            select into v_string random_string(60);
        end loop;
    insert into activate_account_tokens(user_id,activation_account_token) values(p_uid,v_string);
    return v_string;
    exception
    when sqlstate '23503' then
        raise exception
            using errcode = 'P62200',
                message = 'User_id was not found';
--         raise notice e'ERROR: User with u_id [%] wasn''t found',p_uid;
end;
$$ LANGUAGE plpgsql;

create or replace function func_return_activation_code(p_username varchar)
returns varchar(60)
as $$
declare
    v_uid integer;
    v_string varchar(60);
begin
    /*get uid then call the other command*/
    case when not exists(select user_id from users where lower(username)=lower(p_username))
        then raise exception
        using errcode = 'P6201',
            message = 'Username not found';
        else
            select into v_uid user_id from users where lower(username)=lower(p_username);
    end case;
    select into v_string func_return_activation_code(v_uid);
    return v_string;
end;
$$ LANGUAGE plpgsql;

create or replace function func_return_activation_code_and_email_from_username(p_username varchar)
    returns table (email varchar,token varchar)
as $$
declare
v_mail varchar;
v_string varchar;
begin
    select into v_string func_return_activation_code(p_username);
    select into v_mail us.email from users us where lower(us.username)=lower(p_username);
--     return query select 'aaaaaaaaaaaaaaa'::varchar,'bbbbbbbbbbbb'::varchar;
    return query select v_mail, v_string;
end;
$$ LANGUAGE plpgsql;

create or replace procedure proc_activate_account(p_token activate_account_tokens.activation_account_token%type) as $$
declare
    u_id integer;
begin
    -- Working with activation tokens
    -- P0040 token null
    -- P0041 not found in the database/valid
    -- P0042 token expired
    -- P0043 token used
    -- P0044 user already enabled
    if p_token='' then
        raise exception
            using errcode = 'P6304',
                message = 'Token is null or empty';
    end if;
    case when not exists(select true from activate_account_tokens where activation_account_token=p_token)
        then raise exception
            using errcode = 'P6204',
                message = 'Token not found';
        else null;
        end case;
    case when not exists(select true from activate_account_tokens where activation_account_token=p_token and created_on<now() and expires_on>now())
        then raise exception
            using errcode = 'P6302',
                message = 'The token expired';
        else null;
        end case;
    case when not exists(select true from activate_account_tokens where activation_account_token=p_token and used_bool=false)
        then raise exception
            using errcode = 'P6303',
                message = 'The token already used';
        else null;
        end case;
    case when not exists(select true from activate_account_tokens aat, activated_accounts aa where aat.activation_account_token=p_token and aa.user_id=aat.user_id)
        then raise exception
            using errcode = 'P7100',
                message = 'The user is already enabled';
        else null;
        end case;

    select into u_id user_id from activate_account_tokens where activation_account_token=p_token;
    update activate_account_tokens set used_bool=true where activation_account_token=p_token;
    update activated_accounts aa set activated_bool=true,activation_date=now() where u_id=aa.user_id;
end;
$$  language plpgsql;

    /* Change Password */

/* Password updating */
create or replace function func_return_change_password_code(p_uid integer) returns varchar(60)
as $$
declare
    v_string varchar(60);
begin
    /* uses u_id*/

    /* Generates and insert token*/
    select into v_string random_string(60);
    while (select true from change_password_tokens where change_password_token=v_string) loop
            select into v_string random_string(60);
        end loop;
    insert into change_password_tokens(user_id,change_password_token) values(p_uid,v_string);
    return v_string;
exception
    when sqlstate '23503' then
        raise exception
            using errcode = 'P62200',
                message = 'User_id was not found';
--         raise notice e'ERROR: User with u_id [%] wasn''t found',p_uid;
end;
$$ LANGUAGE plpgsql;

create or replace function func_return_change_password_code(p_username varchar)
    returns varchar(60)
as $$
declare
    declare
    v_string varchar(60);
    v_uid integer;
begin
    if (func_check_user_exists(p_username)) then
        select into v_uid user_id from users where lower(username)=lower(p_username);
        select into v_string func_return_change_password_code(v_uid);
        return v_string;
    else
        raise exception
            using errcode = 'P6201',
                message = 'Username not found';
    end if;


end;
$$ LANGUAGE plpgsql;

create or replace function func_return_change_password_code_from_email(p_email varchar) returns varchar(60)
as $$
    declare
        v_string varchar(60);
        v_user varchar;
    begin
        if (func_check_email_exists(p_email)) then
            select into v_user username from users where lower(email)=lower(p_email);
            select into v_string func_return_change_password_code(v_user);
            return v_string;
        else
            raise exception
                using errcode = 'P6203',
                    message = 'Email not found';
        end if;
    end;

$$ language plpgsql;

create or replace function func_return_password_code_and_username_from_email(p_mail varchar)
    returns table (uname varchar,token varchar)
as $$
declare
    v_uname varchar;
    v_string varchar;
begin
    select into v_string func_return_change_password_code_from_email(p_mail);
    select into v_uname us.username from users us where lower(us.email)=lower(p_mail);
    return query select v_uname, v_string;
end;
$$ LANGUAGE plpgsql;

create or replace procedure proc_check_password_token_is_valid(p_token varchar)
as $$
    begin
        case when exists(select true from change_password_tokens where change_password_token=p_token)
            then null;
            else
                raise exception
                using errcode = 'P6301',
                    message = 'Token not valid';
        end case; /* Podria fer-ho tot junt pero llavors no tendria ni la meitat de respostes */
        case when exists(select true from change_password_tokens where change_password_token=p_token and created_on<now() and expires_on>now())
            then null;
            else
                raise exception
                using errcode = 'P6303',
                    message = 'Token expired';
            end case;
        case when exists(select true from change_password_tokens where change_password_token=p_token and created_on<now() and expires_on>now() and used_bool=false)
            then null;
            else
                raise exception
                using errcode = 'P6302',
                    message = 'Token already used';
            end case;
    end;
$$ language plpgsql;

    /* Session tokens */

create or replace procedure proc_check_session_token_is_valid(p_token varchar)
as $$
begin
    case when exists(select true from session_tokens where session_token=p_token)
        then null;
        else
            raise exception
                using errcode = 'P6301',
                    message = 'Token not valid';
        end case; /* Podria fer-ho tot junt pero llavors no tendria ni la meitat de respostes */
    case when exists(select true from session_tokens where session_token=p_token and created_on<now() and expires_on>now())
        then null;
        else
            raise exception
                using errcode = 'P6303',
                    message = 'Token expired';
        end case;
end;
$$ language plpgsql;

/* Password updating */
create or replace function func_return_session_code(p_uid integer) returns varchar(60)
as $$
declare
    v_string varchar(60);
begin
    /* uses u_id*/

    /* Generates and insert token*/
    select into v_string random_string(60);
    while (select true from session_tokens where session_token=v_string) loop
            select into v_string random_string(60);
        end loop;
    insert into session_tokens(user_id,session_token) values(p_uid,v_string);
    return v_string;
exception
    when sqlstate '23503' then
        raise exception
            using errcode = 'P62200',
                message = 'User_id was not found';
end;
$$ LANGUAGE plpgsql;

create or replace function func_return_session_code(p_username varchar)
    returns varchar(60)
as $$
declare
    declare
    v_string varchar(60);
    v_uid integer;
begin
    if (func_check_user_exists(p_username)) then
        select into v_uid user_id from users where lower(username)=lower(p_username);
        select into v_string func_return_session_code(v_uid);
        return v_string;
    else
        raise exception
            using errcode = 'P6201',
                message = 'Username not found';
    end if;


end;
$$ LANGUAGE plpgsql;

CREATE or replace procedure proc_credentials_user(p_uname users.username%TYPE, p_passwd users.password%TYPE)
as $$
declare
BEGIN
    case when not exists (select from users where lower(username)=lower(p_uname) and password=crypt(p_passwd,password))
        then raise exception
            using errcode = 'P9000',
                message = 'Invalid Credentials';
        else null;
        end case;
END;
$$ LANGUAGE plpgsql;

    /* Check account is activated */

create or replace procedure proc_check_user_is_activated(p_uid integer)
as $$
begin
    case when not exists(select true from activated_accounts where user_id=p_uid and activated_bool=true)
        then raise exception
            using errcode = 'P7100',
                message = 'This account is not activated';
        else null;
        end case; /* Still can be a non existent user, but checking this two times is a waste of time */
end;
$$ language plpgsql;

    /* Login */

CREATE or replace procedure proc_enlarge_login(p_token varchar)
as $$
declare
BEGIN
    /* no control*/
    /* Extends login by 30 mins as long it be valid `*/
    update session_tokens set expires_on=now() + '30 minute'::interval where session_token=p_token and expires_on<now() + '30 minute'::interval and expires_on>now();
END;
$$ LANGUAGE plpgsql;

create or replace procedure proc_login_session_token(p_token varchar)
as $$
    begin /* Login with session token */
        call proc_check_session_token_is_valid(p_token);
        call proc_enlarge_login(p_token);
        update users set last_login=now() from users u,session_tokens s where u.user_id=s.user_id and s.session_token=p_token; /* No need to check token is valid due proc */
--         update session_tokens set expires_on=now() + '30 minute'::interval where session_token=p_token;
    end;
$$ language plpgsql;

create or replace function func_return_session_token_from_credentials(p_uname varchar, p_pass varchar) returns varchar
as $$
    declare
        v_uid integer;
        v_token varchar;
begin
        call proc_credentials_user(p_uname,p_pass);
        select into v_uid user_id from users where lower(username)=lower(p_uname);
        call proc_check_user_is_activated(v_uid);
        /* Also checks user is activated*/
        select into v_token func_return_session_code(v_uid);
        update users set last_login=now() from users u,session_tokens s where u.user_id=v_uid; /* No need to check token is valid due proc */
        return v_token;

end;
$$ language plpgsql;

/* Check user+pass */
CREATE or replace function func_credentials_user(p_uname users.username%TYPE, p_passwd users.password%TYPE)
    returns boolean as $$
declare
    user_found boolean;
BEGIN
    select into user_found (case when exists (select from users where lower(username)=lower(p_uname) and password=crypt(p_passwd,password))
                                     then 1
                                 else 0
        end) as found;
    RETURN user_found;
END;
$$ LANGUAGE plpgsql;

    /* Payment methods */

create or replace procedure check_payment_method_name(p_name_method varchar)
as $$
        begin
            case when not exists (select regexp_matches(p_name_method,'^[a-zA-Z0-9_ ]{6,20}$'))
                then raise exception
                    using errcode = 'P3600',
                        message = 'Payment method info does not meet the requirements',
                        hint = 'Payment method name needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9 and/or spaces or _';
                else
                    null;
                end case; /*raises exception if name not matches regex*/
        end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_add_payment_method(p_user_id integer,p_name_method varchar)
as $$
    begin
        call check_payment_method_name(p_name_method);
        insert into user_payment_methods(user_id,user_payment_method_name) values (p_user_id,p_name_method);
    end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_add_payment_method_from_stoken(p_stoken varchar,p_name_method varchar)
as $$
    declare
        v_uid integer;
begin
    call proc_check_session_token_is_valid(p_stoken);
    call check_payment_method_name(p_name_method);
    select into v_uid user_id from session_tokens where p_stoken=session_token;
    insert into user_payment_methods(user_id,user_payment_method_name) values (v_uid,p_name_method);
end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_remove_payment_method_from_stoken(p_stoken varchar,p_row_number integer)
as $$
declare
    v_uid integer;
    v_pmid integer; /* payment method id */
begin
    call proc_check_session_token_is_valid(p_stoken);
    select into v_uid user_id from session_tokens where p_stoken=session_token;

    select sq.pmid into v_pmid from (SELECT row_number() over (order by user_payment_method_id)::integer as rn, user_payment_method_id as pmid from user_payment_methods where user_id=v_uid)
                                   as sq where sq.rn::integer=p_row_number::integer;
    delete from user_payment_methods where user_payment_method_id::integer=v_pmid::integer;

end;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION func_return_payment_methods_from_stoken(p_stoken varchar) returns table (payment_method_row_number integer,payment_method_name varchar)
as $$
    declare
        v_uid integer;
    begin
        call proc_check_session_token_is_valid(p_stoken);
        select into v_uid user_id from session_tokens where p_stoken=session_token;
        return query SELECT row_number() over (order by user_payment_method_id)::integer,user_payment_method_name from user_payment_methods where user_id=v_uid;
    end;
$$ language plpgsql;

/* Shipping address methods */

create or replace procedure check_shipping_country_code_name(p_name_method varchar)
as $$
begin
    /* check 2 chars and chars */
    case when not exists (select regexp_matches(p_name_method,'^[a-zA-Z]{2}$'))
        then raise exception
            using errcode = 'P3901',
                message = 'Shipping address country does not meet the requirements',
                hint = 'Shipping address country needs to be 2 characters that represent the country following the standar ISO 3166-2';
        else
            null;
        end case; /*raises exception if name not matches regex*/
end;
$$ language plpgsql;

create or replace procedure check_shipping_address_l1(p_name_method varchar)
as $$
begin
    /* 5 - 200 chars */
    if (length(p_name_method) < 5 or length(p_name_method) > 200) then
        raise exception
            using errcode = 'P3904',
                message = 'Shipping address line 1 field does not meet the requirements',
                hint = 'Shipping address line 1 needs to be from 5 to 200 characters';
    end if;
end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_add_shipping_address(p_user_id integer,p_country varchar, p_city varchar, p_postalcode varchar, p_addline1 varchar,  p_addline2 varchar default null, p_addline3 varchar default null)
as $$
begin
    call check_shipping_country_code_name(p_country);
    call check_shipping_address_l1(p_addline1);
--     call check_shipping_address_l2(p_addline2);
--     call check_shipping_address_l3(p_addline3);
    insert into shipping_address(user_id,shipping_address_country,shipping_address_city,shipping_address_postal_code,shipping_address_line1,shipping_address_line2,shipping_address_line3)
                         values (p_user_id,upper(p_country),p_city,p_postalcode,p_addline1,p_addline2,p_addline3);
end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_add_shipping_address_from_stoken(p_stoken varchar,p_country varchar, p_city varchar, p_postalcode varchar, p_addline1 varchar,  p_addline2 varchar default null, p_addline3 varchar default null)
as $$
declare
    v_uid integer;
begin
    call proc_check_session_token_is_valid(p_stoken);
    call check_shipping_country_code_name(p_country);
    call check_shipping_address_l1(p_addline1);
--     call check_shipping_address_l2(p_addline2);
--     call check_shipping_address_l3(p_addline3);
    select into v_uid user_id from session_tokens where p_stoken=session_token;
    insert into shipping_address(user_id,shipping_address_country,shipping_address_city,shipping_address_postal_code,shipping_address_line1,shipping_address_line2,shipping_address_line3)
                         values (v_uid,upper(p_country),p_city,p_postalcode,p_addline1,p_addline2,p_addline3);
end;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE proc_remove_shipping_address_from_stoken(p_stoken varchar,p_row_number integer)
as $$
declare
    v_uid integer;
    v_said integer; /* payment method id */
begin
    call proc_check_session_token_is_valid(p_stoken);
    select into v_uid user_id from session_tokens where p_stoken=session_token;

    select sq.pmid into v_said from (SELECT row_number() over (order by shipping_address_id)::integer as rn, shipping_address_id as pmid from shipping_address where user_id=v_uid)
                                        as sq where sq.rn::integer=p_row_number::integer;

    delete from shipping_address where shipping_address_id::integer=v_said::integer;
end;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION func_return_shipping_address_from_stoken(p_stoken varchar) returns table (sa_row_number integer,sa_country varchar,sa_city  varchar, sa_postal_code varchar,sa_line1 varchar,sa_line2  varchar,sa_line3  varchar)
as $$
declare
    v_uid integer;
begin
    call proc_check_session_token_is_valid(p_stoken);
    select into v_uid user_id from session_tokens where p_stoken=session_token;
    return query SELECT row_number() over (order by shipping_address_id)::integer, shipping_address_country::varchar,shipping_address_city::varchar, shipping_address_postal_code::varchar,shipping_address_line1::varchar,shipping_address_line2::varchar,shipping_address_line3::varchar from shipping_address where user_id=v_uid;
--     return query SELECT row_number() over (order by user_payment_method_id)::integer,user_payment_method_name from user_payment_methods where user_id=v_uid;
end;
$$ language plpgsql;


/* User management*/

CREATE or replace procedure register_user(p_username varchar, p_passwd varchar,p_email varchar)
as $$
declare
--     not_valid_email exception;
    v_uid integer;
BEGIN
    --     Validates entries
    call validate_username(p_username);
    call validate_password(p_passwd);
    call validate_mail(p_email);
--     Check if entries already exists
    call proc_check_user_exists(p_username);
    call proc_check_email_exists(p_email);

--     insert into users(username, password, email) values (p_username,crypt(p_passwd, gen_salt('bf',8)),cast(encode(cast(p_email as bytea),'hex') as bytea));
    insert into users(username, password, email) values (p_username,return_crypted_pass(p_passwd),p_email);
    select into v_uid user_id from users where lower(username)=lower(p_username);
    insert into activated_accounts(user_id) values (v_uid); /* Canviar a trigger */

END;

$$ LANGUAGE plpgsql;

CREATE OR REPLACE procedure proc_change_password_user(p_token varchar,p_pass varchar)
as $$
    declare
        v_uid integer;
    begin
        call proc_check_password_token_is_valid(p_token);
        select into v_uid user_id from change_password_tokens where change_password_token=p_token;
        update users set password=return_crypted_pass(p_pass) where user_id=v_uid;
        update session_tokens set expires_on=now() - '2 minute'::interval where user_id=v_uid; /* On change password forces expire on all session tokens from the user */
        update change_password_tokens set used_bool=true where change_password_token=p_token;
end;
$$ language plpgsql;