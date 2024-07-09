<?php

namespace Practice\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use Practice\Loader;

class SpawnCommand extends Command
{

    public function __construct()
    {
        parent::__construct('setspawn', 'enable spawns', 'usage /setspawn {arena}', []);
        $this->setPermission('spawn.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if($sender instanceof Player) {
            if (count($args) < 1) {
                $sender->sendMessage('Use: /setspawn {arena}');
                return true;
            }
            $arenaName = $args[0];
            $arena = Loader::getInstance()->getArenaManager()->getArena($arenaName);
            if ($arena === null) {
                $sender->sendMessage('La arena no existe.');
                return true;
            }
            $x = $sender->getPosition()->getX();
            $y = $sender->getPosition()->getY();
            $z = $sender->getPosition()->getZ();
            $config = new Config(Loader::getInstance()->getDataFolder(). 'arenas.yml', Config::YAML);
            $arenas = $config->get('arenas',[]);
            $arenas[$arenaName]['spawns'][] = [
                'x' => $x,
                'y' => $y,
                'z' => $z
            ];
            $config->set('arenas', $arenas);
            $config->save();
            $sender->sendMessage('Punto de spawn agregado');
            Loader::getInstance()->getArenaManager()->loadArenas();
        }
        return true;
    }
}