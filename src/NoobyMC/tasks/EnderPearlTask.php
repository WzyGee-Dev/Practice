<?php

namespace NoobyMC\tasks;

use NoobyMC\Core;
use NoobyMC\Utils;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class EnderPearlTask extends Task
{

    private Player $player;
    private int $time = 15;
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(): void
    {
     $this->time--;
     if($this->time==14){
         Core::getInstance()->getPlayerManager()->setBoolPearl($this->player, true);
         $percent = floatval($this->time / 14);
         $this->player->getXpManager()->setXpLevel($this->time);
         $this->player->sendPopup($this->time);
         $this->player->getXpManager()->setXpLevel($percent);
     }
     if($this->time<14){
         $percent = floatval($this->time / 14);
         $this->player->getXpManager()->setXpLevel($this->time);
         $this->player->sendPopup($this->time);
         $this->player->getXpManager()->setXpLevel($percent);
     }
     if($this->time==0){
         $this->player->getXpManager()->setXpProgress(0.0);
         Core::getInstance()->getPlayerManager()->setBoolPearl($this->player, false);
         Core::getInstance()->getScheduler()->scheduleTask($this)->cancel();
     }
    }
}