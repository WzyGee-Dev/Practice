<?php

namespace NoobyMC\queue;

use NoobyMC\Core;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;

class Queue
{

    private Player $player;
    private string $world;
    private mixed $mode;

    public function __construct(Player $player, string $world)
    {
        $this->player = $player;
        $this->world = $world;
        $file = new Config(Core::getInstance()->getDataFolder()."Arenas/".$world.".yml");
        $data = $file->get($world);
        $this->mode = $data["mode"];
    }


    public function joinQueue()
    {
        switch ($this->mode)
        {
            case "nodebuff":
                if(count(Core::getInstance()->getPlayerDuelManager()->getDebuffPlayer()) >= 2){
                    $this->player->sendMessage(TextFormat::colorize("&cThe game is full"));
                    return true;
                }
                Core::getInstance()->getPlayerDuelManager()->addGapplePlayer($this->player);
                $this->player->getEffects()->clear();
                $this->player->getArmorInventory()->clearAll();
                $this->player->getInventory()->clearAll();
                $this->player->getHungerManager()->setFood(20);
                $this->player->setHealth(20);
                $this->player->setGamemode(GameMode::fromString(0));

                //$this->player->teleport(new Position($spawn[0], $spawn[1] + 0.6, $spawn[2], Server::getInstance()->getWorldManager()->getWorldByName($this->world)));
                Core::getInstance()->getKitManager()->setKit($this->player, $this->mode);
                break;
        }
    }
}