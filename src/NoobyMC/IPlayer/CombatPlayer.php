<?php

namespace NoobyMC\IPlayer;

use NoobyMC\Core;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class CombatPlayer
{

    /**
     * @var Player
     */
    private Player $player;

    /**
     * @var int|mixed
     */
    private int $time = 0;
    private ?string $combat = null;
    private bool $isTagged = false;
    private int $ping = 0;
    public int $target = 0;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function setTaggeds(Player $opponent, $time = 15)
    {
        if ($this->isTagged) {
            $this->time = 15;
            return;
        }
            $this->time = $time;
            $this->combat = $opponent->getName();
            Core::getInstance()->player = $opponent;
            $this->isTagged = true;
            $this->player->sendMessage(TextFormat::colorize("&aYou are now in combat with ". $opponent->getName()));

    }
    public function setTarget(Player $player): void
    {
        $this->target = $player->getNetworkSession()->getPing();
    }
    public function isTagged(): bool
    {
        return $this->isTagged;
    }

    public function getOpponent(): ?string
    {
        return $this->combat;
    }

    public function getTimeCombat()
    {
       // $this->opponentPing();

        if($this->combat !== null){
            $opponent = Server::getInstance()->getPlayerByPrefix($this->combat);
            if(!$opponent instanceof Player || !$opponent->isOnline()){
                $this->combat = null;
                $this->isTagged = false;
                $this->time = 15;
               // $this->player->sendMessage(TextFormat::colorize("&cYou area out of combat"));
            }
        }
        if($this->isTagged && $this->time >= 0){
             $this->time--;
        }
        if($this->time === 0){
            $this->combat = null;
            $this->isTagged = false;
            $this->time = 15;
            Core::getInstance()->getScoreboardManager()->time = 0;
            $this->player->sendMessage(TextFormat::colorize("&cYou area out of combat"));
        }
        return $this->time;
    }

    public function getPing(): int
    {
        return $this->ping;
    }
   public function opponentPing(): void
   {

       if($this->combat !== null)
       {
           $opponent = Server::getInstance()->getPlayerByPrefix($this->combat);
                 $this->ping = $opponent->getNetworkSession()->getPing();
           }
   }
}