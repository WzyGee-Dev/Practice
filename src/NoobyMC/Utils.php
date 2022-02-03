<?php

namespace NoobyMC;

use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use NoobyMC\Core;

class Utils
{

    private static array $combat = [];
    private static array $player1 = [];
    private static array $player2 = [];

    public static function setItems(Player $player)
    {
       $player->setHealth(20);
       $player->getEffects()->clear();
       $player->getHungerManager()->setFood(20);
      // $player->getXpManager()->setXpLevel(0);
       $player->getXpManager()->setXpProgress(0.0);
       $player->extinguish();
       $player->getInventory()->clearAll();
       $player->getArmorInventory()->clearAll();
       $player->getInventory()->clearAll();
       $player->getInventory()->setItem(0, ItemFactory::getInstance()->get(ItemIds::STONE_SWORD, 0, 1)->setCustomName(TextFormat::colorize("&r&bUnranked")));
       $player->getInventory()->setItem(1, ItemFactory::getInstance()->get(ItemIds::IRON_SWORD, 0, 1)->setCustomName(TextFormat::colorize("&r&bRanked")));
       $player->getInventory()->setItem(3, ItemFactory::getInstance()->get(ItemIds::DIAMOND_AXE, 0,1)->setCustomName(TextFormat::colorize("&r&bFFA")));
       $player->getInventory()->setItem(5, ItemFactory::getInstance()->get(ItemIds::COMPASS, 0, 1)->setCustomName(TextFormat::colorize("&r&bProfile")));
       $player->getInventory()->setItem(6, ItemFactory::getInstance()->get(ItemIds::CLOCK, 0, 1)->setCustomName(TextFormat::colorize("&r&bConfiguration")));
       $player->getInventory()->setItem(8, ItemFactory::getInstance()->get(ItemIds::NAME_TAG, 0, 1)->setCustomName(TextFormat::colorize("&r&bcomestics")));
       $player->getInventory()->setHeldItemIndex(0);
    }

    public static function leftQueue(Player $player)
    {
        $player->setHealth(20);
        $player->getEffects()->clear();
        $player->getHungerManager()->setFood(20);
        // $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->extinguish();
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(8, ItemFactory::getInstance()->get(ItemIds::REDSTONE, 0, 1)->setCustomName(TextFormat::colorize("&r&cleft the queue")));
    }

}