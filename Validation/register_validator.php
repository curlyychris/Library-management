<?php
require_once 'common_validator.php';
class RegisterValidator{
    static function validateLibrarian(? string $email, ? string $password, ? string $name, ? string $confirmPassword): ? string
    {
      return CommonValidator::getFirstNotNull([
        CommonValidator::isLengthGreaterThan($name, 2, "Name must be at least 3 characters long"),
        CommonValidator::isEmailValid($email, "Invalid email address"),
        CommonValidator::isValueGreaterThan($password, 5, "Password must be at least 6 characters long"),
        CommonValidator::isEqual($password, $confirmPassword, "Passwords do not match"),
      ]);
    }

    static function validateMember(? string $email, ? string $password, ? string $name, ? string $contact, ? string $membershipId, ? string $confirmPassword): ? string
    {
      return CommonValidator::getFirstNotNull([
        CommonValidator::isLengthGreaterThan($name, 2, "Name must be at least 3 characters long"),
        CommonValidator::isLengthGreaterThan($contact, 7, "Contact must be at least 8 digits long"),
        CommonValidator::isValueNull($membershipId, "Membership ID cannot be empty"),
        CommonValidator::isEmailValid($email, "Invalid email address"),
        CommonValidator::isLengthGreaterThan($password, 5, "Password must be at least 6 characters long"),
        CommonValidator::isEqual($password, $confirmPassword, "Passwords do not match"),
      ]);
    }
    
}
