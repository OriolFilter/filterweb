<?php
interface DefinedErrors {}

# Main Class
class CustomError extends Exception {
//    public $var;
    public string $status_code = '0';
    public string $error_code = '0';
    public $message = 'Unknown error';
    public string $status = 'failed';
    public string $hint ='';
    public function __construct()
    {
        /* Console logs */
        parent::__construct();
        error_log('ERROR');
        error_log(sprintf('> Code %s',$this->error_code));
        error_log(sprintf('>> Message %s',$this->message));
        error_log(sprintf('>>> Hint %s',$this->hint));
    }


    public function formatJson(&$json_obj){
        echo ($this->status_code?$this->status:null);
        $json_obj->status = $this->status?htmlspecialchars($this->status):null; /* ta b */
        $json_obj->status_code = $this->status_code?htmlspecialchars($this->status_code):null; /* ta b */
        $json_obj->error['code'] = $this-> error_code?htmlspecialchars($this-> error_code):null;
        $json_obj->error['message'] = $this->message?htmlspecialchars($this->message):null;
        $json_obj->error['hint'] = $this->hint?htmlspecialchars($this->hint):null;
    }
}

# UnknownError
class UnknownError  extends CustomError  implements DefinedErrors {/* Default values match unknown error*/
    public string $status_code = '0';
    public string $error_code = '0';
    public $message = 'Unknown error';
    public string $status = 'failed';}

# PHPMailer
class MailerSendError  extends CustomError  implements DefinedErrors {
    public string $error_code = '8.1';
    public $message = 'Email couldn\'t be send';
}
class MailerMissingAddressError  extends CustomError  implements DefinedErrors {
    public string $error_code = '8.2';
    public $message = 'Email address is missing';
}
class MailerMissingBodyError  extends CustomError  implements DefinedErrors {
    public string $error_code = '8.3';
    public $message = 'Body is missing';
}
class MailerMissingSubjectError  extends CustomError  implements DefinedErrors {
    public string $error_code = '8.4';
    public $message = 'Subject is missing';
}

# Register errors
class UsernameAlreadyExistsError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.1.1';
    public $message = 'Username is already exists';
}
class UserEmailExistsError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.1.2';
    public $message = 'Email is already in use';
}

# Token (password recovery - activate account - login/session)
class TokenNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.3.1';
    public $message = 'Token not valid';
    public string $hint = 'Token not valid';
}
class TokenExpiredError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.3.2';
    public $message = 'Token not valid';
    public string $hint = 'Token expired';
}
class TokenNullOrEmptyError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.3.4';
    public $message = 'Token not valid';
    public string $hint = 'Token is null or empty';
}
class TokenAlreadyUsedError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.3.3';
    public $message = 'Token not valid';
    public string $hint = 'Token already used';
}
class GenerateTokenError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.5.1';
    public $message = 'Error generating token';
}

# Accounts
class AccountNotActivatedError  extends CustomError  implements DefinedErrors {
    public string $error_code = '7.1';
    public $message = 'The account is not activated, an email should be sent soon';
}
class AccountAlreadyActivatedError  extends CustomError  implements DefinedErrors {
    public string $error_code = '7.2';
    public $message = 'The account is already activated';
}
class AccountIsBannedError  extends CustomError  implements DefinedErrors {
    public string $error_code = '7.3';
    public $message = 'The account been banned';
}

# Credentials manager
class InvalidCredentialsError  extends CustomError  implements DefinedErrors {
    public string $error_code = '9';
    public $message = 'Invalid Credentials';
    public string $hint = 'Check the username and password';
}

# Database
class DatabaseConnectionError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.4';
    public $message = 'Database connection error';
}
class DatabaseCommunicationError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.4.1';
    public $message = 'Database connection error';
    public string $hint = 'Error communicating to database';
}
class DatabaseCredentialsError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.4.1';
    public $message = 'Database connection error';
    public string $hint = 'Error communicating to database';
}
class DatabasePermissionsError  extends CustomError  implements DefinedErrors {
    public string $error_code = '6.4.3';
    public $message = 'Database connection error';
    public string $hint = 'The user don\'t has permission for the requested action(s)';
}

# Form Errors
class EmailNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.3';
    public $message = 'Email does not meet the requirements';
    public string $hint = 'The given email seems to be invalid';
}
class UsernameNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.1';
    public $message = 'Username does not meet the requirements';
    public string $hint = 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."';
}
class PasswordNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.3';
    public $message = 'Password does not meet the requirements';
    public string $hint = 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%.,?!@+_=-"';
}
class NameNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.4';
    public $message = 'Name does not meet the requirements';
    public string $hint = 'Name must be from 4 to 40 characters from the english alphabet or numbers';
}
class TextNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.5';
    public $message = 'Text does not meet the requirements';
    public string $hint = 'Text message must be from 20 to 400 characters';
}

# Payment method
//https://money.howstuffworks.com/personal-finance/debt-management/credit-card1.htm
class PaymentMethodNameNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.6';
    public $message = 'Payment method name does not meet the requirements';
    public string $hint = 'Payment method name needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9 and/or spaces or _';
}
class PaymentMethodDataNotValidError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.7';
    public $message = 'Payment method info does not meet the requirements';
    public string $hint = 'Payment method info must needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9';
}
class PaymentMethodIdError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.8';
    public $message = 'Payment method id does not meet the requirements';
    public string $hint = 'Payment method info must be a integer';
}

# Shipping address
class ShippingAddressCountryError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.1';
    public $message = 'Shipping address country field does not meet the requirements';
    public string $hint = 'Shipping address country needs to be 2 characters that represent the country following the standard ISO 3166-2';
}
class ShippingAddressCityError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.2';
    public $message = 'Shipping address city field does not meet the requirements';
}
class ShippingAddressPostalCodeError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.3';
    public $message = 'Shipping address postal code field does not meet the requirements';
}
class ShippingAddressLine1Error  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.4';
    public $message = 'Shipping address line 1 field does not meet the requirements';
    public string $hint = 'Shipping address line 1 needs to be from 5 to 200 characters'; // Unused
}
class ShippingAddressLine2Error  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.5';
    public $message = 'Shipping address line 2 field does not meet the requirements';
}
class ShippingAddressLine3Error  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.6';
    public $message = 'Shipping address line 3 field does not meet the requirements';
}
class ShippingAddressIdError  extends CustomError  implements DefinedErrors {
    public string $error_code = '3.9.7';
    public $message = 'Shipping address id does not meet the requirements';
    public string $hint = 'Shipping address id must be a integer'; // Unused
}

## Forms Missing fields
class MissingField  extends CustomError  implements DefinedErrors {
    public string $error_code = '2';
    public $message = 'Missing field(s)';
}
class MissingUsernameFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.1';
    public $message = 'Username field is missing';
}
class MissingPasswordFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.1';
    public $message = 'Password field is missing';
}
class MissingEmailFieldError  extends CustomError  implements DefinedErrors {
//    public string $error_code = '2.3';
    public $message = 'Email field is missing';
}
class MissingNameFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.6';
    public $message = 'Name field is missing';
}
class MissingTextFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.7';
    public $message = 'Text field is missing';
}
class MissingPaymentMethodNameFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.8';
    public $message = 'Payment method name field is missing';
}
class MissingPaymentMethodInfoFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.9';
    public $message = 'Payment method info field is missing';
}
class MissingPaymentMethodIdFieldError  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.10';
    public $message = 'Payment method id field is missing';
}
class MissingShippingAddressCountryField  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.11.1';
    public $message = 'Shipping address country field is missing';
}
class MissingShippingAddressCityField  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.11.2';
    public $message = 'Shipping address city field is missing';
}
class MissingShippingAddressPostalCodeField  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.11.3';
    public $message = 'Shipping address postal code field is missing';
}
class MissingShippingAddressLine1Field  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.11.4';
    public $message = 'Shipping address line 1 field is missing';
}
class MissingShippingAddressIdField  extends CustomError  implements DefinedErrors {
    public string $error_code = '2.11.5';
    public $message = 'Shipping address id field is missing';
}

## Select query
class UsernameNotFoundError extends CustomError  implements DefinedErrors {
    public string $error_code = '6.2.1';
    public $message = 'Username not found';
}
class UserIdNotFoundError extends CustomError  implements DefinedErrors {
    public string $error_code = '6.2.2';
    public $message = 'UserId not found';
}
class EmailNotFoundError extends CustomError  implements DefinedErrors {
    public string $error_code = '6.2.3';
    public $message = 'Email not found';
}
class PaymentMethodNotFoundError extends CustomError  implements DefinedErrors {
    public string $error_code = '6.2.5';
    public $message = 'Payment method not found';
}
class ShippingAddressFoundError extends CustomError  implements DefinedErrors {
    public string $error_code = '6.2.6';
    public $message = 'Shipping address not found';
}

## User Info
### PaymentMethods


class error_manager {
    /**
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
    function pg_error_handler ($c=''){
            if ($c == null or '') {
                return null;
            }
            switch (strval($c)) {
                /* c = code/$status*/
                case '':
                case null:
                case (!isset($c)):break; /* good */
                case 'P0000':throw new UnknownError();
                case 'P2000':throw new MissingField();
                case 'P2100':throw new MissingUsernameFieldError();
                case 'P2200':throw new MissingPasswordFieldError();
                case 'P2300':throw new MissingEmailFieldError();
        //            case 'P2400':throw new Missing();
        //            case 'P2500':throw new ;
                case 'P2600':throw new MissingNameFieldError();
                case 'P2700':throw new MissingTextFieldError();
                case 'P2800':throw new MissingPaymentMethodNameFieldError();
                case 'P2900':throw new MissingPaymentMethodInfoFieldError();
                case 'P2010':throw new MissingPaymentMethodIdFieldError(); //??
                case 'P2111':throw new MissingShippingAddressCountryField(); //??
                case 'P2112':throw new MissingShippingAddressCityField(); //??
                case 'P2113':throw new MissingShippingAddressPostalCodeField(); //??
                case 'P2114':throw new MissingShippingAddressLine1Field(); //??
                case 'P2115':throw new MissingShippingAddressIdField(); //??
                case 'P3100':throw new UsernameNotValidError();
                case 'P3200':throw new PasswordNotValidError();
                case 'P3300':throw new EmailNotValidError();
                case 'P3400':throw new NameNotValidError();
                case 'P3500':throw new TextNotValidError();
                case 'P3600':throw new PaymentMethodNameNotValidError();
                case 'P3700':throw new PaymentMethodDataNotValidError();
                case 'P3800':throw new PaymentMethodIdError();
                case 'P3901':throw new ShippingAddressCountryError();
                case 'P3902':throw new ShippingAddressCityError();
                case 'P3903':throw new ShippingAddressPostalCodeError();
                case 'P3904':throw new ShippingAddressLine1Error();
                case 'P3905':throw new ShippingAddressLine2Error();
                case 'P3907': # ShippingAddressLine3Error
                case 'P3906':throw new ShippingAddressLine3Error();
                case 'P6101':throw new UsernameAlreadyExistsError();
                case 'P6102':throw new UserEmailExistsError();
                case 'P6201':throw new UsernameNotFoundError();
                case 'P6202':throw new UserIdNotFoundError();
                case 'P6203':throw new EmailNotFoundError();
                case 'P6301': # TokenNotValidError
                case 'P6204':throw new TokenNotValidError(); /* Not valid -> not found */
                case 'P6205':throw new PaymentMethodNotFoundError(); /* Not valid -> not found */
                case 'P6206':throw new ShippingAddressFoundError(); /* Not valid -> not found */
                case 'P6302':throw new TokenAlreadyUsedError();
                case 'P6303':throw new TokenExpiredError();
                case 'P6304':throw new TokenNullOrEmptyError();
                case 'P6401':throw new DatabaseCommunicationError();
                case 'P6402':throw new DatabaseCredentialsError();
                case 'P6403':throw new DatabasePermissionsError();
                case 'P6501':throw new GenerateTokenError();
                case 'P7100':throw new AccountNotActivatedError();
                case 'P7200':throw new AccountAlreadyActivatedError();
                case 'P7300':throw new AccountIsBannedError();
                case 'P8100':throw new MailerSendError();
                case 'P8200':throw new MailerMissingAddressError();
                case 'P8300':throw new MailerMissingBodyError();
                case 'P8400':throw new MailerMissingSubjectError();
                case 'P9000':throw new InvalidCredentialsError();
                default:error_log('ERROR CODE FROM DATABASE >>>>'.$c);throw new UnknownError();
            }
        /* polymorphism?? */
        /* https://www.w3schools.com/java/java_polymorphism.asp */
    }




    }



?>