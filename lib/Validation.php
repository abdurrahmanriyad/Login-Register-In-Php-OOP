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
}