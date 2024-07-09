<?php

declare(strict_types=1);

namespace Practice;

use muqsit\invmenu\InvMenuHandler;
use pocketmine\plugin\PluginBase;
use Practice\Arena\Manager\ArenaManager;
use Practice\Commands\SpawnCommand;

class Loader extends PluginBase
{

    public static self $instance;
    public ArenaManager $arenaManager;

    /**
     * @return Loader
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->arenaManager = new ArenaManager();
        $this->saveDefaultConfig();
        $this->saveResource('arenas.yml');
        $this->saveResource('kits.yml');
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register('setspawn', new SpawnCommand());
        $this->getArenaManager()->loadArenas();
        if (!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
    }

    public function getArenaManager(): ArenaManager
    {
        return $this->arenaManager;
    }
}