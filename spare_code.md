### PHP email validation test
```php
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
$email= filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
 ($email){
   echo $email;
} else
{echo '!!';}
```

### function is_alphanumeric
```postgresql
CREATE or replace function is_alphanumeric(p_string varchar)
    returns boolean as $$
declare
v_string bool;
begin
    select into v_string (
        case when exists (
        select regexp_matches(p_string,'^[a-zA-Z0-9]+$')
        )
        then 1
        else 0
        end );
    return v_string; /*return true or false if email matches regex*/
end; $$ language plpgsql;
```