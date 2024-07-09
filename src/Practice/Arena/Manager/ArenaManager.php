<?php

namespace Practice\Arena\Manager;

use pocketmine\utils\Config;
use Practice\Arena\Arena;
use Practice\Loader;

class ArenaManager
{
    public array $arenas = [];

    public function loadArenas(): void
    {

        $config = new Config(Loader::getInstance()->getDataFolder(). 'arenas.yml', Config::YAML);
        $arenas = $config->get('arenas',[]);
        foreach ($arenas as $name => $data) {
            $this->createArena($name, $data);
        }
    }

    private function createArena(string $name, array $data): void
    {
        $this->arenas[$name] = new Arena($name, $data);
    }

    public function getArenas(): array
    {
        return $this->arenas;
    }
    public function getArena(string $arena): ?Arena
    {
        return $this->arenas[$arena] ?? null;
    }
}