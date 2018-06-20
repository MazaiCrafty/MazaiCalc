<?php

/**
* The MIT License
* Copyright (c) 2018 MazaiCrafty
*/

namespace mazaicrafty\calc;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use mazaicrafty\calc\Process;

class Main extends PluginBase{

    const CLEAR = 0;
    const ADDITION = 1;
    const SUBTRACTION = 2;
    const MULTIPLICATION = 3;
    const DIVISION = 4;

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

    public function createCalc(Player $player){
        $form = $this->form_api->createCustomForm(
            function (Player $player, $data){
                if ($data === null) return;
                $input_num = $data[0];
                $temp_num = Temp::$temp[$player->getName()];

                switch ($data[1]){
                    case Main::CLEAR:
                    Temp::tempNum(0, $player);
                    break;

                    case Main::ADDITION:
                    $result = Process::addition($temp_num, $input_num);
                    Temp::tempNum($result, $player);
                    break;

                    case Main::SUBTRACTION:
                    $result = Process::subtraction($temp_num, $input_num);
                    Temp::tempNum($result, $player);
                    break;

                    case Main::MULTIPLICATION:
                    $result = Process::multiplication($temp_num, $input_num);
                    Temp::tempNum($result, $player);
                    break;

                    case Main::DIVISION:
                    $result = Process::division($temp_num, $input_num);
                    Temp::tempNum($result, $player);
                    break;
                }

                if ($data === 0){
                    Temp::tempNum(0, $player);
                }
                $this->reCallForm($player);
            }
        );

        $arithmetic[] = 'C';
        $arithmetic[] = '+';
        $arithmetic[] = '-';
        $arithmetic[] = '×';
        $arithmetic[] = '/';

        $form->setTitle("MazaiCalc");
        $form->addInput((string) Temp::$temp[$player->getName()]);
        $form->addDropdown("type", $arithmetic);
        $form->sendToPlayer($player);
    }

    public function reCallForm(Player $player){
        $this->createCalc($player);
    }
}

class Temp{

    public static $temp;

    public static function tempNum($num = 0, Player $player){
        self::$temp[$player->getName()] = $num;
    }
}
