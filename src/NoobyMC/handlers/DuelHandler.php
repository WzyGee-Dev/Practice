<?php

namespace NoobyMC\handlers;

use Grpc\Server;
use NoobyMC\arena\Type\status;
use NoobyMC\Core;
use pocketmine\utils\Config;

class DuelHandler implements status
{

    public function newWorld(string $world, string $mode){
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        $data["world"] = $world;
        $data["mode"] = $mode;
        $data["image"] = "url";
        $arena = new Config(Core::getInstance()->getDataFolder()."config.yml");
        $data1 = $arena->get("arenasDuels");
        $data1[] = $world;
        $arena->set("arenasDuels", $data1);
        $arena->save();
        $file->set($world, $data);
        $file->save();
    }


    public function newSpawnWorld(string $world, int $int, int $x, int $y, int $z)
    {
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        $data["spawn"]["-{$int}"] = [$x, $y, $z];
        $data["status"] = self::WAITTING;
        $data["startTime"] = 10;
        $data["gameTime"] = 600;
        $data["endTime"] = 15;
        \pocketmine\Server::getInstance()->getWorldManager()->loadWorld($world);
        $file->set($world, $data);
        $file->save();
    }


    public function getsSpawn(string $world, int $slot){
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        return $data["spawn"]["-{$slot}"];
    }
}