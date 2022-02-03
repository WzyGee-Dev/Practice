<?php

namespace NoobyMC\handlers;

use mysql_xdevapi\CollectionRemove;
use NoobyMC\Core;
use pocketmine\block\CoalOre;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\Server;
use pocketmine\utils\Config;

class Arenahandler
{

    public function newWorld(string $world, string $mode){
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        $data["world"] = $world;
        $data["mode"] = $mode;
        $data["image"] = "url";
        $arena = new Config(Core::getInstance()->getDataFolder()."config.yml");
        $data1 = $arena->get("arenasPractice");
        $data1[] = $world;
        $arena->set("arenasPractice", $data1);
        $arena->save();
        $file->set($world, $data);
        $file->save();
    }

    public function newSpawnWorld(string $world, int $x, int $y, int $z)
    {
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        $data["spawn"] = [$x, $y, $z];
        $file->set($world, $data);
        $file->save();

    }

    public function loadWorlds(){
        if(count(Core::getInstance()->getArenas()->getArenas()) > 0){
            foreach (Core::getInstance()->getArenas()->getArenas() as $arena){
                Server::getInstance()->getWorldManager()->loadWorld($arena);
            }
            foreach (Core::getInstance()->getArenas()->getArenasDuel() as $arena) {
                Server::getInstance()->getWorldManager()->loadWorld($arena);
            }

            foreach (Server::getInstance()->getWorldManager()->getWorlds() as $world) {
                $pk = new GameRulesChangedPacket();
                $pk->gameRules = array_map(fn($gameRule) => [
                    $this->typeProperty($gameRule), $gameRule, true
                ],["doImmediateRespawn" => true]);
                $world->broadcastPacketToViewers($world->getSpawnLocation(), $pk);
                $world->setTime(0);
                $world->stopTime();
            }
        }
    }
    private function typeProperty($valur): int {
        if(is_bool($valur)) return 1;
        if(is_int($valur)) return 2;
        return 0;
    }
    public function getSpawn(string $world)
    {
        $file = new Config(Core::getInstance()->getDataFolder(). "Arenas/".$world.".yml");
        $data = $file->get($world);
        return $data["spawn"];
    }

    public function getMode(string $world)
    {
        $file = new Config(Core::getInstance()->getDataFolder()."Arenas/".$world.".yml");
        $data = $file->get($world);
        return $data["mode"];
    }

    public function getImage(string $world)
    {
        $file = new Config(Core::getInstance()->getDataFolder()."Arenas/".$world.".yml");
        $data = $file->get($world);
        return $data["image"];
    }

}