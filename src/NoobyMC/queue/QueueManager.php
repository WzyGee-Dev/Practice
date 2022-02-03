<?php

namespace NoobyMC\queue;

use NoobyMC\Core;
use NoobyMC\scoreboards\ScoreboardAPI;
use NoobyMC\Utils;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class QueueManager
{


    private Player $player;
    private string $world;
    private array $queue = [];

    public function __construct(Player $player, string $world){
        $this->player = $player;
        $this->world = $world;
        $file = new Config(Core::getInstance()->getDataFolder()."Arenas/".$world.".yml");
        $data = $file->get($world);
        $this->mode = $data["mode"];
    }



    public function addQueue(){

        if(!isset($this->queue[$this->player->getName()])){
            $this->queue[$this->player->getName()] = $this->player;
        }
        $this->QueueManager($this->mode);
    }

    private function QueueManager(string $mode)
        {
            switch ($mode){
                case "buhc":
                    if(count(Core::getInstance()->getPlayerDuelManager()->getBuhcPlayer()) >= 2){
                        #teleport
                    } else {
                        ScoreboardAPI::getInstance()->removeScore($this->player);
                        Core::getInstance()->getScoreboardManager()->setWaitingDuelScore($this->player);
                        Utils::leftQueue($this->player);
                    }
                    break;
                case "nodebuff":
                    if(count(Core::getInstance()->getPlayerDuelManager()->getDebuffPlayer()) >= 2){
                        #teleport
                    } else {
                        ScoreboardAPI::getInstance()->removeScore($this->player);
                        Core::getInstance()->getScoreboardManager()->setWaitingDuelScore($this->player);
                        Utils::leftQueue($this->player);
                    }
                    break;
                case "sumo":
                    if(count(Core::getInstance()->getPlayerDuelManager()->getSumoPlayer()) >= 2){
                        #teleport
                    } else {
                        ScoreboardAPI::getInstance()->removeScore($this->player);
                        Core::getInstance()->getScoreboardManager()->setWaitingDuelScore($this->player);
                        Utils::leftQueue($this->player);
                    }
                    break;
                case "gapple":
                    if(count(Core::getInstance()->getPlayerDuelManager()->getGapplePlayer()) >= 2){
                        #teleport
                    } else {
                        ScoreboardAPI::getInstance()->removeScore($this->player);
                        Core::getInstance()->getScoreboardManager()->setWaitingDuelScore($this->player);
                        Utils::leftQueue($this->player);
                    }
                    break;
            }
        }
}