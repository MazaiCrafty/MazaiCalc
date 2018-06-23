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

    private $form_api;

    public function onEnable(): void{
        $this->form_api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        switch ($cmd->getName()){
            case "calc":
            if (!($sender instanceof Player)){
                $sender->sendMessage("Please execute this command in-game");
                return true;
            }
            $this->createCalc($sender);
            return true;

            default:
            return false;
        }
    }

    public function createCalc(Player $player): void{
        $form = $this->form_api->createCustomForm(
            function (Player $player, $data){
                if ($data === null) return;
                $type = $data[1];
                $input_num = $data[0];
                $saved_num = Save::$num[$player->getName()];

                if (!(ctype_digit("$input_num"))){
                    $player->sendMessage("全て数字で入力しなければなりません");
                    return;
                }

                switch ($type){
                    case Main::CLEAR:
                    Save::saveNumber(0, $player);
                    break;

                    case Main::ADDITION:
                    $result = Calculate::addition($saved_num, $input_num);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::SUBTRACTION:
                    $result = Calculate::subtraction($saved_num, $input_num);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::MULTIPLICATION:
                    $result = Calculate::multiplication($saved_num, $input_num);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::DIVISION:
                    $result = Calculate::division($saved_num, $input_num);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::PI:
                    Save::saveNumber(3.14159265358979, $player);
                    break;

                    case Main::COS:
                    $result = Calculate::cos(Save::$num[$player->getName()]);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::SIN:
                    $result = Calculate::cos(Save::$num[$player->getName()]);
                    Save::saveNumber($result, $player);
                    break;

                    case Main::TAN:
                    $result = Calculate::tan(Save::$num[$player->getName()]);
                    Save::saveNumber($result, $player);
                    break;
                }

                if ($data === 0) {
                    Save::saveNumber(0, $player);
                }
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

        $form->setTitle("MazaiCalc");
        $form->addInput((string) $print);
        $form->addDropdown("type", $arithmetic);
        $form->sendToPlayer($player);
    }

    public function reCallForm(Player $player): void{
        $this->createCalc($player);
    }
}

class Save{

    public static $num;

    public static function saveNumber($num = 0, Player $player): void{
        self::$num[$player->getName()] = $num;
    }
}
