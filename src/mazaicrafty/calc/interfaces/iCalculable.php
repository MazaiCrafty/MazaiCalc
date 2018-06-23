<?php

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc\interfaces;

interface iCalculable{
    public static function addition($saved_num, $input_num);

    public static function subtraction($saved_num, $input_num);

    public static function multiplication($saved_num, $input_num);

    public static function division($saved_num, $input_num);

    public static function cos($num);

    public static function sin($num);

    public static function tan($num);

    public static function square($num);

    public static function squareRoot($num);
}
