<?php

namespace NoobyMC\arena;

use NoobyMC\Core;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class JoinDuel
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


    public function joinWorld()
    {

    }
}