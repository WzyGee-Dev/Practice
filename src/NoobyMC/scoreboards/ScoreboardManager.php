<?php

namespace NoobyMC\scoreboards;

use NoobyMC\Core;
use NoobyMC\IPlayer\CombatPlayer;
use NoobyMC\IPlayer\IPlayer;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class ScoreboardManager
{

    public ?int $time = 0;

    public function setWorldScoreboard(Player $player)
    {
        ScoreboardAPI::getInstance()->createScore($player, $player->getName(), TextFormat::BOLD.TextFormat::BLUE."NoobyMC");
        $lines =
            [
                " " .TextFormat::colorize("Playing: &a" . count(Server::getInstance()->getOnlinePlayers())),
                " ".TextFormat::colorize("Queued: &a". 0),
                " ".TextFormat::colorize(" "),
                " ".TextFormat::colorize("Coins: &a" . 0),
                " ".TextFormat::colorize("Division: &a". "null"),
                " ".TextFormat::colorize("              "),
                " ".TextFormat::colorize("NoobyMC")
            ];
        $i=0;
        foreach ($lines as $line) {
            if($line < 15){
                $i++;
                ScoreboardAPI::getInstance()->setLine($player, $i, $line);
            }

        }
    }

    public function setFreForAllScore(Player $player)
    {
        $this->time = 0;
        if(!is_null(Core::getInstance()->player)){
            $this->time = Core::getInstance()->player->getNetworkSession()->getPing();
        }
        ScoreboardAPI::getInstance()->createScore($player, $player->getName(), TextFormat::BOLD . TextFormat::BLUE . "Practice");
        ScoreboardAPI::getInstance()->setLine($player, 1, "----------");
        ScoreboardAPI::getInstance()->setLine($player, 2, " ");
        ScoreboardAPI::getInstance()->setLine($player, 3, TextFormat::colorize("Your Ping: &a" . $player->getNetworkSession()->getPing(). "ms"));
        ScoreboardAPI::getInstance()->setLine($player, 4, TextFormat::colorize("Their Ping: &a". $this->time."ms"));
        ScoreboardAPI::getInstance()->setLine($player, 5, TextFormat::colorize("Combat: &a" . Core::getInstance()->getPlayerManager()->getPlayerC($player)->getTimeCombat()."s"));
        ScoreboardAPI::getInstance()->setLine($player, 6, " ");
        ScoreboardAPI::getInstance()->setLine($player, 7, "----------");
            }


            public function setWaitingDuelScore(Player $player)
            {
                ScoreboardAPI::getInstance()->createScore($player, $player->getName(), TextFormat::BOLD.TextFormat::BLUE."Duel");
                ScoreboardAPI::getInstance()->setLine($player, 1, "   ");
                ScoreboardAPI::getInstance()->setLine($player, 2, TextFormat::colorize("&aWaiting player"));
                ScoreboardAPI::getInstance()->setLine($player, 3, "  ");
            }
}