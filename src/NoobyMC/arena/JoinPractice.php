<?php

namespace NoobyMC\arena;

use NoobyMC\Core;
use NoobyMC\IPlayer\IPlayer;
use NoobyMC\IPlayer\PlayerPractice;
use NoobyMC\scoreboards\ScoreboardAPI;
use NoobyMC\scoreboards\ScoreboardManager;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class JoinPractice
{

    public string $world;

    public $mode;

    /**
     * @var Player
     */
    public Player $player;

    public function __construct(Player $player, string $world)
    {
        $this->world = $world;
        $this->player = $player;
        $file = new Config(Core::getInstance()->getDataFolder()."Arenas/".$world.".yml");
        $data = $file->get($world);
        $this->mode = $data["mode"];
    }

    /**
     * @return string
     */
    public function getWorld(): string
    {
        return $this->world;
    }

   public function joinWorld()
   {

    $spawn = Core::getInstance()->getArenaHandler()->getSpawn($this->world);
       switch ($this->mode){
           case "gapple":
               if(count(Core::getInstance()->getPlayerManager()->getGapplePlayer()) >= 15){
                    $this->player->sendMessage(TextFormat::colorize("&cThe game is full"));
                   return true;
               }
               Core::getInstance()->getPlayerManager()->addGapplePlayer($this->player);
               $this->player->getEffects()->clear();
               $this->player->getArmorInventory()->clearAll();
               $this->player->getInventory()->clearAll();
               $this->player->getHungerManager()->setFood(20);
               $this->player->setHealth(20);
               $this->player->setGamemode(GameMode::fromString(0));

               $this->player->teleport(new Position($spawn[0], $spawn[1] + 0.6, $spawn[2], Server::getInstance()->getWorldManager()->getWorldByName($this->world)));
               Core::getInstance()->getKitManager()->setKit($this->player, $this->mode);
               break;
           case "buhc":
               if(count(Core::getInstance()->getPlayerManager()->getBuhcPlayer()) >= 15){
                   $this->player->sendMessage(TextFormat::colorize("&cThe game is full"));
                   return true;
               }
               Core::getInstance()->getPlayerManager()->addBuhcPlayer($this->player);
               $this->player->getEffects()->clear();
               $this->player->getArmorInventory()->clearAll();
               $this->player->getInventory()->clearAll();
               $this->player->getHungerManager()->setFood(20);
               $this->player->setHealth(20);
               $this->player->setGamemode(GameMode::fromString(0));
               $this->player->teleport(new Position($spawn[0], $spawn[1] + 0.6, $spawn[2], Server::getInstance()->getWorldManager()->getWorldByName($this->world)));
               Core::getInstance()->getKitManager()->setKit($this->player, $this->mode);
               break;
           case "sumo":
               if(count(Core::getInstance()->getPlayerManager()->getSumoPlayer()) >= 15){
                   $this->player->sendMessage(TextFormat::colorize("&cThe game is full"));
                   return true;
               }
               Core::getInstance()->getPlayerManager()->addSumoPlayer($this->player);
               $this->player->getEffects()->clear();
               $this->player->getArmorInventory()->clearAll();
               $this->player->getInventory()->clearAll();
               $this->player->getHungerManager()->setFood(20);
               $this->player->setHealth(20);
               $this->player->setGamemode(GameMode::fromString(0));
               $this->player->teleport(new Position($spawn[0], $spawn[1] + 0.6, $spawn[2], Server::getInstance()->getWorldManager()->getWorldByName($this->world)));
               Core::getInstance()->getKitManager()->setKit($this->player, $this->mode);
               break;
           case "nodebuff":
               if(count(Core::getInstance()->getPlayerManager()->getDebuffPlayer()) >= 15){
                   $this->player->sendMessage(TextFormat::colorize("&cThe game is full"));
                   return true;
               }

               Core::getInstance()->getPlayerManager()->addDebuffPlayer($this->player);
               $this->player->getEffects()->clear();
               $this->player->getArmorInventory()->clearAll();
               $this->player->getInventory()->clearAll();
               $this->player->getHungerManager()->setFood(20);
               $this->player->setHealth(20);
               $this->player->setGamemode(GameMode::fromString(0));
               ScoreboardAPI::getInstance()->removeScore($this->player);
               Core::getInstance()->getScoreboardManager()->setFreForAllScore($this->player);
               $this->player->teleport(new Position($spawn[0], $spawn[1] + 0.6, $spawn[2], Server::getInstance()->getWorldManager()->getWorldByName($this->world)));
               Core::getInstance()->getKitManager()->setKit($this->player, $this->mode);
               break;
       }
   }
}