<?php

namespace NoobyMC\listeners;


use NoobyMC\Core;
use NoobyMC\IPlayer\IPlayer;
use NoobyMC\Utils;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;

class PlayerListener implements Listener
{
    public function __construct(){
        Server::getInstance()->getPluginManager()->registerEvents($this, Core::getInstance());
    }


    function creationPlayer(PlayerCreationEvent $event){
        $event->setPlayerClass(IPlayer::class);
    }

    function onCraft(CraftItemEvent $event){
        $event->cancel();
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        Core::getInstance()->getPlayerManager()->createPlayer($player);
        Utils::setItems($player);
        $event->setJoinMessage(TextFormat::colorize("&8[&a+&8]&r&a ".$player->getName()));
        Core::getInstance()->getDataHandler()->setInitializePlayer($player);
        $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
        Core::getInstance()->getScoreboardManager()->setWorldScoreboard($player);
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        Core::getInstance()->getPlayerManager()->removePlayer($player);
        Core::getInstance()->getPlayerManager()->breakStreak($player);

    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        if($player instanceof Player){
            $min = 4;
            $max = $player->getLocation()->getY();
            if($player->getWorld() === Server::getInstance()->getWorldManager()->getDefaultWorld()){
                if($max <= $min){
                    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
                }
            }
            if(Core::getInstance()->getDataHandler()->getSprintPlayer($player)==true){
                $player->setSprinting(true);
            }
        }
    }

    public function onDeath(PlayerDeathEvent $event){
        $event->setDrops([]);
        $event->setDeathMessage("");
    }

    public function onDropItem(PlayerDropItemEvent $event){
        $player = $event->getPlayer();
        if($player->getWorld()->getFolderName() == Server::getInstance()->getWorldManager()->getDefaultWorld()->getFolderName()){
            $event->cancel();
        }
    }

    public function onHunder(PlayerExhaustEvent $event){
        $player = $event->getPlayer();
        if ($player->getWorld()->getFolderName() == Server::getInstance()->getWorldManager()->getDefaultWorld()->getFolderName()) {
            $event->cancel();
        }
    }
}
