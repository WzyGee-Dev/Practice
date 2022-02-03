<?php

namespace NoobyMC\handlers;

use NoobyMC\Core;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Databasehandler
{

    public function setInitializePlayer(Player $player)
    {
        if (!file_exists(Core::getInstance()->getDataFolder() . "playerdata/" . $player->getName() . ".yml")) {
            $file = new Config(Core::getInstance()->getDataFolder() . "playerdata/" . $player->getName() . ".yml");

            $data = [
                "coins" => 0,
                "name" => $player->getName(),
                "kills" => 0,
                "streak_kills" => 0,
                "level" => 0,
                "wins" => 0,
                "deaths" => 0,
                "ranked" => false,
                "scoreboard" => true,
                "streak_total" => 0,
                "auto_sprint" => false
            ];
            $file->set($player->getName(), $data);
            $file->save();
        }
    }

        public function getRankedPlayer(Player $player): bool
        {
            $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
            $data = $file->get($player->getName());
            return $data["ranked"];
    }
    public function getScoreboardPlayer(Player $player): bool
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["scoreboard"];
    }

    public function getKillsPlayer(Player $player): int
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["kills"];
    }
    public function getDeathsPlayer(Player $player): int
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["deaths"];
    }
    public function getWinsPlayer(Player $player): int
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["wins"];
    }

    public function getKillsStreakPlayer(Player $player): int
    {
        $cfg = new Config(Core::getInstance()->getDataFolder()."streak_total.yml");
        return $cfg->get($player->getName(), $cfg->get($player->getName()));
    }
    public function getStreakPlayer(Player $player): int
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["streak_kills"];
    }

    public function getCoinsPlayer(Player $player): int
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["coins"];
    }

    public function getSprintPlayer(Player $player): bool
    {
        $file = new Config(Core::getInstance()->getDataFolder()."playerdata/".$player->getName().".yml");
        $data = $file->get($player->getName());
        return $data["auto_sprint"];
    }
}