<?php

namespace Practice\Arena;

use pocketmine\inventory\ArmorInventory;
use pocketmine\item\Armor;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Practice\Sessions\SessionManager;

class Arena
{


    public string $name;
    public array $data;
    public array $players = [];

    public function __construct(string $name, array $data)
    {
        $this->name = $name;
        $this->data = $data;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function join(Player $player): void
    {
        $this->players[$player->getName()] = $player;
        $session = SessionManager::getSession($player);
        if ($session !== null) {
            $session->setArena($this);
        }
        $spawn = $this->data['spawns'];
        if(count($spawn)>0){
            $spawnPoint = $spawn[array_rand($spawn)];
            $world = Server::getInstance()->getWorldManager()->getWorldByName($this->name);
            if($world !== null){
                $position = new Position($spawnPoint['x'], $spawnPoint['y'], $spawnPoint['z'], $world);
                $player->teleport($position);

            } else {
                $player->sendMessage('el mundo no tiene spawns');
            }
            } else {
            $player->sendMessage('el mundo no cumple con los spawns');
        }
    }

    public function leave(Player $player): void
    {
        unset($this->players[$player->getName()]);

        $session = SessionManager::getSession($player);
        if($session !== null){
            $session->setArena(null);
        }
    }

    public function getPlayerCount(): int
    {
        return count($this->players);
    }
public  function equipKit(Player $player): void
{
    //dev
}
    public function getSlotArmor(ArmorInventory $armorInventory, Armor $armor): void
    {
        switch ($armor->getArmorSlot()){
            case ArmorInventory::SLOT_HEAD:
                $armorInventory->setHelmet($armor);
                break;
            case ArmorInventory::SLOT_CHEST:
                $armorInventory->setChestplate($armor);
                break;
            case ArmorInventory::SLOT_LEGS:
                $armorInventory->setLeggings($armor);
                break;
            case ArmorInventory::SLOT_FEET:
                $armorInventory->setBoots($armor);
                break;
            default:
                //NOOOOP
                break;
        }
    }
}