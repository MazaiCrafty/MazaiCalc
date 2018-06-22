<?php

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc;

use \Exception;
use pocketmine\Player;

class Process{

    public static function addition($temp, $num, Player $player){
        try{
            if (!(preg_match("/^[0-9]+$/", $num))){
                throw new Exception(0);
                return;
            }

            return $temp + $num;
        }
        catch (Exception $e){
            Temp::tempNum($e->getMessage(), $player);
        }
    }
    
    public static function subtraction($temp, $num, Player $player){
        try{
            if (!(preg_match("/^[0-9]+$/", $num))){
                throw new Exception(0);
                return;
            }

            return $temp - $num;
        }
        catch (Exception $e){
            Temp::tempNum($e->getMessage(), $player);
        }
    }

    public static function multiplication($temp, $num, Player $player){
        try{
            if (!(preg_match("/^[0-9]+$/", $num))){
                throw new Exception(0);
                return;
            }

            return $temp * $num;
        }
        catch (Exception $e){
            Temp::tempNum($e->getMessage(), $player);
        }
    }

    public static function division($temp, $num, Player $player){
        try{
            if (!(preg_match("/^[0-9]+$/", $num))){
                throw new Exception(0);
                return;
            }

            return $temp / $num;
        }
        catch (Exception $e){
            Temp::tempNum($e->getMessage(), $player);
        }
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
