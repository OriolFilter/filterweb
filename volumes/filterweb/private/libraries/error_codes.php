<?php
interface DefinedErrors {}

# Main Class
class CustomError extends Exception {
    public $var;
    public $status_code = '0';
    public $error_code = '0';
    public $message = 'Unknown error';
    public $status = 'failed';
    public $hint = null;
    public function __construct()
    {

        error_log('ERROR');
        error_log(sprintf('> Code %s',$this->error_code));
        error_log(sprintf('>> Message %s',$this->message));
        error_log(sprintf('>>> Hint %s',$this->hint));
    }


    public function formatJson(&$json_obj){
        $json_obj->status = $this->status?htmlspecialchars($this->status):null; /* ta b */
        $json_obj->status_code = $this->status_code?htmlspecialchars($this->status_code):null; /* ta b */
        $json_obj->error['code'] = $this-> error_code?htmlspecialchars($this-> error_code):null;
        $json_obj->error['message'] = $this->message?htmlspecialchars($this->message):null;
        $json_obj->error['hint'] = $this->hint?htmlspecialchars($this->hint):null;
    }
}

# UnknownError
class UnknownError  extends CustomError  implements DefinedErrors {/* Default values match uknown error*/
    public $status_code = '0';
    public $error_code = '0';
    public $message = 'Unknown error';
    public $status = 'failed';}

# PHPMailer
class MailerSendError  extends CustomError  implements DefinedErrors {
    public $error_code = '8.1';
    public $message = 'Email couldn\'t be send';
}
class MailerMissingAddressError  extends CustomError  implements DefinedErrors {
    public $error_code = '8.2';
    public $message = 'Email address is missing';
}
class MailerMissingBodyError  extends CustomError  implements DefinedErrors {
    public $error_code = '8.3';
    public $message = 'Body is missing';
}
class MailerMissingSubjectError  extends CustomError  implements DefinedErrors {
    public $error_code = '8.4';
    public $message = 'Subject is missing';
}

# Register errors
class UsernameAlreadyExistsError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.1.1';
    public $message = 'Username is already exists';
}
class UserEmailExistsError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.1.2';
    public $message = 'Email is already in use';
}

# Token (password recovery - activate account - login/session)
class TokenNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.3.1';
    public $message = 'Token not valid';
    public $hint = 'Token not valid';
}
class TokenExpiredError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.3.2';
    public $message = 'Token not valid';
    public $hint = 'Token expired';
}
class TokenNullOrEmptyError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.3.4';
    public $message = 'Token not valid';
    public $hint = 'Token is null or empty';
}
class TokenAlreadyUsedError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.3.3';
    public $message = 'Token not valid';
    public $hint = 'Token already used';
}
class GenerateTokenError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.5.1';
    public $message = 'Error generating token';
}

# Accounts
class AccountNotActivatedError  extends CustomError  implements DefinedErrors {
    public $error_code = '7.1';
    public $message = 'The account is not activated';
}
class AccountAlreadyActivatedError  extends CustomError  implements DefinedErrors {
    public $error_code = '7.2';
    public $message = 'The account is already activated';
}
class AccountIsBannedError  extends CustomError  implements DefinedErrors {
    public $error_code = '7.3';
    public $message = 'The account been banned';
}

# Credentials manager
class InvalidCredentialsError  extends CustomError  implements DefinedErrors {
    public $error_code = '9';
    public $message = 'Invalid Credentials';
    public $hint = 'Check the username and password';
}

# Database
class DatabaseConnectionError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.4';
    public $message = 'Database connection error';
}
class DatabaseCommunicationError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.4.1';
    public $message = 'Database connection error';
    public $hint = 'Error communicating to database';
}
class DatabaseCredentialsError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.4.1';
    public $message = 'Database connection error';
    public $hint = 'Error communicating to database';
}
class DatabasePermissionsError  extends CustomError  implements DefinedErrors {
    public $error_code = '6.4.3';
    public $message = 'Database connection error';
    public $hint = 'The user don\'t has permission for the requested action(s)';
}

# Form Errors
class EmailNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '3.3';
    public $message = 'Email does not meet the requirements';
    public $hint = 'The given email seems to be invalid';
}
class UsernameNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '3.1';
    public $message = 'Username does not meet the requirements';
    public $hint = 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."';
}
class PasswordNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '3.3';
    public $message = 'Password does not meet the requirements';
    public $hint = 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%.,?!@+_=-"';
}
class NameNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '3.4';
    public $message = 'Name does not meet the requirements';
    public $hint = 'Name must be from 4 to 40 characters from the english alphabet or numbers';
}
class TextNotValidError  extends CustomError  implements DefinedErrors {
    public $error_code = '3.5';
    public $message = 'Text does not meet the requirements';
    public $hint = 'Text message must be from 20 to 400 characters';
}

## Forms Missing fields (unused in php)
class MissingField  extends CustomError  implements DefinedErrors {
    public $error_code = '2';
    public $message = 'Missing field(s)';
}
class MissingUsernameFieldError  extends CustomError  implements DefinedErrors {
    public $error_code = '2.1';
    public $message = 'Username field is missing';
}
class MissingPasswordFieldError  extends CustomError  implements DefinedErrors {
    public $error_code = '2.1';
    public $message = 'Password field is missing';
}
class MissingEmailFieldError  extends CustomError  implements DefinedErrors {
//    public $error_code = '2.3';
    public $message = 'Email field is missing';
}
class MissingNameFieldError  extends CustomError  implements DefinedErrors {
    public $error_code = '2.6';
    public $message = 'Name field is missing';
}
class MissingTextFieldError  extends CustomError  implements DefinedErrors {
    public $error_code = '2.7';
    public $message = 'Text field is missing';
}

## Select
class UsernameNotFoundError extends CustomError  implements DefinedErrors {
    public $error_code = '6.2.1';
    public $message = 'Username not found';
    public $hint = null;
}
class UserIdNotFoundError extends CustomError  implements DefinedErrors {
    public $error_code = '6.2.2';
    public $message = 'UserId not found';
    public $hint = null;
}
class EmailNotFoundError extends CustomError  implements DefinedErrors {
    public $error_code = '6.2.3';
    public $message = 'Email not found';
    public $hint = null;
}

class error_manager {
    function pg_error_handler ($c=''){
            if ($c == null or '') {
                return null;
            }
            switch (strval($c)) {
                /* c = code/$status*/
                case (!isset($c)): ;break; /* good */
                case '': ;break; /* good */
                case null: ;break; /* good */
                case 'P0000':throw new UnknownError();break;
                case 'P2000':throw new MissingField();break;
                case 'P2200':throw new MissingPasswordFieldError();break;
                case 'P2300':throw new MissingEmailFieldError();break;
        //            case 'P2400':throw new Missing();break;
        //            case 'P2500':throw new ;break;
                case 'P2600':throw new MissingNameFieldError();break;
                case 'P2700':throw new MissingTextFieldError();break;
                case 'P3100':throw new UsernameNotValidError();break;
                case 'P3200':throw new PasswordNotValidError();break;
                case 'P3300':throw new EmailNotValidError();break;
                case 'P3400':throw new NameNotValidError();break;
                case 'P3500':throw new TextNotValidError();break;
                case 'P6101':throw new UsernameAlreadyExistsError();break;
                case 'P6102':throw new UserEmailExistsError();break;
                case 'P6201':throw new UsernameNotFoundError();break;
                case 'P6202':throw new UserIdNotFoundError();break;
                case 'P6203':throw new EmailNotFoundError();break;
                case 'P6204':throw new TokenNotValidError();break; /* Not valid -> not found */
                case 'P6301':throw new TokenNotValidError();break;
                case 'P6302':throw new TokenAlreadyUsedError();break;
                case 'P6303':throw new TokenExpiredError();break;
                case 'P6304':throw new TokenNullOrEmptyError();break;
                case 'P6401':throw new DatabaseCommunicationError();break;
                case 'P6402':throw new DatabaseCredentialsError();break;
                case 'P6403':throw new DatabasePermissionsError();break;
                case 'P6501':throw new GenerateTokenError();break;
                case 'P7100':throw new AccountNotActivatedError();break;
                case 'P7200':throw new AccountAlreadyActivatedError();break;
                case 'P7300':throw new AccountIsBannedError();break;
                case 'P8100':throw new MailerSendError();break;
                case 'P8200':throw new MailerMissingAddressError();break;
                case 'P8300':throw new MailerMissingBodyError();break;
                case 'P8400':throw new MailerMissingSubjectError();break;
                case 'P9000':throw new InvalidCredentialsError();break;
                default:error_log('ERROR CODE FROM DATABASE >>>>'.$c);throw new UnknownError();break;
            }
//        }else{return true;};
        /* polymorphism?? */
        /* https://www.w3schools.com/java/java_polymorphism.asp */
    }




    }



?>