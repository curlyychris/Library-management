<?php
require_once 'common_validator.php';
class LoginValidator{
    static function validate(? string $email, ? string $password): ? string
    {
        $emailError = CommonValidator::isEmailValid($email, "Invalid email address");
        $passwordError = CommonValidator::isLengthGreaterThan($password, 5, errorMessage: "Password must be at least 6 characters long");
        if ($emailError) {
            return $emailError;
        }
        if ($passwordError) {
            return $passwordError;
        }
        return null;
    }
}