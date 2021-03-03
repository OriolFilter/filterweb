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

old validate_username (equals old validate_email and old is_alphanumeric)
```postgresql
CREATE or replace procedure validate_username(p_uname varchar)
as $$
declare
    v_uname bool;
begin
    /* Segurament case sigui millor*/
    select into v_uname (
                           case when exists (
                                   select regexp_matches(p_uname,'^[a-zA-Z0-9._.-.+]+$')
                               )
                                    then 1
                                else 0
                               end );
    if not v_uname then
--         raise exception 'not_valid_email';
        raise exception
            using errcode = 'P0001',
                message = 'The username given does not meet the requirements.';
    end if; /*raises exception if email matches regex*/
    /* text@text.text */
end; $$ language plpgsql;
```

### create_user
```postgresql
CREATE or replace procedure create_user(p_user users.username%TYPE, p_passwd varchar,p_email varchar)
as $$
declare
--     not_valid_email exception;
--     row text;
BEGIN
call validate_username(p_user);
call validate_password(p_passwd);
call validate_mail(p_email);
--     insert into
insert into users(username, password, email) values (p_user,crypt(p_passwd, gen_salt('bf',8)),cast(encode(cast(p_email as bytea),'hex') as bytea));
commit;
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
```