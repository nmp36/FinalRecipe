<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of FormGenerator
*
* @author Harsha
*/
class FormGenerator {

    public function generate($schemaObject) {
        $element = "";
        $array = array();

        $object = (array) $schemaObject;
        reset($object);

        foreach ($object as $key => $value) {
            if (stristr($key, "sorted")) {
                $array = array_merge($array, $value);
            }
        }

        ksort($array);

        foreach ($array as $value) {
            switch ($value) {
                case strcasecmp(stristr($value, "_txt"), "_txt"):
                    $ctrlNm = trim(stristr("$value", "_txt", true));
                    $element = $element . "<label'>" . ucwords($ctrlNm) . "</label>";
                    $element = $element . '<input type = "text" name = "' . $ctrlNm . '">';
                    $element = $element . "<br>";
                    break;
            }
        }

        if (strlen($element) > 0) {
            echo $element;
        }
    }

}

?>