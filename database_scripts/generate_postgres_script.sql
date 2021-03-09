-- create database shop_db;
-- REVOKE ALL ON SCHEMA shop_db FROM PUBLIC;
-- REVOKE ALL ON DATABASE shop_db FROM PUBLIC;
-- Tables
-- Users Related

-- Customers table


x
-- Password recovery tokens
CREATE TABLE if not exists password_recovery_tokens (
        password_recovery_id serial,
        password_recovery_token VARCHAR (200) NOT NULL UNIQUE,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id integer NOT NULL,
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (password_recovery_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Roles table
--CREATE TABLE if not exists user (
--                        role_id serial PRIMARY KEY,
--                        role_name VARCHAR (20) UNIQUE NOT NULL
--);
--
--CREATE TABLE if not exists roles (
--                        role_id serial PRIMARY KEY,
--                        role_name VARCHAR (20) UNIQUE NOT NULL
--);



-- reset_password table
CREATE TABLE if not exists reset_password_tokens (
        reset_token_id serial,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id integer NOT NULL,
        created_on TIMESTAMP DEFAULT now() ,
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (reset_token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Login tokens
CREATE TABLE if not exists login_tokens (
        login_token_id serial,
        user_id integer NOT NULL,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP NOT NULL,
        expires_on TIMESTAMP DEFAULT now() + '180 minute'::interval,
        PRIMARY KEY (login_token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- -- Activate account tokens /*OLD*/
-- CREATE TABLE if not exists activate_account_tokens (
--         activate_token_id serial,
--         user_id integer NOT NULL ,
--         token_code varchar (200) UNIQUE NOT NULL,
--         created_on TIMESTAMP NOT NULL,
--         expires_on TIMESTAMP DEFAULT now() + '2880 minute'::interval,
--         PRIMARY KEY (activate_token_id),
--         CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
-- );


-- Products Related

-- Categories table
CREATE TABLE if not exists categories (
                                          category_id serial PRIMARY KEY,
                                          category_name VARCHAR (50) NOT NULL,
                                          description TEXT NOT NULL
);

-- Brands table
CREATE TABLE if not exists brands (
                                      brand_id serial PRIMARY KEY,
                                      brand_name VARCHAR (50) NOT NULL
);

-- Product table
CREATE TABLE if not exists products (
        product_id serial,
        product_name VARCHAR ( 70 ) UNIQUE NOT NULL,
        product_category_id integer,
        product_brand_id integer,
        --                           price decimal (10,2), -- euros.  si no te preu es que no esta disponible encara (falta sortir el producte), Now models has the price
        description TEXT, -- Description of the product to be inserted in the database., no text, now models has the decription
        --                           limit_per_order integer, -- Limit per command
        /* Father product*/
        created_on TIMESTAMP DEFAULT now(),
        PRIMARY KEY (product_id),
        CONSTRAINT product_brand_id FOREIGN KEY (product_brand_id) REFERENCES brands (brand_id),
        CONSTRAINT product_category_id FOREIGN KEY (product_category_id) REFERENCES categories (category_id)
);

-- Additional_models table

-- La idea dels models es per diferents colors, pero els colors poden tindre ofertes o preus diferents, per exemple el blanc o el negre son mes barats que els altres
CREATE TABLE if not exists prod_models (
        model_id serial PRIMARY KEY,
        product_id integer,
        model_name VARCHAR ( 70 ) UNIQUE NOT NULL,
        --                                         model_category_id serial, # ?
        --                                         product_brand_id serial,
        price decimal (10,2), -- euros.  si no te preu es que no esta disponible encara (falta sortir el producte)
        description TEXT, -- Description of the product to be inserted in the database.
        limit_per_order integer, -- Limit per order
        created_on TIMESTAMP DEFAULT now(),
        CONSTRAINT product_id FOREIGN KEY (product_id) REFERENCES products (product_id),
        PRIMARY KEY (model_id)
);

CREATE TABLE if not exists cart (
        cart_id serial PRIMARY KEY,
        quantity integer NOT NULL,
        model_id integer NOT NULL,
        user_id integer NOT NULL,
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES prod_models (model_id) ON DELETE CASCADE,
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- model_image table
CREATE TABLE if not exists model_images (
        model_image_id serial PRIMARY KEY,
        model_id integer NOT NULL,
        image_file_name VARCHAR(100), -- 100 Caracters hauria destar sobrat.
        created_on TIMESTAMP DEFAULT now(),
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES prod_models (model_id) ON DELETE CASCADE,
        PRIMARY KEY (model_image_id)
);


-- Supply table
CREATE TABLE if not exists supplies (
        supply_id serial PRIMARY KEY,
        model_id integer NOT NULL,
        quantity integer NOT NULL,
        updated_on TIMESTAMP DEFAULT now(),
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES prod_models (model_id) ON DELETE CASCADE,
        PRIMARY KEY (supply_id)
);

-- Sales table
CREATE TABLE if not exists sales (
        sale_id serial PRIMARY KEY,
        --                        product_id serial NOT NULL,
        model_id serial NOT NULL,
        sale NUMERIC (3,2) NOT NULL, -- Guardar ofertes com a descompte del 20% -> 0.20
        product_brand_id VARCHAR ( 255 ) NOT NULL,
        sale_start DATE NOT NULL,
        sale_ends DATE NOT NULL,
        created_on TIMESTAMP NOT NULL
);




-- Orders Related

-- Orders table
CREATE TABLE if not exists orders (
    order_id serial PRIMARY KEY,
    payment_id integer NOT NULL,
    oder_date TIMESTAMP DEFAULT now(),
    CONSTRAINT payment_id FOREIGN KEY (payment_id) REFERENCES payment_methods (payment_id),
    PRIMARY KEY (order_id)
);

-- Payments table
CREATE TABLE if not exists payment_methods (
    payment_id serial PRIMARY KEY,
    user_id integer NOT NULL,
    method_name varchar(60) NOT NULL,
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Payments_memthods table
-- edit later
-- CREATE TABLE if not exists payment_methods (
--         payment_method_id serial PRIMARY KEY,
--         random_thing_to_store VARCHAR (20),
--         CONSTRAINT payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id)
-- );

-- Address table
CREATE TABLE if not exists address (
     address_id serial PRIMARY KEY,
     user_id integer NOT NULL,
     addr_1 VARCHAR (40) NOT NULL,
     addr_2 VARCHAR (40),
     addr_3 VARCHAR (40),
     province VARCHAR (30) NOT NULL ,
     country VARCHAR (2) NOT NULL, -- Sigles...
     postal_code VARCHAR (16) NOT NULL,
     CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);


-- Falta:

-- Triggers
-- Functions

-- Functions

CREATE EXTENSION pgcrypto; -- Crypt extension

-- https://www.postgresql.org/docs/8.3/pgcrypto.html
 /* example select from password given*/

-- CREATE or replace procedure is_alphanumeric(p_string varchar)
-- as $$
-- declare
-- --     not_alphanumeric exception;
--     v_string bool;
-- begin
--     case when not exists (
--     select regexp_matches(p_string,'^[a-zA-Z0-9]+$')
--     )
--     then raise exception 'not_alphanumeric';
--     else null;
--     end case;
--     /*raises exception if not alphanumeric*/
-- end; $$ language plpgsql;

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

-- CREATE or replace function create_user(p_user users.username%TYPE, p_passwd users.password%TYPE,p_email users.password%TYPE)
--     returns boolean as $$
-- declare
--     user_found boolean;
-- BEGIN
--     select into user_found (case when exists (select from users where username=p_uname and password=crypt(p_passwd,password))
--                                      then 1
--                                  else 0
--         end) as found;
--     RETURN user_found;
-- END;
-- $$ LANGUAGE plpgsql;

-- CREATE or replace function sanitize_text(p_text varchar)
-- returns text as $$
-- declare
--     new_text varchar;
-- begin
--     /* no se que fer*/
--     return p_text;
--
-- end; $$ LANGUAGE plpgsql;

CREATE or replace function check_login(p_uname users.username%TYPE, p_passwd users.password%TYPE)
    returns boolean as $$
declare
    user_found boolean;
BEGIN
    select into user_found (case when exists (select from users where username=p_uname and password=crypt(p_passwd,password))
                     then 1
                 else 0
        end) as found;
    RETURN user_found;
END;
$$ LANGUAGE plpgsql;

CREATE or replace procedure register_user(p_username users.username%TYPE, p_passwd varchar,p_email varchar)
as $$
declare
--     not_valid_email exception;
    v_uid integer;
BEGIN
    call validate_username(p_username);
    call validate_password(p_passwd);
    call validate_mail(p_email);
--     insert into
    case when exists(select true from users where username=p_username)
        then raise exception
            using errcode = 'P6101',
                message = 'This username is alredy in use';
        else null;
    end case;
--     case when exists(select true from users where email=cast(encode(cast(p_email as bytea),'hex') as bytea))
    case when exists(select true from users where email=p_email)
        then raise exception
            using errcode = 'P6102',
                message = 'This email is alredy in use';
        else null;
        end case;
--     insert into users(username, password, email) values (p_username,crypt(p_passwd, gen_salt('bf',8)),cast(encode(cast(p_email as bytea),'hex') as bytea));
    insert into users(username, password, email) values (p_username,crypt(p_passwd, gen_salt('bf',8)),p_email);
    select into v_uid user_id from users where username=p_username;
    insert into activated_accounts(user_id) values (v_uid); /* Canviar a trigger */

END;

$$ LANGUAGE plpgsql;

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
    case when not exists(select user_id from users where username=p_username)
        then raise exception
            using errcode = 'P6210',
                message = 'The given username wasn''t found';
        else
            select into v_uid user_id from users where username=p_username;
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
    case when not exists(select user_id from users where username=p_username)
        then raise exception
        using errcode = 'P6201',
            message = 'The given username wasn''t found';
        else
            select into v_uid user_id from users where username=p_username;
    end case;
    select into v_string func_return_activation_code(v_uid);
    return v_string;


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
                    using errcode = 'P6302',
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

-- create or replace function func_generate_activation_code(p_uid integer) returns varchar
-- as
-- declare
--     v_string varchar(60);
-- begin
--     select into v_string random_string(60);
--     while (select true from activate_account_tokens where token_code=v_string) loop
--             raise notice e'loop';
--             select into v_string random_string(60);
--         end loop;
--     insert into activate_account_tokens(user_id,activation_account_token) values(p_uid,v_string);
--     raise notice e'inserted';
--     return v_string;
-- exception
--     when sqlstate '23503' then
--         raise notice e'ERROR: User with u_id [%] wasn''t found',p_uid;
-- end;
-- $$ LANGUAGE plpgsql;




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

-- Triggers

-- create or replace procedure create_activation_code(p_uid integer)
-- as $$
--     declare
--     begin
--
--     end;
-- $$


-- create trigger trigg_create_activation_code
--     after insert on users
--     for each row execute procedure


-- Index

-- Display products,   (products,brand,category) grouped by product_father