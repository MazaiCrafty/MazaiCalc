<?php

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc;

use mazaicrafty\calc\interfaces\iCalculable;

class Calculate implements iCalculable{

    public static function addition($saved_num, $input_num){
        return $saved_num + $input_num;
    }
    
    public static function subtraction($saved_num, $input_num){
        return $saved_num - $input_num;
    }

    public static function multiplication($saved_num, $input_num){
        return $saved_num * $input_num;
    }

    public static function division($saved_num, $input_num){
        return $saved_num / $input_num;
    }

    public static function cos($num){
        return cos($num);
    }

    public static function sin($num){
        return sin($num);
    }

    public static function tan($num){
        return tan($num);
    }

    public static function square($num){
        return $num * $num;
    }

    public static function squareRoot($num){
        return sqrt($num);
    }
}
