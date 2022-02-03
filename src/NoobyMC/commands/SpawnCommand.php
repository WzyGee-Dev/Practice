<?php

namespace NoobyMC\commands;

use NoobyMC\Core;
use NoobyMC\scoreboards\ScoreboardAPI;
use NoobyMC\Utils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\Server;

class SpawnCommand extends Command
{

    public function __construct()
    {
        parent::__construct("spawn", "return a lobby");
        $this->setAliases(["hub"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $sender->setGamemode(GameMode::fromString(0));
            $sender->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            Core::getInstance()->getPlayerManager()->removePlayer($sender);
            Utils::setItems($sender);
            ScoreboardAPI::getInstance()->removeScore($sender);
        }
    }
}