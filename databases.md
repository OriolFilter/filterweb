# Databases

	- shop_db

# USERS tables@shop_db

	- Customers -> accounts

	- Roles # Admin/moderator/customer/etc

	- Payment Methods # Prompt at config or cart  # Only aviable to customers

	- Directions # Prompt at config or cart # Only aviable to customers

	- Workers # Admins/Moderators/etc?? Not priority

	- Order # No, won't do orders, no reason, just do some design and that's it.

	- Passwords then later create passwords_sha? # NVM ATM

# customers@shop_db

```postgresql
-- Customers table
CREATE TABLE accounts (
	user_id serial PRIMARY KEY,
	username VARCHAR ( 50 ) UNIQUE NOT NULL,
	password VARCHAR ( 50 ) NOT NULL, /* HASHED */
	email VARCHAR ( 255 ) UNIQUE NOT NULL,
	created_on TIMESTAMP NOT NULL,
        last_login TIMESTAMP 
);
```

Nice example

https://blog.saleslayer.com/hs-fs/hubfs/storediagram.gif?width=772&name=storediagram.gif

# Product tables@shop_db

	-

