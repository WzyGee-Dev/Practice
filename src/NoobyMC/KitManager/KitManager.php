<?php

namespace NoobyMC\KitManager;

use pocketmine\player\Player;

class KitManager extends Kit
{


    public function setKit(Player $player, string $amount)
    {
        switch ($amount)
        {
            case "gapple":
                $this->kitGapple($player);
                break;
            case "sumo":
                $this->getKitSumo($player);
                break;
            case "buhc":
                $this->getBuhcKit($player);
                break;
            case "fist":
                $this->getKitFist($player);
                break;
            case "nodebuff":
                $this->getKitDebuff($player);
                break;
        }
    }
}