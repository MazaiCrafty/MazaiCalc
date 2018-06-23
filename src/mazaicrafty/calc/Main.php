<?php

declare(strict_types = 1);

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\Config;

use mazaicrafty\calc\Calculate;

class Main extends PluginBase{

    const CLEAR = 0;
    const ADDITION = 1;
    const SUBTRACTION = 2;
    const MULTIPLICATION = 3;
    const DIVISION = 4;
    const PI = 5;
    const COS = 6;
    const SIN = 7;
    const TAN = 8;
    const SQUARE = 9;
    const SQRT = 10;
    const CBRT = 11;

    private $form_api;

    public function onEnable(): void{
        $this->saveResource("Config.yml");

        $this->config = new Config($this->getDataFolder() . "Config.yml", Config::YAML);
        $this->form_api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        switch ($cmd->getName()){
            case "calc":
            if (!($sender instanceof Player)){
                $sender->sendMessage("Please execute this command in-game");
                return true;
            }
            $this->createForm($sender);
            return true;

            default:
            return false;
        }
    }

    public function createForm(Player $player): void{
        $form = $this->form_api->createCustomForm(
            function (Player $player, $data){
                if ($data === null) return;
                $type = $data[1];
                $input_num = (float) $data[0];
                $saved_num = Save::$num[$player->getName()];

                if (!(empty($input_num))){
                    if (!(is_numeric($input_num))){
                        $player->sendMessage($this->config->get("NUMERIC"));
                        return;
                    }                   
                }

                switch ($type){
                    case Main::CLEAR:
                    $result = 0;
                    break;

                    case Main::ADDITION:
                    $result = Calculate::addition($saved_num, $input_num);
                    break;

                    case Main::SUBTRACTION:
                    $result = Calculate::subtraction($saved_num, $input_num);
                    break;

                    case Main::MULTIPLICATION:
                    $result = Calculate::multiplication($saved_num, $input_num);
                    break;

                    case Main::DIVISION:
                    $result = Calculate::division($saved_num, $input_num);
                    break;

                    case Main::PI:
                    $result = 3.14159265358979;
                    break;

                    case Main::COS:
                    $result = Calculate::cos(!empty($input_num) ? $input_num : $saved_num);
                    break;

                    case Main::SIN:
                    $result = Calculate::cos(!empty($input_num) ? $input_num : $saved_num);
                    break;

                    case Main::TAN:
                    $result = Calculate::tan(!empty($input_num) ? $input_num : $saved_num);
                    break;

                    case Main::SQUARE:
                    $result = Calculate::square(!empty($input_num) ? $input_num : $saved_num);
                    break;

                    case Main::SQRT:
                    $result = Calculate::squareRoot(!empty($input_num) ? $input_num : $saved_num);
                    break;
                }
                if ($data === 0){
                    Save::saveNumber(0, $player);
                }
                Save::saveNumber($result, $player);
                $this->reCallForm($player);
            }
        );

        if (isset(Save::$num[$player->getName()])){
            $print = Save::$num[$player->getName()];
        }
        else{
            Save::saveNumber(0, $player);
            $print = Save::$num[$player->getName()];
        }

        $arithmetic[] = Save::$num[$player->getName()] === 0 ? 'CA' : 'C';
        $arithmetic[] = '+';
        $arithmetic[] = '-';
        $arithmetic[] = '×';
        $arithmetic[] = '/';
        $arithmetic[] = 'π';
        $arithmetic[] = 'cos';
        $arithmetic[] = 'sin';
        $arithmetic[] = 'tan';
        $arithmetic[] = 'ⅹ²';
        //$arithmetic[] = 'ⅹ³';
        $arithmetic[] = '²√';

        $form->setTitle($this->config->get("TITLE"));
        $form->addInput((string) $print);
        $form->addDropdown($this->config->get("DROPDOWN"), $arithmetic);
        $form->sendToPlayer($player);
    }

    public function reCallForm(Player $player): void{
        $this->createForm($player);
    }
}

class Save{

    public static $num;

    public static function saveNumber($num = 0, Player $player): void{
        self::$num[$player->getName()] = $num;
    }
}
