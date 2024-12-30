<?php

class CommonValidator{

    static function isEmailValid(? string $email, string $errorMessage): ? string
    {
        if(is_null($email)){
            return $errorMessage;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $errorMessage;
        }
        return null;
    }

    static function isValueNull(? string $value, string $errorMessage): ? string
    {
        if (is_null($value)) {
            return $errorMessage;
        }
        return null;
    }

    static function isValueGreaterThan(? int $value, int $minValue, string $errorMessage): ? string
    {
        if(is_null($value)){
            return $errorMessage;
        }
        if ($value <= $minValue) {
            return $errorMessage;
        }
        return null;
    }
    static function isLengthGreaterThan(? string $value, int $minValue, string $errorMessage): ? string
    {
        if(is_null($value)){
            return $errorMessage;
        }
        if (strlen($value)<= $minValue) {
            return $errorMessage;
        }
        return null;
    }
    static function isEqual(? string $value1, ? string $value2, string $errorMessage): ? string
    {
        if(is_null($value1) || is_null($value2)){
            return $errorMessage;
        }
        if ($value1 !== $value2) {
            return $errorMessage;
        }
        return null;
    }
    static function getFirstNotNull(array $values): ? string
    {
        foreach ($values as $value) {
            if (!is_null($value)) {
                return $value;
            }
        }
        return null;

    }
}



