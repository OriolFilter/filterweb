# Databases

	- shop_db

### OLD NOTES

	- Customers -> accounts

	- Roles # Admin/moderator/customer/etc

	- Payment Methods # Prompt at config or cart  # Only aviable to customers

	- Directions # Prompt at config or cart # Only aviable to customers

	- Workers # Admins/Moderators/etc?? Not priority (changed for roles)

	- Order # No, won't do orders, no reason, just do some design and that's it.

	- Passwords then later create passwords_sha? # NVM ATM

    - Session # Tokens (sha)

    - passwd -> sha 256 -> store
    - token (50 chars?)-> sha 256 -> store

# customers@shop_db

# Tables

## Users tables

```postgresql

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

```

### Products tables

```postgresql

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
```

#### Nice example

> https://blog.saleslayer.com/hs-fs/hubfs/storediagram.gif?width=772&name=storediagram.gif


### Orders tables

```postgresql


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
```

#### Nice example
>  https://www.researchgate.net/profile/Ali_El-Bastawissy/publication/257517242/figure/fig12/AS:268039094534190@1440916908998/Relational-schema-DS2-for-products-orders-database.png

# Falta

# Relacions

## Users
> Users 1:1 Role
> Users 1:N Login_token
> Users 1:N Password_reset_token

[comment]: <> (> Users 1:N Payment_methods)
> Users 1:N Shipping_address

# Login Tokens
> Login_token 1:1 User

## Products
> Products 1:N Categories\
> Products 1:N Models Addicionals\
> Products 1:N Categories\
> Products 1:1 Brand\

## Models

> Models N:1 Products\
> Models 1:N Images\
> Models 1:N Supplies\

# Orders
> Order 1:1 Payment\
> Order 1:1 Shipping_address\

# Order_details
> Order_detail 1:1 Order\
> Order_detail 1:N Products\
> Order_detail 1:N Quantity\

# Payments
> Payment 1:1 Payment_methods

[comment]: <> (> Models 1:Sales # NO CONTA)

> No es registren les targetes de credit, nomes es validen, a nivell real fariesn servir alguna aplicacio d'un banc ja que es molta responsabilitat.

# Sales no es fara fins el final, ja que poden ser ofertes de categoria, de marca, de model o de producte.


## Triggers


## View

## Routine


