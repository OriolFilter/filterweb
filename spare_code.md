PHP email validation test
```php
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
$email= filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
 ($email){
   echo $email;
} else
{echo '!!';}
```