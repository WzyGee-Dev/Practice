<?php

namespace NoobyMC\scoreboards;

use NoobyMC\IPlayer\IPlayer;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class ScoreboardAPI
{

    use SingletonTrait {
        setInstance as protected;
        reset as protected;
    }

    private array $scoreboard = [];
    public IPlayer|null $target = null;


    public function createScore(Player $player, string $objectiveName, string $displayName): void
    {
        if(isset($this->scoreboard[$player->getName()])){
            $this->removeScore($player);
        }

        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = "sidebar";
        $pk->objectiveName = $objectiveName;
        $pk->displayName = $displayName;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = 0;
        $player->getNetworkSession()->sendDataPacket($pk);
        $this->scoreboard[$player->getName()] = $objectiveName;
    }

    /**
     * @param Player $player
     */
    public function removeScore(Player $player)
    {
        if(isset($this->scoreboard[$player->getName()])) {
            $objetiveName = $this->scoreboard[$player->getName()] ?? null;
            $pk = new RemoveObjectivePacket();
            $pk->objectiveName = $objetiveName;
            $player->getNetworkSession()->sendDataPacket($pk);
            unset($this->scoreboard[$player->getName()]);
        }
    }

    public function setLine(Player $player, int $score, string $message): void
    {
        if(!isset($this->scoreboard[$player->getName()])){
            return;
        }
        if($score > 15 || $score < 1){
            return;
        }
        $objetiveName = isset($this->scoreboard[$player->getName()]) ? $this->scoreboard[$player->getName()] : null;
        $entry = new ScorePacketEntry();
        $entry->objectiveName = $objetiveName;
        $entry->type = $entry::TYPE_FAKE_PLAYER;
        $entry->customName = $message;
        $entry->score = $score;
        $entry->scoreboardId = $score;
        $pk = new SetScorePacket();
        $pk->type = $pk::TYPE_CHANGE;
        $pk->entries[] = $entry;
        $player->getNetworkSession()->sendDataPacket($pk);
    }


    public function setTarget(?IPlayer $player): void {
        $this->target = $player;
    }
}