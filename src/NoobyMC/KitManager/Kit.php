<?php

namespace NoobyMC\KitManager;

use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\data\bedrock\EffectIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class Kit
{

    public function kitGapple(Player $player)
    {
        $player->setHealth(20);
        $player->setScale(1.0);
        $player->getHungerManager()->setFood(20);
        $player->setGamemode(GameMode::fromString(0));
        $player->setImmobile(false);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $sword = ItemFactory::getInstance()->get(276, 0, 1);
        $helmet = ItemFactory::getInstance()->get(310, 0, 1);
        $chestplate = ItemFactory::getInstance()->get(311, 0, 1);
        $leggings = ItemFactory::getInstance()->get(312, 0, 1);
        $boots = ItemFactory::getInstance()->get(313, 0, 1);
        $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $chestplate->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $leggings->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $sword->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $player->getArmorInventory()->setHelmet($helmet);
        $player->getArmorInventory()->setChestplate($chestplate);
        $player->getArmorInventory()->setLeggings($leggings);
        $player->getArmorInventory()->setBoots($boots);
        $player->getInventory()->setItem(0, $sword);
        $player->getInventory()->setItem(1, ItemFactory::getInstance()->get(322, 0, 32));
    }

    public function getBuhcKit(Player $player)
    {
        $player->setHealth(20);
        $player->setScale(1.0);
        $player->getHungerManager()->setFood(20);
        $player->setGamemode(GameMode::fromString(0));
        $player->setImmobile(false);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $sword = ItemFactory::getInstance()->get(276, 0, 1);
        $helmet = ItemFactory::getInstance()->get(310, 0, 1);
        $chestplete = ItemFactory::getInstance()->get(311, 0, 1);
        $leggins = ItemFactory::getInstance()->get(312, 0, 1);
        $boots = ItemFactory::getInstance()->get(313, 0, 1);
        $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $chestplete->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $leggins->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $sword->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $player->getArmorInventory()->setHelmet($helmet);
        $player->getArmorInventory()->setChestplate($chestplete);
        $player->getArmorInventory()->setLeggings($leggins);
        $player->getArmorInventory()->setBoots($boots);
        $player->getInventory()->setItem(0, $sword);
        $player->getInventory()->setItem(1, ItemFactory::getInstance()->get(346, 0, 1));
        $player->getInventory()->setItem(2, ItemFactory::getInstance()->get(261, 0, 1));
        $player->getInventory()->setItem(3, ItemFactory::getInstance()->get(322, 0, 6));
        $player->getInventory()->setItem(4, ItemFactory::getInstance()->get(322, 0, 6)->setCustomName(TextFormat::colorize("&l&bNoobyMC")));
        $player->getInventory()->setItem(5, ItemFactory::getInstance()->get(278, 0, 1));
        $player->getInventory()->setItem(6, ItemFactory::getInstance()->get(279, 0, 1));
        $player->getInventory()->setItem(7, ItemFactory::getInstance()->get(4, 0, 64));
        $player->getInventory()->setItem(8, ItemFactory::getInstance()->get(4, 0, 64));
        $player->getInventory()->setItem(9, ItemFactory::getInstance()->get(262, 0, 64));
        $player->getInventory()->setItem(10, ItemFactory::getInstance()->get(325, 8, 1));
        $player->getInventory()->setItem(11, ItemFactory::getInstance()->get(325, 8, 1));
        $player->getInventory()->setItem(12, ItemFactory::getInstance()->get(325, 10, 1));
        $player->getInventory()->setItem(13, ItemFactory::getInstance()->get(325, 10, 1));
    }

    public function getKitSumo(Player $player)
    {
        $player->setHealth(20);
        $player->setScale(1.0);
        $player->getHungerManager()->setFood(20);
        $player->setGamemode(GameMode::fromString(0));
        $player->setImmobile(false);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getEffects()->add(new EffectInstance(EffectIdMap::getInstance()->fromId(EffectIds::RESISTANCE), 9999*100*20, 255, false));
    }


    public function getKitDebuff(Player $player)
    {
        $player->setHealth(20);
        $player->setScale(1.0);
        $player->getHungerManager()->setFood(20);
        $player->setGamemode(GameMode::fromString(0));
        $player->setImmobile(false);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $sword = ItemFactory::getInstance()->get(276, 0, 1);
        $helmet = ItemFactory::getInstance()->get(310, 0, 1);
        $chestplete = ItemFactory::getInstance()->get(311, 0, 1);
        $leggins = ItemFactory::getInstance()->get(312, 0, 1);
        $boots = ItemFactory::getInstance()->get(313, 0, 1);
        $helmet->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $chestplete->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $leggins->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $boots->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $sword->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(17), 10));
        $player->getArmorInventory()->setHelmet($helmet);
        $player->getArmorInventory()->setChestplate($chestplete);
        $player->getArmorInventory()->setLeggings($leggins);
        $player->getArmorInventory()->setBoots($boots);
        $player->getInventory()->setItem(0, $sword);
        $player->getInventory()->setItem(1, ItemFactory::getInstance()->get(368, 0, 16));
        $player->getInventory()->addItem(ItemFactory::getInstance()->get(438, 22, 36));

    }


    public function getKitFist(Player $player)
    {
        $player->setHealth(20);
        $player->setScale(1.0);
        $player->getHungerManager()->setFood(20);
        $player->setGamemode(GameMode::fromString(0));
        $player->setImmobile(false);
        $player->setAllowFlight(false);
        $player->setFlying(false);
        $player->getXpManager()->setXpLevel(0);
        $player->getXpManager()->setXpProgress(0.0);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
    }
}