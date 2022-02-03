<?php

namespace NoobyMC\items;

use pocketmine\entity\animation\ArmSwingAnimation;
use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

class Rod extends Durable
{

    public function getMaxStackSize(): int
    {
        return 1;// TODO: Change the autogenerated stub
    }

    public function getCooldownTicks(): int
    {
        return 5; // TODO: Change the autogenerated stub
    }

    public function getMaxDurability(): int
    {
       return 355; // TODO: Implement getMaxDurability() method.
    }

    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        if(!$player->hasItemCooldown($this)){
            $player->resetItemCooldown($this);

            $motion = $player->getDirectionVector();
            $motion = $motion->multiply(0.4);
            $fishing_hook = new FishingHook($player->getLocation(), $player, new CompoundTag());
            $fishing_hook->spawnToAll();
            $player->broadcastAnimation(new ArmSwingAnimation($player));
            return ItemUseResult::SUCCESS();
        }
        return ItemUseResult::FAIL();
         // TODO: Change the autogenerated stub
    }

    public function getProjectileEntityType(): string{
        return "FishingHook";
    }
    public function getTrowForce(): float
    {
        return 0.9;
    }

}