<?php

namespace Practice\Sessions;

use pocketmine\player\Player;

class SessionManager
{

    private static array $sessions = [];

    public static function addSession(PlayerSession $session): void
    {
        self::$sessions[$session->getPlayer()->getName()] = $session;
    }

    public static function getSessions(): array
    {
        return self::$sessions;
    }

    public static function getSession(Player $player): ?PlayerSession
    {
        return self::$sessions[$player->getName()] ?? null;
    }


    public static function remove(Player $player): void
    {
        unset(self::$sessions[$player->getName()]);
    }
}