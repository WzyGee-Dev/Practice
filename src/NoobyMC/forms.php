<?php

namespace NoobyMC;

use NoobyMC\arena\JoinDuel;
use NoobyMC\arena\JoinPractice;
use NoobyMC\forms\CustomForm;
use NoobyMC\forms\SimpleForm;
use NoobyMC\IPlayer\IPlayer;
use NoobyMC\queue\QueueManager;
use NoobyMC\scoreboards\ScoreboardAPI;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class forms
{



    public function getArenas(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
           if($data === null) return;

           $click = Core::getInstance()->getArenas()->getArenas()[$data];
           $arena = new JoinPractice($player, $click);
           $arena->joinWorld();
        });
        $form->setTitle(TextFormat::colorize("FreeForAll"));
        $form->setContent("Select a ladder : ");
        foreach (Core::getInstance()->getArenas()->getArenas() as $arena){
            $form->addButton(Core::getInstance()->getArenaHandler()->getMode($arena) ."\n".count(Core::getInstance()->getPlayerManager()->getPlayers($arena))." Playing", 0, Core::getInstance()->getArenaHandler()->getImage($arena));
        }
        $form->sendToPlayer($player);
    }
    public function getArenasDuels(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if($data === null) return;

            $click = Core::getInstance()->getArenas()->getArenasDuel()[$data];
            $arena = new QueueManager($player, $click);
            $arena->addQueue();
        });
        $form->setTitle(TextFormat::colorize("Duels"));
        $form->setContent("Select a ladder : ");
        foreach (Core::getInstance()->getArenas()->getArenasDuel() as $arena){
            $form->addButton(Core::getInstance()->getArenaHandler()->getMode($arena) ."\n".count(Core::getInstance()->getPlayerDuelManager()->getPlayers($arena))." Playing", 0, Core::getInstance()->getArenaHandler()->getImage($arena));
        }
        $form->sendToPlayer($player);
    }



    public function getFormsPlayer(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data){
                case 0:
                    $this->getFormKills($player);
                    break;
                case 1:
                    $this->getFormDeaths($player);
                    break;
                case 2:
                    $this->getFormsStreak_kill($player);
                    break;
            }
        });
        $kills = Core::getInstance()->getDataHandler()->getKillsPlayer($player);
        $deaths = Core::getInstance()->getDataHandler()->getDeathsPlayer($player);
        $streak_kill = Core::getInstance()->getDataHandler()->getKillsStreakPlayer($player);
        $form->setTitle("Profile");
        $form->setContent("Your Profile: ".$player->getName());
        $form->addButton("Your Kills: \n".$kills);
        $form->addButton("Your Deaths: \n".$deaths);
        $form->addButton("Your Streak_kills: \n". $streak_kill);
        $form->sendToPlayer($player);
    }

    private function getFormKills(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data){
                case 0:
                    $this->getFormsPlayer($player);
                    break;
            }
        });
        $file = new Config(Core::getInstance()->getDataFolder(). "kills.yml");
        $data = $file->getAll();
        count($data);
        arsort($data);
        $leader = "";
        $i = 1;
        foreach ($data  as $datum => $amount) {
            $leader .= TextFormat::colorize("&b". $i. " - &9". $datum . ": &b". $amount. "\n\n");
            if($i > 9){
                break;
            }
            ++$i;
        }
        $form->setTitle("Leaderboard");
        $form->setContent("\n". $leader);
        $form->addButton(TextFormat::colorize("&l&cExit"));
        $form->sendToPlayer($player);
    }

    private function getFormDeaths(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if ($data === null) return;
        switch ($data){
            case 0:
                $this->getFormsPlayer($player);
                break;
        }
        });
        $file = new Config(Core::getInstance()->getDataFolder(). "deaths.yml");
        $data = $file->getAll();
        count($data);
        arsort($data);
        $leader = "";
        $i = 1;
        foreach ($data  as $datum => $amount) {
            $leader .= TextFormat::colorize("&b". $i. " - &9". $datum . ": &b". $amount. "\n\n");
            if($i > 9){
                break;
            }
            ++$i;
        }
        $form->setTitle("Leaderboard");
        $form->setContent("\n". $leader);
        $form->addButton(TextFormat::colorize("&l&cExit"));
        $form->sendToPlayer($player);
    }

    private function getFormsStreak_kill(Player $player)
    {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data){
                case 0:
                    $this->getFormsPlayer($player);
                    break;
            }
        });
        $file = new Config(Core::getInstance()->getDataFolder(). "streak_total.yml");
        $data = $file->getAll();
        count($data);
        arsort($data);
        $leader = "";
        $i = 1;
        foreach ($data  as $datum => $amount) {
            $leader .= TextFormat::colorize("&b". $i. " - &9". $datum . ": &b". $amount. "\n\n");
            if($i > 9){
                break;
            }
            ++$i;
        }
        $form->setTitle("Leaderboard");
        $form->setContent("\n". $leader);
        $form->addButton(TextFormat::colorize("&l&cExit"));
        $form->sendToPlayer($player);
    }


    public function getFormConfig(Player $player) {
        $form = new SimpleForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data) {
                case 0:
                   $this->scoreToggle($player);
                    break;
                case 1:
                    $this->sprintToggle($player);
                    break;
            }
        });
        $form->setTitle("Configuration");
        $form->addButton("Scoreboard");
        $form->addButton("Auto_sprint");
        $form->sendToPlayer($player);
    }
    public function scoreToggle(Player $player){
        $form = new CustomForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data[0]){
                case 0:
                    if(Core::getInstance()->getDataHandler()->getScoreboardPlayer($player)==false){
                        return;
                    }
                    Core::getInstance()->getPlayerManager()->setScoreboard($player, false);
                    $player->sendMessage(TextFormat::colorize("&aYou will no longer see your scoreboard"));
                    ScoreboardAPI::getInstance()->removeScore($player);
                    break;
                case 1:
                    if(Core::getInstance()->getDataHandler()->getScoreboardPlayer($player)==true){
                        return;
                    }
                    Core::getInstance()->getPlayerManager()->setScoreboard($player, true);
                    Core::getInstance()->getScoreboardManager()->setWorldScoreboard($player);
                    $player->sendMessage(TextFormat::colorize("&a You will now see your scoreboard."));
                    break;
                    }

        });
        $form->setTitle("Scoreboard");
        if(Core::getInstance()->getDataHandler()->getScoreboardPlayer($player)==true){
            $form->addToggle("Enabled", true, null);
        } else {
            $form->addToggle("Disabled", false, null);
        }
        $form->sendToPlayer($player);
    }

    private function sprintToggle(Player $player)
    {
        $form = new CustomForm(function (Player $player, $data = null): void {
            if ($data === null) return;
            switch ($data[0]) {
                case 0:
                    if (Core::getInstance()->getDataHandler()->getSprintPlayer($player) == false) {
                        return;
                    }
                    Core::getInstance()->getPlayerManager()->setSprintPlayer($player, false);
                    $player->sendMessage(TextFormat::colorize("&aYou will no longer see your auto_sprint"));
                    break;
                case 1:
                    if (Core::getInstance()->getDataHandler()->getSprintPlayer($player) == true) {
                        return;
                    }
                    Core::getInstance()->getPlayerManager()->setSprintPlayer($player, true);
                    $player->sendMessage(TextFormat::colorize("&a You will now see your auto_sprint."));
                    break;
            }
        });
        $form->setTitle("auto_sprint");
        if(Core::getInstance()->getDataHandler()->getSprintPlayer($player)==true){
            $form->addToggle("Enabled", true, null);
        } else {
            $form->addToggle("Disabled", false, null);
        }
        $form->sendToPlayer($player);
    }
}