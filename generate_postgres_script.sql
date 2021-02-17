
-- Tables
-- Users Related

-- Customers table
CREATE TABLE if not exists users (
                          user_id serial PRIMARY KEY,
                          username VARCHAR ( 50 ) UNIQUE NOT NULL,
                          password VARCHAR ( 50 ) NOT NULL, /* HASHED */
                          email VARCHAR ( 255 ) UNIQUE NOT NULL,
                          role serial NOT NULL,
                          created_on TIMESTAMP NOT NULL,
                          last_login TIMESTAMP
);

-- Roles table
CREATE TABLE if not exists roles (
                        role_id serial PRIMARY KEY,
                        role_name VARCHAR (20) UNIQUE NOT NULL
);

-- reset_password table
CREATE TABLE if not exists reset_password_tokens (
                                                     reset_token_id serial PRIMARY KEY,
                                                     token_code varchar (200) UNIQUE NOT NULL,
                                                     user_id serial NOT NULL,
                                                     created_on TIMESTAMP NOT NULL,
                                                     expires_on TIMESTAMP NOT NULL
); -- Nomes 1 actiu

-- Login tokens
CREATE TABLE if not exists login_tokens (
                                            token_id serial PRIMARY KEY,
                                            token_code varchar (200) UNIQUE NOT NULL,
                                            created_on TIMESTAMP NOT NULL,
                                            expires_on TIMESTAMP NOT NULL
);




-- Products Related


-- Product table
CREATE TABLE if not exists products (
                          product_id serial PRIMARY KEY,
                          product_name VARCHAR ( 70 ) UNIQUE NOT NULL,
                          product_category_id serial,
                          product_brand_id serial,
--                           price decimal (10,2), -- euros.  si no te preu es que no esta disponible encara (falta sortir el producte), Now models has the price
                          description TEXT, -- Description of the product to be inserted in the database., no text, now models has the decription
--                           limit_per_order integer, -- Limit per command
                          created_on TIMESTAMP NOT NULL
);

-- Additional_models table

-- La idea dels models es per diferents colors, pero els colors poden tindre ofertes o preus diferents, per exemple el blanc o el negre son mes barats que els altres
CREATE TABLE if not exists prod_models (
                                        model_id serial PRIMARY KEY,
                                        product_id serial NOT NULL,
                                        model_name VARCHAR ( 70 ) UNIQUE NOT NULL,
--                                         model_category_id serial, # ?
--                                         product_brand_id serial,
                                        price decimal (10,2), -- euros.  si no te preu es que no esta disponible encara (falta sortir el producte)
                                        description TEXT, -- Description of the product to be inserted in the database.
                                        limit_per_order integer, -- Limit per command
                                        created_on TIMESTAMP NOT NULL
);

-- model_image table
CREATE TABLE if not exists model_images (
                                           image_id serial PRIMARY KEY,
                                           model_id serial NOT NULL ,
                                           image_file_name VARCHAR(100), -- 100 Caracters hauria destar sobrat.
                                           created_on TIMESTAMP NOT NULL
);



-- Supply table
CREATE TABLE if not exists supplies (
                          supply_id serial PRIMARY KEY,
                          model_id serial NOT NULL,
                          quantity integer NOT NULL,
                          updated_on TIMESTAMP NOT NULL
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
    payment_id serial
);

-- Payments table
CREATE TABLE if not exists payments (
    payment_id serial PRIMARY KEY,
    payment_method_id serial
);

-- Payments_memthods table
CREATE TABLE if not exists payment_methods (
                                        payment_method_id serial PRIMARY KEY
);

-- Address table
CREATE TABLE if not exists address (
     address_id serial PRIMARY KEY,
     user_id serial NOT NULL,
     addr_1 VARCHAR (40) NOT NULL,
     addr_2 VARCHAR (40),
     addr_3 VARCHAR (40),
     province VARCHAR (30) NOT NULL ,
     country VARCHAR (2) NOT NULL, -- Sigles...
     postal_code VARCHAR (16) NOT NULL
);


-- Falta:

-- Triggers

-- View

-- Routine