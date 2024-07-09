<?php

namespace Practice\Items;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

class ItemClass extends Item
{

    public function __construct(ItemIdentifier $itemIdentifier, string $name)
    {
        $this->setCustomName($name);
        parent::__construct($itemIdentifier, $name);
        $this->getNamedTag()->setByte('lobby', 1);
    }
}