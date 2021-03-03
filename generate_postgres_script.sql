
-- Tables
-- Users Related

-- Customers table
CREATE TABLE if not exists users (
      user_id serial,
      username VARCHAR ( 20 ) UNIQUE NOT NULL,
      password VARCHAR ( 60 ) NOT NULL, /* crypted and salted, returns 60 lenght */
--       email VARCHAR ( 255 ) UNIQUE NOT NULL,
      email bytea UNIQUE NOT NULL, /* al final si es guarda en hexa perque estalvies espais i no importen les majuscules*/
--                          role_id serial NOT NULL,
      created_on TIMESTAMP DEFAULT now() NOT NULL,
      updated_on TIMESTAMP DEFAULT now() NOT NULL,
      last_login TIMESTAMP DEFAULT now() NOT NULL,
--                          last_login TIMESTAMP,
      PRIMARY KEY (user_id)
--                          CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES role (role_id)
);

-- Activate account tokens
CREATE TABLE if not exists activate_account_tokens (
    activate_account_id serial,
    activate_account_token VARCHAR (200) NOT NULL UNIQUE,
--     token_code varchar (200) UNIQUE NOT NULL,
    user_id integer NOT NULL,
    created_on TIMESTAMP DEFAULT now(),
    expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
    PRIMARY KEY (activate_account_id),
    CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

CREATE table activated_users (
 enabled_users_id serial,
 user_id integer NOT NULL,
 enabled_bool boolean NOT NULL DEFAULT FALSE,
 activation_date TIMESTAMP DEFAULT NULL,
 PRIMARY KEY (enabled_users_id),
 CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

-- Login tokens / session
CREATE TABLE if not exists login_tokens (
        token_id serial,
        user_id integer NOT NULL,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

-- Password recovery tokens
CREATE TABLE if not exists password_recovery_tokens (
        password_recovery_id serial,
        password_recovery_token VARCHAR (200) NOT NULL UNIQUE,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id integer NOT NULL,
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (password_recovery_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
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
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

-- Login tokens
CREATE TABLE if not exists login_tokens (
        login_token_id serial,
        user_id integer NOT NULL,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP NOT NULL,
        expires_on TIMESTAMP DEFAULT now() + '180 minute'::interval,
        PRIMARY KEY (login_token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

-- Activate account tokens
CREATE TABLE if not exists activate_account_tokens (
        activate_token_id serial,
        user_id integer NOT NULL ,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP NOT NULL,
        expires_on TIMESTAMP DEFAULT now() + '2880 minute'::interval,
        PRIMARY KEY (activate_token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);


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
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES prod_models (model_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);

-- model_image table
CREATE TABLE if not exists model_images (
        model_image_id serial PRIMARY KEY,
        model_id integer NOT NULL,
        image_file_name VARCHAR(100), -- 100 Caracters hauria destar sobrat.
        created_on TIMESTAMP DEFAULT now(),
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES products (product_id),
        PRIMARY KEY (model_image_id)
);


-- Supply table
CREATE TABLE if not exists supplies (
        supply_id serial PRIMARY KEY,
        model_id integer NOT NULL,
        quantity integer NOT NULL,
        updated_on TIMESTAMP DEFAULT now(),
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES prod_models (model_id),
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
    CONSTRAINT payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id),
    PRIMARY KEY (order_id)
);

-- Payments table
CREATE TABLE if not exists payments (
    payment_id serial PRIMARY KEY,
    payment_method_id serial
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
     CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id)
);


-- Falta:

-- Triggers
-- Functions

/* Errcode table
P0000
P0001 username
P0002 password
P0003 email
*/
-- Functions

CREATE EXTENSION pgcrypto; -- Crypt extension

-- https://www.postgresql.org/docs/8.3/pgcrypto.html
 /* example select from password given*/

CREATE or replace procedure is_alphanumeric(p_string varchar)
as $$
declare
--     not_alphanumeric exception;
    v_string bool;
begin
    case when not exists (
    select regexp_matches(p_string,'^[a-zA-Z0-9]+$')
    )
    then raise exception 'not_alphanumeric';
    else null;
    end case;
    /*raises exception if not alphanumeric*/
end; $$ language plpgsql;



CREATE or replace procedure validate_mail(p_mail varchar)
as $$
declare
    v_mail bool;
begin
    case when not exists (
       select regexp_matches(p_mail,'^[a-zA-Z0-9.!#$%&''*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$')
                               )
                                    then
--         raise exception 'not_valid_email';
        raise exception
            using errcode = 'P0003',
                message = 'The email given does not meet the requirements.';
        else null;
    end case ; /*raises exception if email matches regex*/
    /* text@text.text */
end; $$ language plpgsql;

CREATE or replace procedure validate_username(p_uname varchar)
as $$
declare
    v_uname bool;
begin
    /* Segurament case sigui millor*/
    case when not exists (
                                   select regexp_matches(p_uname,'^[a-zA-Z0-9._.-.+]+$')
                               )
                                    then
        raise exception
            using errcode = 'P0001',
                message = 'The username given does not meet the requirements.';
        else
        null;
    end case; /*raises exception if email not matches regex*/
end; $$ language plpgsql;

CREATE or replace procedure validate_password(p_passwd varchar)
as $$
declare
begin
    case when not exists (
            select regexp_matches(p_passwd,'^[a-zA-Z0-9$%/.,?!+_=-]+$')
        )
        then
--         raise exception 'not_valid_email';
            raise exception
                using errcode = 'P0002',
                    message = 'The email given does not meet the requirements.';
        else null;
        end case ; /*raises exception if password not matches regex*/
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

CREATE or replace function sanitize_text(p_text varchar)
returns text as $$
declare
    new_text varchar;
begin
    /* no se que fer*/
    return p_text;

end; $$ LANGUAGE plpgsql;

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


CREATE or replace procedure create_user(p_user users.username%TYPE, p_passwd varchar,p_email varchar)
as $$
declare
--     not_valid_email exception;
    v_uid integer;
BEGIN
    call validate_username(p_user);
    call validate_password(p_passwd);
    call validate_mail(p_email);
--     insert into
    insert into users(username, password, email) values (p_user,crypt(p_passwd, gen_salt('bf',8)),cast(encode(cast(p_email as bytea),'hex') as bytea));
    select into v_uid user_id from users where username=p_user;
    insert into activated_users(user_id) values (v_uid);
--     commit; /* Postgres manages commit or rollback alone*/
EXCEPTION
    when sqlstate 'P0001' then
        raise notice e'Error in the given username';
    when sqlstate 'P0002' then
        raise notice e'Error in the given password';
    when sqlstate 'P0003' then
        raise notice e'Error in the given mail';
    when unique_violation then
--     when sqlstate '23505' then
--         set context
        raise notice 'Duplicate username or email, let''s see how we fix it...';

END;

$$ LANGUAGE plpgsql;




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


-- insert into test (value) values ('first_try');