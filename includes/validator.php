<?php
class Validator {
    public static function required($fields, $data) {
        $errors = [];
        foreach($fields as $field) {
            if(empty(trim($data[$field] ?? ''))) {
                $errors[$field] = "Le champ " . ucfirst($field) . " est requis.";
            }
        }
        return $errors;
    }

    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function password($pass, $min = 6) {
        return strlen($pass) >= $min;
    }

    public static function numeric($val) {
        return is_numeric($val) && $val >= 0;
    }
}
?>