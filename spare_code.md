### PHP email validation test
```php
$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
$email= filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
if ($email){
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


### Old functions from register.js

```js
function response_response(response_code){
    // 0 Unknown
    // 1 Success
    // 2 Error on login, might be wrong username or password
    // 3 Missing field
    // Can be done with switch? yes, but if it's faster unless there be a long list, and yet, if just will be faster for the last entries.
    // Error too much attempts wait a little?
    var code=parseInt(response_code);
    if (code == 1){
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Login Success!\n";
        //redirect to index?
        //.php can have a redirect page
    }
    else if (code == 2)
    {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: Wrong password or username!\n";
    }
    else if (code == 3)
    {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: Missing field!\n";
    }
    else {
        //    Unknown error
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Unknown error, if this error is persistent contact with the administrator!\n";
    }
}
```
```js
function post(form,fields,root_url) {
    var url='https://'+root_url+'/login_form/';
    var query='?';

    //start manual concat
    var l = fields.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        if (query != '?') {
            query+='&';
        }
        fieldname=fields[i];
        query+=fieldname+'='+document.forms['logInForm'][fieldname].value;
    }

    //end manual concat
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.onreadystatechange = function() {
        if(objXMLHttpRequest.readyState === 4) {
            if(objXMLHttpRequest.status === 200) {
                response_response(objXMLHttpRequest.responseText);
                // response_response(0);

            } else {
                // alert('Error Code: ' +  objXMLHttpRequest.status);
                // alert('Error Message: ' + objXMLHttpRequest.statusText);
                response_response(0);
            }

        }
    }
    objXMLHttpRequest.open('GET', url+query,true);
    objXMLHttpRequest.send();
}
```
```js
function check_form(form,fields_to_check){
    var l = fields_to_check.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        fieldname = fields_to_check[i];
        // (fieldname);
        // if (document.forms["logInForm"][fieldname].value === "") {
        if (form[fieldname].value === "") {
            return 3;
        }
    } //Check no empty fields

    // Further (manual) checking

    // All gucci
    return 1;
}
```

### Old postgresql error codes
```
/* Errcode table
-- Data validation
-- P0000
-- P0001 username
-- P0001-A Valid characters (not used)
-- P0001-B Password length characters (not used)
-- P0002 password
-- P0003 email

-- Select errors not found
-- P0010 u_id wasn't found

-- Duplicated values
-- P0021 duplicated username
-- P0023 duplicated email


-- Query not desired result
-- P0030 user_id not found
-- P0031 username not found
-- P0034 account is already enabled

-- Working with activation tokens
-- P0040 token not found/not valid
-- P0041 token expired
-- P0042 token used
-- P0043 user already enabled
*/
```