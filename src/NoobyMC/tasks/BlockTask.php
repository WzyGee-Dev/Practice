<?php

namespace NoobyMC\tasks;

use NoobyMC\Core;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\scheduler\Task;
use pocketmine\math\Vector3;

class BlockTask extends Task
{
    private Block $block;
    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function onRun(): void
    {
            $this->block->getPosition()->getWorld()->setBlockAt($this->block->getPosition()->getX(), $this->block->getPosition()->getY(), $this->block->getPosition()->getZ(), BlockFactory::getInstance()->get(0, 0, 0),);
    }
}