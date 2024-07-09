<?php

namespace Practice\Sessions;

use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Practice\Arena\Arena;
use Practice\extensions\Scoreboard;
use Practice\Items\GameItem;
use Practice\Loader;

class PlayerSession
{


    public Player $player;
    public ?Arena $arena;
    public \pocketmine\scheduler\TaskHandler $scoreTask;

    public function __construct(Player $player, ?Arena $arena)
    {
        $this->player = $player;
        $this->arena = $arena;
        $this->startScoreboard();
    }
    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getArena(): ?Arena
    {
        return $this->arena;
    }

    public function setArena(?Arena $arena): void
    {
        $this->arena = $arena;
    }

    public function onLoad(): void
    {
        $player = $this->player;
        $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->setHealth($player->getMaxHealth());
        $player->getHungerManager()->setFood($player->getHungerManager()->getMaxFood());
        $player->setGamemode(GameMode::ADVENTURE);
        $player->getInventory()->setItem(0, new GameItem());
    }

    private function startScoreboard(): void
    {
        $this->scoreTask = Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new class ($this) extends Task
        {
            private PlayerSession $session;
            public function __construct(PlayerSession $playerSession)
            {
              $this->session = $playerSession;
            }
            public function onRun(): void
            {
                $this->session->updateScoreboard();
            }
        }, 20 * 20);
    }


    public function updateScoreboard(): void
    {
        Scoreboard::new($this->player, 'lobby', TextFormat::BOLD.TextFormat::YELLOW.'PRACTICE');
        Scoreboard::setLine($this->player, 0, '|| Username: '.TextFormat::YELLOW.$this->player->getName());
        Scoreboard::setLine($this->player, 1, '|| Ping: '. TextFormat::YELLOW.$this->player->getNetworkSession()->getPing());
        Scoreboard::setLine($this->player, 2, '|| Ranks: ');
        Scoreboard::setLine($this->player, 3, 'default');
        Scoreboard::setLine($this->player, 4 , '  ');

    }

    public function removeScore(): void
    {
        Scoreboard::remove($this->player);
        $this->scoreTask->cancel();
    }
}