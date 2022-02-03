<?php

namespace NoobyMC\IPlayer;

use NoobyMC\Core;
use pocketmine\player\Player;
use pocketmine\Server;

class PlayerDuel
{

    protected array $gapple = [];
    protected array $buhc = [];
    protected array $sumo = [];
    protected array $debuff = [];

    public function addGapplePlayer(Player $player)
    {
        $this->gapple[$player->getName()] = $player;
    }

    public function addBuhcPlayer(Player $player)
    {
        $this->buhc[$player->getName()] = $player;
    }
    public function addSumoPlayer(Player $player)
    {
        $this->sumo[$player->getName()] = $player;
    }

    public function addDebuffPlayer(Player $player)
    {
        $this->debuff[$player->getName()] = $player;
    }

    public function getGapplePlayer(): array
    {
        return $this->gapple;
    }
    public function getBuhcPlayer(): array
    {
        return $this->buhc;
    }
    public function getSumoPlayer(): array
    {
        return $this->sumo;
    }

    public function getDebuffPlayer(): array
    {
        return $this->debuff;
    }

    public function getPlayers(string $world): array
    {
        $players = [];
        $level = Server::getInstance()->getWorldManager()->getWorldByName($world);
        if($level != null) {
            foreach ($level->getPlayers() as $player) {
                if ($this->inGame($player)) {
                    $players[] = $player;
                }
            }
        }
        return $players;
    }

    public function inGame(Player $player): bool
    {
        if(isset($this->gapple[$player->getName()])){
            return true;
        }
        if(isset($this->buhc[$player->getName()]))
        {
            return true;
        }
        if(isset($this->sumo[$player->getName()]))
        {
            return true;
        }
        if(isset($this->debuff[$player->getName()]))
        {
            return true;
        }
        return false;
    }

    public function playerInArena(Player $player)
    {
        foreach (Core::getInstance()->getArenas()->getArenasDuel() as $arena) {
            foreach ($this->getPlayers($arena) as $target) {
                if($target->getName() === $player->getName()){
                    return $arena;
                }
            }
        }
        return null;
    }

    public function removePlayer(Player $player)
    {
        if(isset($this->gapple[$player->getName()])){
            unset($this->gapple[$player->getName()]);
        }
        if(isset($this->buhc[$player->getName()])){
            unset($this->buhc[$player->getName()]);
        }
        if(isset($this->sumo[$player->getName()])){
            unset($this->sumo[$player->getName()]);
        }
        if(isset($this->debuff[$player->getName()])){
            unset($this->debuff[$player->getName()]);
        }
    }

}