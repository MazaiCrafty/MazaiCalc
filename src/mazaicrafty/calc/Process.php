<?php

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc;

class Process{

    public static function addition($temp, $num){
        return $temp + $num;
    }
    
    public static function subtraction($temp, $num){
        return $temp - $num;
    }

    public static function multiplication($temp, $num){
        return $temp * $num;
    }

    public static function division($temp, $num){
        return $temp / $num;
    }

    public static function cos($temp){
        return cos($temp);
    }

    public static function sin($temp){
        return sin($temp);
    }

    public static function tan($temp){
        return tan($temp);
    }
}
