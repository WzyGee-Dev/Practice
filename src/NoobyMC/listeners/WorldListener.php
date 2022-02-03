<?php

namespace NoobyMC\listeners;

use NoobyMC\Core;
use pocketmine\block\Anvil;
use pocketmine\block\BrewingStand;
use pocketmine\block\Button;
use pocketmine\block\Chest;
use pocketmine\block\CraftingTable;
use pocketmine\block\Door;
use pocketmine\block\EnchantingTable;
use pocketmine\block\EnderChest;
use pocketmine\block\FenceGate;
use pocketmine\block\Furnace;
use pocketmine\block\Lever;
use pocketmine\block\Trapdoor;
use pocketmine\block\TrappedChest;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Bed;
use pocketmine\item\Redstone;
use pocketmine\math\Vector3;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class WorldListener implements Listener
{

    public function __construct()
    {
        Core::getInstance()->getServer()->getPluginManager()->registerEvents($this, Core::getInstance());
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $item = $event->getItem();
        if($block instanceof Anvil or $block instanceof Bed or $block instanceof BrewingStand or $block instanceof Button or $block instanceof  Chest or $block instanceof CraftingTable or $block instanceof Door or $block instanceof EnchantingTable or $block instanceof EnderChest or $block instanceof FenceGate or $block instanceof Furnace or $block instanceof Lever or $block instanceof Trapdoor or $block instanceof TrappedChest or $item instanceof Redstone){
            $event->cancel();
        }

        if($item->getName() === TextFormat::colorize("&r&bFFA")){
            Core::getInstance()->getForms()->getArenas($player);
        }
        if($item->getName() === TextFormat::colorize("&r&bProfile")){
            Core::getInstance()->getForms()->getFormsPlayer($player);
        }
        if($item->getName() === TextFormat::colorize("&r&bConfiguration")){
            Core::getInstance()->getForms()->getFormConfig($player);
        }
        if($item->getName() === TextFormat::colorize("&r&bUnranked")){
            Core::getInstance()->getForms()->getArenasDuels($player);
        }
        if($item->getName() === TextFormat::colorize("&r&cleft the queue")){

        }
    }
    
    public function onBreak(BlockBreakEvent $event){
        $player = $event->getPlayer();
        if($player->getWorld() === Server::getInstance()->getWorldManager()->getDefaultWorld()){
            $event->cancel();
        }
    }

    public function onEntity(EntityDamageEvent $event){
        $player = $event->getEntity();
        if($player instanceof Player){
            if($player->getWorld()->getFolderName() == Server::getInstance()->getWorldManager()->getDefaultWorld()->getFolderName()){
            switch ($event->getCause()) {
                case EntityDamageEvent::CAUSE_SUFFOCATION:
                        $player->teleport(new Vector3(intval($player->getLocation()->getX()), intval($player->getLocation()->getY() + 1), intval($player->getLocation()->getZ())));
                        $player->setMotion(new Vector3(0, 1, 0));
                        $event->cancel();
                    break;
                case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
                    if ($event instanceof EntityDamageByEntityEvent) {
                        $damager = $event->getDamager();
                        $entity = $event->getEntity();
                        if ($damager instanceof Player or $entity instanceof Player) {
                            $event->cancel();
                        }
                    }
                    break;
                case EntityDamageEvent::CAUSE_FALL:
                    $event->cancel();
                    break;
                case EntityDamageEvent::CAUSE_VOID:
                    $player->setMaxHealth(20);
                    $player->setHealth(20);
                    $player->getHungerManager()->setFood(20);
                    $player->setGamemode(GameMode::fromString(0));
                    $player->getArmorInventory()->clearAll();
                    break;
                 }
            }
        }
    }
}