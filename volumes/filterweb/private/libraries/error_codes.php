<?php
class CustomError extends Exception{
    public $var;
    public $status_code = '0';
    public $error_code = '0';
    public $message = 'Unknown error';
    public $status = 'failed';
    public $hint = null;

    public  function formatJson($json_obj){
        $json_obj->status = $this->status; /* ta b */
        $json_obj->status_code = $this->status_code; /* ta b */
        $json_obj->error['code'] = $this->error_code;
        $json_obj->error['message'] = $this->message;
        $json_obj->hint = $this->hint;
    }
}




class MailerSendError extends CustomError {
    public $error_code = '8.1';
    public $message = 'Email couldn\'t be send';
    public $hint = null;
}
class MailerMissingAddressError extends CustomError {
    public $error_code = '8.2';
    public $message = 'Email address is missing';
    public $hint = null;
}
class MailerMissingBodyError extends CustomError {
    public $error_code = '8.3';
    public $message = 'Body is missing';
    public $hint = null;
}
class MailerMissingSubjectError extends CustomError {
    public $error_code = '8.4';
    public $message = 'Subject is missing';
    public $hint = null;
}

class EmailNotValidError extends CustomError {
    public $error_code = '3.3';
    public $message = 'Email does not meet the requirements';
    public $hint = null;
}
class UsernameNotValidError extends CustomError {
    public $error_code = '3.1';
    public $message = 'Username does not meet the requirements';
    public $hint = null;
}
class PasswordNotValidError extends CustomError {
    public $error_code = '3.3';
    public $message = 'Password does not meet the requirements';
    public $hint = null;
}

class MissingField extends CustomError {
    public $error_code = '2';
    public $message = 'Missing field(s)';
    public $hint = null;
}
class MissingUsernameFieldError extends CustomError {
    public $error_code = '2.1';
    public $message = 'Username field is missing';
    public $hint = null;
}
class MissingPasswordFieldError extends CustomError {
    public $error_code = '2.1';
    public $message = 'Password field is missing';
    public $hint = null;
}

class UserAlreadyExistsError extends CustomError {
    public $error_code = '6.1.1';
    public $message = 'Password does not meet the requirements';
    public $hint = null;
}
class UserEmailExistsError extends CustomError {
    public $error_code = '6.1.2';
    public $message = 'Email is already in use';
    public $hint = null;
}

class TokenNotValidError extends CustomError {
    public $error_code = '6.3.1';
    public $message = 'Token not valid';
    public $hint = 'Token not valid';
}
class TokenExpiredError extends CustomError {
    public $error_code = '6.3.2';
    public $message = 'Token not valid';
    public $hint = 'Token expired';
}
class TokenNullOrEmptyError extends CustomError {
    public $error_code = '6.3.4';
    public $message = 'Token not valid';
    public $hint = 'Token is null or empty';
}

class AccountNotActivatedError extends CustomError {
    public $error_code = '7.1';
    public $message = 'The account is not activated';
    public $hint = null;
}
class AccountAlreadyActivatedError extends CustomError {
    public $error_code = '7.2';
    public $message = 'The account is already activated';
    public $hint = null;
}
class AccountIsBannedError extends CustomError {
    public $error_code = '7.3';
    public $message = 'The account been banned';
    public $hint = null;
}

class InvalidCredentialsError extends CustomError {
    public $error_code = '9';
    public $message = 'Invalid Credentials';
    public $hint = 'Check the username and password';
}

class DatabaseConnectionError extends CustomError {
    public $error_code = '6.4';
    public $message = 'Database connection error';
    public $hint = null;
}
class DatabaseCommunicationError extends CustomError {
    public $error_code = '6.4.1';
    public $message = 'Database connection error';
    public $hint = 'Error communicating to database';
}
class DatabaseCredentialsError extends CustomError {
    public $error_code = '6.4.1';
    public $message = 'Database connection error';
    public $hint = 'Error communicating to database';
}
class DatabasePermissionsError extends CustomError {
    public $error_code = '6.4.3';
    public $message = 'Database connection error';
    public $hint = 'The user don\'t has permission for the requested action(s)';
}

class UnknownError extends CustomError {/* Default values match uknown error*/}



?>