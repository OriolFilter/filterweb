<?php
interface DefinedErrors {}

# Main Class
class CustomError extends Exception {
//    public $var;
    public string|null $status_code = '0';
    public string|null $error_code = '0';
    public $message = 'Unknown error';
    public string|null $status = 'failed';
    public string|null $hint ='';
    public function __construct()
    {
        /* Console logs */
        parent::__construct();
        error_log('ERROR');
        error_log(sprintf('> Code %s',$this->error_code));
        error_log(sprintf('>> Message %s',$this->message));
        error_log(sprintf('>>> Hint %s',$this->hint));
    }


    public function formatJson(json_response &$json_obj){
        $json_obj->status = htmlspecialchars($this->status??'');
        $json_obj->status_code = htmlspecialchars($this->status_code??'');
        $json_obj->error['code'] = $this-> error_code?htmlspecialchars($this-> error_code):'';
        $json_obj->error['message'] = $this->message?htmlspecialchars($this->message):'';
        $json_obj->error['hint'] = $this->hint?htmlspecialchars($this->hint):'';
    }
}

# UnknownError
class UnknownError  extends CustomError  implements DefinedErrors {/* Default values match unknown error*/
    public string|null $status_code = '0';
    public string|null $error_code = '0';
    public $message = 'Unknown error';
    public string|null $status = 'failed';}

# PHPMailer
class MailerSendError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '8.1';
    public $message = 'Email couldn\'t be send';
}
class MailerMissingAddressError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '8.2';
    public $message = 'Email address is missing';
}
class MailerMissingBodyError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '8.3';
    public $message = 'Body is missing';
}
class MailerMissingSubjectError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '8.4';
    public $message = 'Subject is missing';
}

# Register errors
class UsernameAlreadyExistsError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.1.1';
    public $message = 'Username is already exists';
}
class UserEmailExistsError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.1.2';
    public $message = 'Email is already in use';
}

# Token (password recovery - activate account - login/session)
class TokenNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.3.1';
    public $message = 'Token not valid';
    public string|null $hint = 'Token not valid';
}
class TokenExpiredError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.3.2';
    public $message = 'Token not valid';
    public string|null $hint = 'Token expired';
}
class TokenNullOrEmptyError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.3.4';
    public $message = 'Token not valid';
    public string|null $hint = 'Token is null or empty';
}
class TokenAlreadyUsedError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.3.3';
    public $message = 'Token not valid';
    public string|null $hint = 'Token already used';
}
class GenerateTokenError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.5.1';
    public $message = 'Error generating token';
}

# Accounts
class AccountNotActivatedError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '7.1';
    public $message = 'The account is not activated, an email should be sent soon';
}
class AccountAlreadyActivatedError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '7.2';
    public $message = 'The account is already activated';
}
class AccountIsBannedError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '7.3';
    public $message = 'The account been banned';
}

# Credentials manager
class InvalidCredentialsError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '9';
    public $message = 'Invalid Credentials';
    public string|null $hint = 'Check the username and password';
}

# Database
class DatabaseConnectionError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.4';
    public $message = 'Database connection error';
}
class DatabaseCommunicationError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.4.1';
    public $message = 'Database connection error';
    public string|null $hint = 'Error communicating to database';
}
class DatabaseCredentialsError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.4.1';
    public $message = 'Database connection error';
    public string|null $hint = 'Error communicating to database';
}
class DatabasePermissionsError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.4.3';
    public $message = 'Database connection error';
    public string|null $hint = 'The user don\'t has permission for the requested action(s)';
}

# Form Errors
class EmailNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.3';
    public $message = 'Email does not meet the requirements';
    public string|null $hint = 'The given email seems to be invalid';
}
class UsernameNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.1';
    public $message = 'Username does not meet the requirements';
    public string|null $hint = 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."';
}
class PasswordNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.3';
    public $message = 'Password does not meet the requirements';
    public string|null $hint = 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%.,?!@+_=-"';
}
class NameNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.4';
    public $message = 'Name does not meet the requirements';
    public string|null $hint = 'Name must be from 4 to 40 characters from the english alphabet or numbers';
}
class TextNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.5';
    public $message = 'Text does not meet the requirements';
    public string|null $hint = 'Text message must be from 20 to 400 characters';
}

# Payment method
//https://money.howstuffworks.com/personal-finance/debt-management/credit-card1.htm
class PaymentMethodNameNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.6';
    public $message = 'Payment method name does not meet the requirements';
    public string|null $hint = 'Payment method name needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9 and/or spaces or _';
}
class PaymentMethodDataNotValidError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.7';
    public $message = 'Payment method info does not meet the requirements';
    public string|null $hint = 'Payment method info must needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9';
}
class PaymentMethodIdError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.8';
    public $message = 'Payment method id does not meet the requirements';
    public string|null $hint = 'Payment method info must be a integer';
}

# Shipping address
class ShippingAddressCountryError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.1';
    public $message = 'Shipping address country field does not meet the requirements';
    public string|null $hint = 'Shipping address country needs to be 2 characters that represent the country following the standard ISO 3166-2';
}
class ShippingAddressCityError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.2';
    public $message = 'Shipping address city field does not meet the requirements';
}
class ShippingAddressPostalCodeError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.3';
    public $message = 'Shipping address postal code field does not meet the requirements';
}
class ShippingAddressLine1Error  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.4';
    public $message = 'Shipping address line 1 field does not meet the requirements';
    public string|null $hint = 'Shipping address line 1 needs to be from 5 to 200 characters'; // Unused
}
class ShippingAddressLine2Error  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.5';
    public $message = 'Shipping address line 2 field does not meet the requirements';
}
class ShippingAddressLine3Error  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.6';
    public $message = 'Shipping address line 3 field does not meet the requirements';
}
class ShippingAddressIdError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '3.9.7';
    public $message = 'Shipping address id does not meet the requirements';
    public string|null $hint = 'Shipping address id must be a integer'; // Unused
}

## Forms Missing fields
class MissingField  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2';
    public $message = 'Missing field(s)';
}
class MissingUsernameFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.1';
    public $message = 'Username field is missing';
}
class MissingPasswordFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.1';
    public $message = 'Password field is missing';
}
class MissingEmailFieldError  extends CustomError  implements DefinedErrors {
//    public string|null $error_code = '2.3';
    public $message = 'Email field is missing';
}
class MissingNameFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.6';
    public $message = 'Name field is missing';
}
class MissingTextFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.7';
    public $message = 'Text field is missing';
}
class MissingPaymentMethodNameFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.8';
    public $message = 'Payment method name field is missing';
}
class MissingPaymentMethodInfoFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.9';
    public $message = 'Payment method info field is missing';
}
class MissingPaymentMethodIdFieldError  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.10';
    public $message = 'Payment method id field is missing';
}
class MissingShippingAddressCountryField  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.11.1';
    public $message = 'Shipping address country field is missing';
}
class MissingShippingAddressCityField  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.11.2';
    public $message = 'Shipping address city field is missing';
}
class MissingShippingAddressPostalCodeField  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.11.3';
    public $message = 'Shipping address postal code field is missing';
}
class MissingShippingAddressLine1Field  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.11.4';
    public $message = 'Shipping address line 1 field is missing';
}
class MissingShippingAddressIdField  extends CustomError  implements DefinedErrors {
    public string|null $error_code = '2.11.5';
    public $message = 'Shipping address id field is missing';
}

## Select query
class UsernameNotFoundError extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.2.1';
    public $message = 'Username not found';
}
class UserIdNotFoundError extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.2.2';
    public $message = 'UserId not found';
}
class EmailNotFoundError extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.2.3';
    public $message = 'Email not found';
}
class PaymentMethodNotFoundError extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.2.5';
    public $message = 'Payment method not found';
}
class ShippingAddressFoundError extends CustomError  implements DefinedErrors {
    public string|null $error_code = '6.2.6';
    public $message = 'Shipping address not found';
}

## User Info
### PaymentMethods


class error_manager {
    /**
     * @param string $c
     * @throws TokenNullOrEmptyError
     * @throws MissingShippingAddressPostalCodeField
     * @throws UsernameNotFoundError
     * @throws UsernameNotValidError
     * @throws DatabaseCredentialsError
     * @throws PaymentMethodDataNotValidError
     * @throws MissingShippingAddressIdField
     * @throws PaymentMethodIdError
     * @throws MissingShippingAddressCountryField
     * @throws MailerMissingAddressError
     * @throws MissingPasswordFieldError
     * @throws EmailNotValidError
     * @throws ShippingAddressLine3Error
     * @throws TokenAlreadyUsedError
     * @throws NameNotValidError
     * @throws EmailNotFoundError
     * @throws AccountNotActivatedError
     * @throws MissingUsernameFieldError
     * @throws MissingShippingAddressLine1Field
     * @throws PaymentMethodNameNotValidError
     * @throws DatabasePermissionsError
     * @throws AccountAlreadyActivatedError
     * @throws ShippingAddressLine1Error
     * @throws MissingTextFieldError
     * @throws ShippingAddressPostalCodeError
     * @throws PaymentMethodNotFoundError
     * @throws UsernameAlreadyExistsError
     * @throws MissingPaymentMethodIdFieldError
     * @throws DatabaseCommunicationError
     * @throws UnknownError
     * @throws MissingNameFieldError
     * @throws MissingPaymentMethodInfoFieldError
     * @throws TokenNotValidError
     * @throws AccountIsBannedError
     * @throws ShippingAddressFoundError
     * @throws UserIdNotFoundError
     * @throws MissingField
     * @throws MailerMissingSubjectError
     * @throws ShippingAddressLine2Error
     * @throws MailerMissingBodyError
     * @throws MissingShippingAddressCityField
     * @throws InvalidCredentialsError
     * @throws UserEmailExistsError
     * @throws TokenExpiredError
     * @throws ShippingAddressCountryError
     * @throws MissingEmailFieldError
     * @throws GenerateTokenError
     * @throws TextNotValidError
     * @throws PasswordNotValidError
     * @throws MailerSendError
     * @throws MissingPaymentMethodNameFieldError
     * @throws ShippingAddressCityError
     */
    function db_error_handler (string $c=''){
            if ($c == null or $c == '' or !isset($c) ) {
                return;
            }
            $ErrorArray=[
                "P0000" =>UnknownError::class,
                'P2000'=>MissingField::class,
                'P2100'=>MissingUsernameFieldError::class,
                'P2200'=>MissingPasswordFieldError::class,
                'P2300'=>MissingEmailFieldError::class,
                //'P2400'=>Missing::class,
                //'P2500'=>::class,
                'P2600'=>MissingNameFieldError::class,
                'P2700'=>MissingTextFieldError::class,
                'P2800'=>MissingPaymentMethodNameFieldError::class,
                'P2900'=>MissingPaymentMethodInfoFieldError::class,
                'P2010'=>MissingPaymentMethodIdFieldError::class, //??
                'P2111'=>MissingShippingAddressCountryField::class, //??
                'P2112'=>MissingShippingAddressCityField::class, //??
                'P2113'=>MissingShippingAddressPostalCodeField::class, //??
                'P2114'=>MissingShippingAddressLine1Field::class, //??
                'P2115'=>MissingShippingAddressIdField::class, //??
                'P3100'=>UsernameNotValidError::class,
                'P3200'=>PasswordNotValidError::class,
                'P3300'=>EmailNotValidError::class,
                'P3400'=>NameNotValidError::class,
                'P3500'=>TextNotValidError::class,
                'P3600'=>PaymentMethodNameNotValidError::class,
                'P3700'=>PaymentMethodDataNotValidError::class,
                'P3800'=>PaymentMethodIdError::class,
                'P3901'=>ShippingAddressCountryError::class,
                'P3902'=>ShippingAddressCityError::class,
                'P3903'=>ShippingAddressPostalCodeError::class,
                'P3904'=>ShippingAddressLine1Error::class,
                'P3905'=>ShippingAddressLine2Error::class,
                'P3907'=>ShippingAddressLine3Error::class,
                'P3906'=>ShippingAddressLine3Error::class,
                'P6101'=>UsernameAlreadyExistsError::class,
                'P6102'=>UserEmailExistsError::class,
                'P6201'=>UsernameNotFoundError::class,
                'P6202'=>UserIdNotFoundError::class,
                'P6203'=>EmailNotFoundError::class,
                'P6301'=>TokenNotValidError::class,
                'P6204'=>TokenNotValidError::class, /* Not valid -> not found */
                'P6205'=>PaymentMethodNotFoundError::class, /* Not valid -> not found */
                'P6206'=>ShippingAddressFoundError::class, /* Not valid -> not found */
                'P6302'=>TokenAlreadyUsedError::class,
                'P6303'=>TokenExpiredError::class,
                'P6304'=>TokenNullOrEmptyError::class,
                'P6401'=>DatabaseCommunicationError::class,
                'P6402'=>DatabaseCredentialsError::class,
                'P6403'=>DatabasePermissionsError::class,
                'P6501'=>GenerateTokenError::class,
                'P7100'=>AccountNotActivatedError::class,
                'P7200'=>AccountAlreadyActivatedError::class,
                'P7300'=>AccountIsBannedError::class,
                'P8100'=>MailerSendError::class,
                'P8200'=>MailerMissingAddressError::class,
                'P8300'=>MailerMissingBodyError::class,
                'P8400'=>MailerMissingSubjectError::class,
                'P9000'=>InvalidCredentialsError::class,
            ];
            throw new ($ErrorArray[$c]??UnknownError::class)();
    }
}
?>