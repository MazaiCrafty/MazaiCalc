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

    public static function cos($saved_num);

    public static function sin($saved_num);

    public static function tan($saved_num);
}
