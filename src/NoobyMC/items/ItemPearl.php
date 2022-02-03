<?php

namespace NoobyMC\items;

use pocketmine\item\EnderPearl;
use NoobyMC\Core;

class ItemPearl extends EnderPearl
{

    /**
     * @var int
     */
    private int $countdown = 0;

    public function getThrowForce(): float
    {
       return 2;
    }

    public function getCooldownTicks(): int
    {
        $this->countdown = time() + 15;
        return 20*15;
    }
}