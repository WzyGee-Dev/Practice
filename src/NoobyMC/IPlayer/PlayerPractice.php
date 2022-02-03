<?php

namespace NoobyMC\IPlayer;

use MongoDB\Driver\Server;
use NoobyMC\Core;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class PlayerPractice
{
    private array $combat = [];


    protected array $gapple = [];
    protected array $buhc = [];
    protected array $sumo = [];
    protected array $debuff = [];
    /**
     * @var int|mixed
     */
    private mixed $time;
    private bool $isTagged;

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
        $level = \pocketmine\Server::getInstance()->getWorldManager()->getWorldByName($world);
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
        foreach (Core::getInstance()->getArenas()->getArenas() as $arena) {
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


    public function setKillsPlayer(Player $player): void {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["kills"] = $data["kills"] + 1;
        $file->set($player->getName(), $data);
        $file->save();

        $cfg = new Config(Core::getInstance()->getDataFolder()."kills.yml");
        $cfg->set($player->getName(), $cfg->get($player->getName())+1);
        $cfg->save();
    }
    public function setDeathsPlayer(Player $player): void {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["deaths"] = $data["deaths"] + 1;
        $file->set($player->getName(), $data);
        $file->save();

        $cfg = new Config(Core::getInstance()->getDataFolder()."deaths.yml");
        $cfg->set($player->getName(), $cfg->get($player->getName())+1);
        $cfg->save();
    }

    public function setStreakPlayer(Player $player): void {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["streak_kills"] = $data["streak_kills"] + 1;
        $file->set($player->getName(), $data);
        $file->save();

        $cfg = new Config(Core::getInstance()->getDataFolder()."streak_total.yml");
        $cfg->set($player->getName(), $cfg->get($player->getName())+1);
        $cfg->save();
    }

    public function breakStreak(Player $player){
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["streak_kills"] = 0;
        $file->set($player->getName(), $data);
        $file->save();
    }

    public function setSprintPlayer(Player $player, bool $bool)
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["auto_sprint"] = $bool;
        $file->set($player->getName(), $data);
        $file->save();
    }

    public function setScoreboard(Player $player, bool $bool)
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        $data["scoreboard"] = $bool;
        $file->set($player->getName(), $data);
        $file->save();
    }

    public function setBoolPearl(Player $player, bool $pearl){
        Core::getInstance()->countdown[$player->getName()] = $pearl;
    }

    public function getBoolPearl(Player $player)
    {
        return Core::getInstance()->countdown[$player->getName()];
    }

    public function createPlayer(Player $player){
        $this->combat[$player->getName()] = new CombatPlayer($player);
    }

    public function getPlayerC(Player $player): ?CombatPlayer
    {
        return $this->combat[$player->getName()] ?? null;
    }
}