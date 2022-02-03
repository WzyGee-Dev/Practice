<?php

namespace NoobyMC\commands;

use NoobyMC\arena\JoinPractice;
use NoobyMC\Core;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class FreeForAllCommand extends Command
{
    public function __construct()
    {
        parent::__construct("freeforall", "Practice Minigame");
        $this->setAliases(["ffa"]);
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if(!isset($args[0])){
            return true;
        }
        switch ($args[0]){
            case "new":
                if(!isset($args[1])){
                    $sender->sendMessage(TextFormat::colorize("&cUse: /ffa new {world}"));
                    return true;
                }

                if(!isset($args[2])){
                    $sender->sendMessage(TextFormat::colorize("&cUse: /ffa new {mode}"));
                    return true;
                }

                Core::getInstance()->getArenaHandler()->newWorld($args[1], strtolower($args[2]));
                $sender->teleport(Server::getInstance()->getWorldManager()->getWorldByName($args[1])->getSafeSpawn());
                $sender->sendMessage(TextFormat::colorize("&bmap successfully registered"));
                break;
            case "spawn":
                if(!isset($args[1])){
                    $sender->sendMessage(TextFormat::colorize("&cUse: /ffa new {world}"));
                    return true;
                }
                Core::getInstance()->getArenaHandler()->newSpawnWorld($args[1], $sender->getPosition()->getX(), $sender->getPosition()->getY(), $sender->getPosition()->getZ());
                $sender->sendMessage(TextFormat::colorize("&bspawn successfully registered"));
                break;
            case "join":
                if(!isset($args[1])){
                    $sender->sendMessage(TextFormat::colorize("&cUse: /ffa new {world}"));
                    return true;
                }
                $arena = new JoinPractice($sender, strtolower($args[1]));
                $arena->joinWorld();
                break;
            case "ping":
                if($sender instanceof Player) {
                    Server::getInstance()->broadcastMessage("ping" . $sender->getNetworkSession()->getPing());
                    }
        }
    }
}