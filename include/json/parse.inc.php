<?php
namespace json;
class Parse {

    public static function parseToArray($arr) {
        
        $newArr = array();

        foreach($arr as $val) {
            $newArr[] = json_decode($val['json'], true);
        }

        return $newArr;

    }

}

?>