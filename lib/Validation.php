<?php
class Validation{


    /**
     * @param array $fields
     * @return bool
     */
    public function areFieldsEmpty(array $fields){
        foreach($fields as $field){
            if($field == ""){
                return true;
            }
        }

        return false;
    }

    public function getFieldLength($field){
        return strlen($field);
    }

    public function preg_match($pattern, $str){
        return preg_match($pattern, $str);
    }

    public function isEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}