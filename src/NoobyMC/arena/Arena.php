<?php

namespace NoobyMC\arena;

use NoobyMC\Core;
use pocketmine\utils\Config;

class Arena
{


    public function getArenas(): array
    {
        $levels = new Config(Core::getInstance()->getDataFolder(). "config.yml");
        $arenas = [];
        if($levels->get("arenasPractice") != null){
            $arenas = $levels->get("arenasPractice");
        }
        return $arenas;
    }
    public function getArenasDuel(): array
    {
        $levels = new Config(Core::getInstance()->getDataFolder(). "config.yml");
        $arenas = [];
        if($levels->get("arenasDuels") != null){
            $arenas = $levels->get("arenasDuels");
        }
        return $arenas;
    }
}