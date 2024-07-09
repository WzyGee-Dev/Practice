<?php

namespace Practice;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\player\Player;
use pocketmine\Server;
use Practice\Sessions\PlayerSession;
use Practice\Sessions\SessionManager;

class EventListener implements Listener
{

    public function onJoin(PlayerJoinEvent $event): void
    {
     $session = new PlayerSession($event->getPlayer(), null);
     SessionManager::addSession($session);
     $session->onLoad();
    }

    public function slot_change(InventoryTransactionEvent $event): void
    {
        $player = $event->getTransaction()->getSource();
        foreach ($event->getTransaction()->getActions() as $action) {
            if(($action instanceof SlotChangeAction) && !Server::getInstance()->isOp($player->getName())){
                $event->cancel();
            }
        }
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $event->setQuitMessage("");
    }

    public function onExhaust(PlayerExhaustEvent $event): void
    {
        $event->cancel();
    }

    public function onPlace(BlockPlaceEvent $event): void
    {
        if (Server::getInstance()->isOp($event->getPlayer()->getName())) {

        } else {
            $event->cancel();
        }
    }

    public function onDamage(EntityDamageEvent $event): void
    {
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            $event->cancel();
            return;
        }
        if($event->getCause() === EntityDamageEvent::CAUSE_VOID){
            $player = $event->getEntity();
            if($player instanceof  Player){
                $event->cancel();
                $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()?->getSafeSpawn());
                return;
            }
        }
        if($event->getCause() === EntityDamageEvent::CAUSE_ENTITY_ATTACK){
            $event->cancel();
        }


    }

}