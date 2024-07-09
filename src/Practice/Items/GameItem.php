<?php

namespace Practice\Items;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemTypeIds;
use pocketmine\item\ItemUseResult;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Practice\Arena\Arena;
use Practice\Loader;

class GameItem extends ItemClass
{
    public function __construct()
    {
        parent::__construct(new ItemIdentifier(ItemTypeIds::DIAMOND_SWORD), TextFormat::GREEN.TextFormat::BOLD.'FFA'.TextFormat::RESET. '(Right click)');
    }


    public function onClickAir(Player $player, Vector3 $directionVector, array &$returnedItems): ItemUseResult
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName('selector ffa');
        $arenas = Loader::getInstance()->getArenaManager()->getArenas();
        $slot = 0;
        foreach ($arenas as $arena) {
            $menu->getInventory()->setItem($slot, $this->getIcon($arena));
            $slot++;
        }
        $menu->setListener(function (InvMenuTransaction $transaction) use ($arenas){
            $player = $transaction->getPlayer();
            $name = $transaction->getItemClicked()->getCustomName();
            $arena = Loader::getInstance()->getArenaManager()->getArena($name);
            if($arena !== null){
                $arena->join($player);
            }
            $transaction->getPlayer()->removeCurrentWindow();
            return $transaction->discard();
        });
        $menu->send($player);
        return ItemUseResult::SUCCESS;
    }

    public function getIcon(Arena $arena): \pocketmine\item\Item
    {
        return VanillaItems::DIAMOND_SWORD()->setCustomName($arena->getName())->setLore(['Players: '. $arena->getPlayerCount()]);
    }
}