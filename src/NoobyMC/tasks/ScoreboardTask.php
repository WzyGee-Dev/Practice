<?php

namespace NoobyMC\tasks;

use NoobyMC\Core;
use NoobyMC\IPlayer\CombatPlayer;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class ScoreboardTask extends Task
{
   /* private CombatPlayer $combatPlayer;

    public function __construct(CombatPlayer $combatPlayer)
    {
        $this->combatPlayer = $combatPlayer;
    }*/

    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
            if(Core::getInstance()->getPlayerManager()->inGame($onlinePlayer)){
                Core::getInstance()->getScoreboardManager()->setFreForAllScore($onlinePlayer);
            }
       }
    }

}