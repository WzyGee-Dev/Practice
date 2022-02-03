<?php

namespace NoobyMC\commands;

use NoobyMC\Core;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class DuelCommand extends VanillaCommand
{
    public function __construct()
    {
        parent::__construct("duel", "Duel Minigame");
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
               Core::getInstance()->getDuelHandler()->newWorld($args[1], strtolower($args[2]));
               $sender->teleport(Server::getInstance()->getWorldManager()->getWorldByName($args[1])->getSafeSpawn());
               $sender->sendMessage(TextFormat::colorize("&bmap successfully registered"));
               break;
           case "spawn":
               if(!isset($args[1])){
                   $sender->sendMessage(TextFormat::colorize("&cUse: /ffa new {world}"));
                   return true;
               }
               if(!is_numeric($args[2])){
                   $sender->sendMessage(TextFormat::colorize("&cuse a numeric value in the slots!"));
                   return false;
               }
               if((int)$args[2] > 2){
                   $sender->sendMessage(TextFormat::colorize("&cthere are only 2 slots availables!"));
                   return false;
               }

               Core::getInstance()->getDuelHandler()->newSpawnWorld($args[1], $args[2], $sender->getPosition()->getX(), $sender->getPosition()->getY(), $sender->getPosition()->getZ());
               $sender->sendMessage(TextFormat::colorize("&bspawn successfully registered"));
               break;
       }
    }
}