
-- Tables
-- Users Related

-- Customers table
CREATE TABLE if not exists users (
      user_id serial,
      username VARCHAR ( 50 ) UNIQUE NOT NULL,
      password VARCHAR ( 50 ) NOT NULL, /* HASHED */
      email VARCHAR ( 255 ) UNIQUE NOT NULL,
--                          role_id serial NOT NULL,
      created_on TIMESTAMP DEFAULT now(),
--                          last_login TIMESTAMP,
      PRIMARY KEY (user_id)
--                          CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES role (role_id)
);

-- Login tokens / session
CREATE TABLE if not exists login_tokens (
        token_id serial,
        user_id integer,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

-- Password recovery tokens
CREATE TABLE if not exists password_recovery_tokens (
        password_recovery_id serial,
        password_recovery_token VARCHAR (200) NOT NULL UNIQUE,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id integer,
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

-- Activate account tokens
CREATE TABLE if not exists activate_account_tokens (
        activate_account_id serial,
        activate_account_token VARCHAR (200) NOT NULL UNIQUE,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id VARCHAR (20),
        created_on TIMESTAMP DEFAULT now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
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

CREATE TABLE if not exists cart (
        cart_id serial PRIMARY KEY,
        quantity integer NOT NULL,
        model_id integer,
        user_id integer,
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES models (model_id) NOT NULL,
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

-- reset_password table
CREATE TABLE if not exists reset_password_tokens (
        reset_token_id serial,
        token_code varchar (200) UNIQUE NOT NULL,
        user_id serial NOT NULL,
        created_on TIMESTAMP now(),
        expires_on TIMESTAMP DEFAULT now() + '30 minute'::interval
        PRIMARY KEY (reset_token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

-- Login tokens
CREATE TABLE if not exists login_tokens (
        login_token_id serial,
        user_id integer,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP NOT NULL,
        expires_on TIMESTAMP DEFAULT now() + '180 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

-- Activate account tokens
CREATE TABLE if not exists activate_account_tokens (
        activate_token_id serial,
        user_id integer,
        token_code varchar (200) UNIQUE NOT NULL,
        created_on TIMESTAMP NOT NULL,
        expires_on TIMESTAMP DEFAULT now() + '2880 minute'::interval,
        PRIMARY KEY (token_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);

CREATE table enabled_users (
        enabled_users_id serial,
        user_id integer,
        enabled_bool boolean NOT NULL ,
        PRIMARY KEY (enabled_users_id),
        CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
)


-- Products Related


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
        CONSTRAINT product_brand_id FOREIGN KEY (product_brand_id) REFERENCES brands (product_brand_id),
        CONSTRAINT product_category_id FOREIGN KEY (product_category_id) REFERENCES categories (product_category_id)
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

-- model_image table
CREATE TABLE if not exists model_images (
        model_id serial PRIMARY KEY,
        model_id integer,
        image_file_name VARCHAR(100), -- 100 Caracters hauria destar sobrat.
        created_on TIMESTAMP DEFAULT now(),
        CONSTRAINT product_id FOREIGN KEY (product_id) REFERENCES products (product_id) NOT NULL,
        PRIMARY KEY (model_id)
);


-- Supply table
CREATE TABLE if not exists supplies (
        supply_id serial PRIMARY KEY,
        model_id integer,
        quantity integer NOT NULL,
        updated_on TIMESTAMP DEFAULT now(),
        CONSTRAINT model_id FOREIGN KEY (model_id) REFERENCES products (model_id) NOT NULL,
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




-- Orders Related

-- Orders table
CREATE TABLE if not exists orders (
    order_id serial PRIMARY KEY,
    payment_id integer,
    oder_date TIMESTAMP DEFAULT now(),
    CONSTRAINT payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id) NOT NULL,
    PRIMARY KEY (order_id)
);

-- Payments table
CREATE TABLE if not exists payments (
    payment_id serial PRIMARY KEY,
    payment_method_id serial
);

-- Payments_memthods table
CREATE TABLE if not exists payment_methods (
        payment_method_id serial PRIMARY KEY,
        random_thing_to_store VARCHAR (20),
        CONSTRAINT payment_id FOREIGN KEY (payment_id) REFERENCES payments (payment_id) NOT NULL,

);

-- Address table
CREATE TABLE if not exists address (
     address_id serial PRIMARY KEY,
     user_id integer,
     addr_1 VARCHAR (40) NOT NULL,
     addr_2 VARCHAR (40),
     addr_3 VARCHAR (40),
     province VARCHAR (30) NOT NULL ,
     country VARCHAR (2) NOT NULL, -- Sigles...
     postal_code VARCHAR (16) NOT NULL
     CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (user_id) NOT NULL
);


-- Falta:

-- Triggers
-- Routine



-- CREATE TABLE test (
--     id serial,
--     value VARCHAR (20),
--     PRIMARY KEY (id)
-- )

-- insert into test (value) values ('first_try');