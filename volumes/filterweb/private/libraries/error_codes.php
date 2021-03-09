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
    public  function formatJson(&$json_obj){

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
    public $error_code = '6.3.2';
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
    public $hint = 'Text message must be from 20 to 255 characters';
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
    public $error_code = '2.3';
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



?>