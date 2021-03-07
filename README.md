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

```yaml
PHP & JS & POSTGRESQL:
    username: "^[a-zA-Z0-9_.-.+]{6,20}$"
    password: "^[a-zA-Z0-9$%.,?!@+_=-]{6,20}$"
    email:  "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$"
```

## ERROR CODES

```yaml
        '0':'Unknown error',

        '1':'Success',

        '2':'Missing field(s)',
        '2.1':'Username field is missing',
        '2.2':'Password field is missing',
        '2.3':'Email field is missing',
        '2.4':'Repeat password field is missing',
        '2.5':'Repeat email field is missing',

        '3':'Requirements not achieved',
        '3.1':'Username does not meet the requirements',
        '3.2':'Password does not meet the requirements',
        '3.3':'Email does not meet the requirements',

        '4':'Field matching',
        '4.1':'Passwords don\'t match',
        '4.2':'Emails don\'t match',

        '5':'Client-Server errors',
        '5.1':'There was a unknown error sending the data, please, try again bit later, if this error is consistent please contact an administrator.',
        '5.2':'Server under maintenance, please, try again bit later.'

        '6':'Database side error'
        '6.1':'Data Insert errors',
        '6.1.1':'Username is already in use',
        '6.1.2':'Email is already in use',
          
        '6.2':'Data Select errors',
        '6.2.1':'Username not found',
        '6.2.2':'User_id not found',
        '6.2.3':'Email not found',
        '6.2.4':'Token not found',

        '6.3':'Tokens',
        '6.3.1':'Token not valid',
        '6.3.2':'Token already used',
        '6.3.3':'Token expired',
        '6.3.4':'Token is null or empty',
        
        '6.4':'Database connection error',
        '6.4.1':'Error communicating to database',
        '6.4.2':'Wrong credentials connecting to database',
        '6.4.3':'The user don\'t has permission for the requested action(s)',
        

        '7':'Account related issues',
        '7.1':'The account is not activated',
        '7.2':'The account is already activated',
        '7.3':'The account been banned', 
        
        '8': 'PHP mailer issues',
        '8.1': 'Email couldn\'t be send',
        '8.2': 'Email address is missing',
        '8.3': 'Body is missing',
        '8.4': 'Subject is missing',

        '9': 'Invalid Credentials',
          

```

### ERROR MESSAGES HINTS

```yaml
  '3.1': 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."',
  '3.2': 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%/.,?!@+_=-"',
  '3.3': 'The given email is invalid'
```