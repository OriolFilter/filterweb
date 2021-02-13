
-- Tables

-- Customers table
CREATE TABLE if not exists accounts (
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



-- Product table
CREATE TABLE if not exists products (
                          product_id serial PRIMARY KEY,
                          product_name VARCHAR ( 70 ) UNIQUE NOT NULL,
                          product_category_id serial,
                          product_brand_id serial,
                          price decimal (10,2), -- euros.  si no te preu es que no esta disponible encara (falta sortir el producte)
                          description TEXT, -- Description of the product to be inserted in the database.
                          limit_per_order integer, -- Limit per command
                          created_on TIMESTAMP NOT NULL
);


-- Supply table
CREATE TABLE if not exists supplies (
                          supply_id serial PRIMARY KEY,
                          product_id serial NOT NULL,
                          quantity integer NOT NULL,
                          created_on TIMESTAMP NOT NULL
);

-- Sales table
CREATE TABLE if not exists sales (
                       sale_id serial PRIMARY KEY,
                       product_id serial NOT NULL,
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


-- Login tokens
CREATE TABLE if not exists login_tokens (
                              token_id serial PRIMARY KEY,
                              token_code varchar (200) UNIQUE NOT NULL,
                              created_on TIMESTAMP NOT NULL,
                              expires_on TIMESTAMP NOT NULL
);

-- Falta: product_image orders, shipping


-- Triggers

-- View

-- View

-- Routine