<?php

namespace NoobyMC\listeners;

use NoobyMC\arena\Type\modes;
use NoobyMC\Core;
use NoobyMC\IPlayer\IPlayer;
use NoobyMC\items\ItemPearl;
use NoobyMC\tasks\BlockTask;
use NoobyMC\tasks\EnderPearlTask;
use NoobyMC\Utils;
use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\projectile\EnderPearl;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerBucketEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemIds;
use pocketmine\item\SplashPotion;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class FreeForAllListener implements Listener, modes
{

    public function __construct()
    {
        Core::getInstance()->getServer()->getPluginManager()->registerEvents($this, Core::getInstance());
    }

    public function onBlockBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $arena = Core::getInstance()->getPlayerManager()->playerInArena($player);
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
            switch (Core::getInstance()->getArenaHandler()->getMode($arena)){
                case self::SUMO:
                case self::GAPPLE:
                case self::DEBUFF:
                case self::FIST:
                $event->cancel();
                    break;
                case self::BUHC:
                    if($block->getId() !== BlockLegacyIds::COBBLESTONE){
                        $event->cancel();
                    }
                    break;
            }

            }
        }

    public function onPlace(BlockPlaceEvent $event)
    {
        $player = $event->getPlayer();

        $block = $event->getBlock();
        $arena = Core::getInstance()->getPlayerManager()->playerInArena($player);
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
            switch (Core::getInstance()->getArenaHandler()->getMode($arena)){
                case self::SUMO:
                case self::GAPPLE:
                case self::DEBUFF:
                case self::FIST:
                    $event->cancel();
                    break;
                case self::BUHC:
                    if($block->getId() !== BlockLegacyIds::COBBLESTONE){
                        $event->cancel();
                    }
                    if($block->getId() == 4){
                        Core::getInstance()->getScheduler()->scheduleDelayedTask(new BlockTask($block), 20 * 5);
                    }
                    break;

            }
        }
    }

    public function onProjectile(ProjectileLaunchEvent $event)
    {
        $item = $event->getEntity();
        $player = $item->getOwningEntity();
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
        if($item instanceof ItemPearl) {
            if (Core::getInstance()->getPlayerManager()->getBoolPearl($player) !== false) {
                Core::getInstance()->getScheduler()->scheduleRepeatingTask(new EnderPearlTask($player), 20);
            }
        }
        }
    }
    public function onBucket(PlayerBucketEvent $event){
        $player = $event->getPlayer();
            $item = $event->getItem();
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
            switch ($item->getId()) {
                case ItemIds::BUCKET:
                case ItemIds::LAVA:
                    Core::getInstance()->getScheduler()->scheduleDelayedTask(new BlockTask($event->getBlockClicked()), 20 * 5);
                    break;
            }
            }
        }

    public function onExhaust(PlayerExhaustEvent $event)
    {
        $player = $event->getPlayer();
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
            $event->cancel();
        }
    }

    public function onDrop(PlayerDropItemEvent $event)
    {
        $player = $event->getPlayer();
        if(Core::getInstance()->getPlayerManager()->inGame($player)){
            $event->cancel();
        }
    }

    public function onQuit(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        if (Core::getInstance()->getPlayerManager()->inGame($player)) {
            Core::getInstance()->getPlayerManager()->removePlayer($player);
        }
    }

        public function onDeahts(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        if($player instanceof Player){
            $damage = $event->getFinalDamage() >= $player->getHealth();
            if(Core::getInstance()->getPlayerManager()->inGame($player)){
                switch ($event->getCause()){
                    case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                        if($event instanceof EntityDamageByEntityEvent) {
                            if ($damage) {
                                $killer = $event->getDamager();
                                if ($killer instanceof Player) {
                                    $player->getArmorInventory()->clearAll();
                                    $player->getInventory()->clearAll();
                                    $player->getHungerManager()->setFood(20);
                                    $player->setHealth(20);
                                    Core::getInstance()->getPlayerManager()->setStreakPlayer($killer);
                                    Core::getInstance()->getPlayerManager()->setKillsPlayer($killer);
                                    Core::getInstance()->getPlayerManager()->setDeathsPlayer($player);
                                    if($killer instanceof IPlayer and $player instanceof IPlayer){
                                        $killer->removeCombat();
                                        $player->removeCombat();
                                    }
                                    $killer->sendMessage(TextFormat::colorize("&r&aStreak_kill: ").Core::getInstance()->getDataHandler()->getStreakPlayer($killer));
                                    Core::getInstance()->getPlayerManager()->breakStreak($player);
                                    $player->sendMessage(TextFormat::colorize("&r&cYour lost Streak_kill"));
                                    $pots1=0;
                                    $pots2=0;
                                    foreach ($player->getInventory()->getContents() as $content) {
                                        if($content instanceof SplashPotion) $pots2++;

                                    }
                                    foreach ($killer->getInventory()->getContents() as $content) {
                                        if($content instanceof SplashPotion) $pots1++;

                                    }
                                    Server::getInstance()->broadcastMessage(TextFormat::colorize("&l&c+ &r&c{$player->getName()}&7[&cpots:{$pots2}&7] &7 was killed by &b{$killer->getName()} &7[&chp:{$killer->getHealth()}&7] &7[&cpots:{$pots1}&7]"));
                                    Core::getInstance()->getPlayerManager()->removePlayer($player);
                                    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
                                    Utils::setItems($player);
                                } else {
                                    foreach ($player->getWorld()->getPlayers() as $players) {
                                        $players->sendMessage(TextFormat::colorize("&l&c+ &r&c{$player->getName()} &7is died."));
                                    }
                                }
                            }
                        }
                        break;
                    case EntityDamageEvent::CAUSE_VOID:
                        if($event instanceof EntityDamageByEntityEvent){
                            $killer = $event->getDamager();
                            if($killer instanceof Player){
                                if($damage){
                                    $event->cancel();
                                    $player->getArmorInventory()->clearAll();
                                    $player->getInventory()->clearAll();
                                    Core::getInstance()->getPlayerManager()->removePlayer($player);
                                    Utils::setItems($player);
                                    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
                                    Server::getInstance()->broadcastMessage(TextFormat::colorize("&l&c+ &r&c{$player->getName()} &7 was killed by &b{$killer->getName()} &7[&chp:{$killer->getHealth()}&7]"));
                                } else {
                                    Server::getInstance()->broadcastMessage(TextFormat::colorize("&l&c+ &r&c{$player->getName()} &7is died."));

                                }
                            }
                        }
                        break;
                }
            }
        }
    }

    public function onTap(EntityDamageByEntityEvent $event)
    {
        $entity = $event->getEntity();
        $damager = $event->getDamager();
        if(Core::getInstance()->getPlayerManager()->inGame($entity)){
            if($entity instanceof Player and $damager instanceof Player){
                 $entity1 = Core::getInstance()->getPlayerManager()->getPlayerC($entity);
                 $damager1 = Core::getInstance()->getPlayerManager()->getPlayerC($damager);
                 if($damager1->isTagged() && $damager1->getOpponent() !== $entity->getName()){
                     $event->cancel();
                 }
                 if($entity1->isTagged() && $entity1->getOpponent() !== $damager->getName()){
                    $event->cancel();
                 }
                 if(!$event->isCancelled()) {
                     $entity1->setTaggeds($damager);
                     $damager1->setTaggeds($entity);
                 }
            }

        }
    }

}