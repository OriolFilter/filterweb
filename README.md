# FilterWeb

## Tematica

	Botiga online

## Diseny

	<header><logo/><div><nav/></div><div><buttons></div>></header>

	<content/>

	<footer><copyright></footer>

## Nav

	DraggableButton -> Producte > Brands

## Main content

	Highlighted product

## Product content

	Llista de productes -> php, no gaire complicat

	Sort By button -> php -> flexbox order, JS, facil

## Buttons 

	Account button -> Formulari -> mirar com fer cookies.

	ShopList -> Fer formulari amb un exemple,

	Contact

### Contact

	Direccio correu
	Telf
	GoogleMaps
	/
	Formulari



## REGEX
Recordar que fa falta guardar el correu en minuscules, i que fa falta comprobar que no estigui en la base de dades (select en minuscules i entrada en minuscules)
```yaml
PHP & JS:
  Registration:
    username: "^[a-zA-Z0-9_.-.+]{6,20}$"
    password: "^[a-zA-Z0-9$%.,?!@+_=-]{6,20}$"
    email:    "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$"
    
  Contact form:
    name:  "^[\w0-9 ]{4,40}$"
    email: "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$"
    text:  "^[\w\W]{20,255}$"
    
  Change password form:
    token: "^[a-zA-Z0-9]{60}$"
    
POSTGRESQL:
  Contact form:
    name:  "^[\w0-9 ]{4,40}$"
    text:  "^[\w\\W]{20,255}$"
    email: "^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$"

```

## ERROR CODES

```yaml
php & js:
        '0': 'Unknown error',

        '1': 'Success',

        '2': 'Missing field(s)',
        '2.1': 'Username field is missing',
        '2.2': 'Password field is missing',
        '2.3': 'Email field is missing',
        '2.4': 'Repeat password field is missing',
        '2.5': 'Repeat email field is missing',
        '2.6': 'Name field is missing',
        '2.7': 'Text field is missing',

        '3': 'Requirements not achieved',
        '3.1': 'Username does not meet the requirements',
        '3.2': 'Password does not meet the requirements',
        '3.3': 'Email does not meet the requirements',
        '3.4': 'Name does not meet the requirements',
        '3.5': 'Text does not meet the requirements',
        '3.6': 'Payment method name does not meet the requirements',
        '3.7': 'Payment method info does not meet the requirements',
        '3.8': 'Payment method id does not meet the requirements', # It's a numeric value only

        '4': 'Field matching',
        '4.1': 'Passwords don\'t match',
        '4.2': 'Emails don\'t match',

        '5': 'Client-Server errors',
        '5.1': 'There was a unknown error sending the data, please, try again bit later, if this error is consistent please contact an administrator.',
        '5.2': 'Server under maintenance, please, try again bit later.'

        '6': 'Database side error'
        '6.1': 'Data Insert errors',
        '6.1.1': 'Username is already exists',
        '6.1.2': 'Email is already exists',
          
        '6.2': 'Data Select errors',
        '6.2.1': 'Username not found',
        '6.2.2': 'User_id not found',
        '6.2.3': 'Email not found',
        '6.2.4': 'Token not found',
        '6.2.5': 'Payment method not found',

        '6.3': 'Tokens',
        '6.3.1': 'Token not valid',
        '6.3.2': 'Token already used',
        '6.3.3': 'Token expired',
        '6.3.4': 'Token is null or empty',
        
        '6.4': 'Database connection error',
        '6.4.1': 'Error communicating to database',
        '6.4.2': 'Wrong credentials connecting to database',
        '6.4.3': 'The user don\'t has permission for the requested action(s)',
          
        '6.5': 'Functions error',
        '6.5.1': 'Error generating token',
        

        '7': 'Account related issues',
        '7.1': 'The account is not activated',
        '7.2': 'The account is already activated',
        '7.3': 'The account been banned', 
        
        '8': 'PHP mailer issues',
        '8.1': 'Email couldn\'t be send',
        '8.2': 'Email address is missing',
        '8.3': 'Body is missing',
        '8.4': 'Subject is missing',

        '9': 'Invalid Credentials',
          
        '10': 'Product stuff',
          
        '11': 'User conf stuff',
        
        '11.2': 'Not valid payment method data'
        
        '12': 'Order Stuff'
postgresql:
  - 'Due postgresql not being able to use the same syntax as php and since the error codes seems easy to read using the syntax already done, it's been decided to leave the php and js codes as they, while using a similar (but valid) syntax for postgresql.'
  - 'P0000'
  - 'P + first number + second number +  last number'
  examples:
    - '7     :P7000'
    - '8.3   :P8300'
    - '6.4.4 :P6404'
```

### ERROR MESSAGES HINTS (update)

```yaml
  '3.1': 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."',
  '3.2': 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%/.,?!@+_=-"',
  '3.3': 'The given email is invalid',
  '3.4': 'Name must be from 4 to 40 characters from the english alphabet or numbers',
  '3.5': 'Text message must be from 20 to 255 characters'
```

### Javascript Tokens

```yaml
    't': # Tokens
      'cpt'='Change Password TOKEN (1 use)'
     
    #'i': #info?

```