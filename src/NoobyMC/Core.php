<?php

declare(strict_types=1);

namespace NoobyMC;

use NoobyMC\arena\Arena;
use NoobyMC\commands\DuelCommand;
use NoobyMC\commands\FreeForAllCommand;
use NoobyMC\commands\SpawnCommand;
use NoobyMC\entities\FishingHook;
use NoobyMC\handlers\Arenahandler;
use NoobyMC\handlers\Databasehandler;
use NoobyMC\handlers\DuelHandler;
use NoobyMC\IPlayer\PlayerDuel;
use NoobyMC\IPlayer\PlayerPractice;
use NoobyMC\items\ItemPearl;
use NoobyMC\items\Rod;
use NoobyMC\KitManager\KitManager;
use NoobyMC\listeners\FreeForAllListener;
use NoobyMC\listeners\PlayerListener;
use NoobyMC\listeners\WorldListener;
use NoobyMC\scoreboards\ScoreboardManager;
use NoobyMC\tasks\ScoreboardTask;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\Server;
use pocketmine\world\World;

class Core extends PluginBase
{

    const PREFIX = "&b[NoobyMC]";
    const SERVER_IP = "null";

    /**
     * @var Core
     */
    private static Core $instance;
    /**
     * @var Databasehandler
     */
    public Databasehandler $datahandler;

    /**
     * @var Arenahandler
     */
    public Arenahandler $arenadatahandler;
    /**
     * @var Arena
     */
    public Arena $arenas;
    /**
     * @var forms
     */
    public forms $forms;
    /**
     * @var KitManager
     */
    private KitManager $kitmanager;
    /**
     * @var PlayerPractice
     */
    private PlayerPractice $playermanager;

    /**
     * @var ScoreboardManager
     */
    private ScoreboardManager $scoreboardManager;

    public array $countdown = [];
    /**
     * @var DuelHandler
     */
    private DuelHandler $duelhandler;

    public ?Player $player = null;
    public int $ping = 0;
    private PlayerDuel $playerduelmanager;

    public function onEnable(): void
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder(). "playerdata");
        @mkdir($this->getDataFolder(). "Arenas");
        $this->saveResource("config.yml");
        $this->getLogger()->info(
            "---NoobyPractice enable---"
        );
        $this->setVariable();
        $this->setItems();
        $this->sethandlers();
        $this->setListeners();
        $this->setCommands();
        $this->setEntities();
        $this->setUnicodes();
        $this->setTask();
        $this->getArenaHandler()->loadWorlds();
        parent::onEnable(); // TODO: Change the autogenerated stub
    }

    public function getPrefix(): string
    {
        return self::PREFIX;
    }

    public function getIp(): string
    {
        return self::SERVER_IP;
    }

    private function setListeners()
    {
        new PlayerListener();
        new WorldListener();
        new FreeForAllListener();
    }

    private function sethandlers() {
       $this->datahandler = new Databasehandler();
    }

    public function getDataHandler(): Databasehandler {
        return $this->datahandler;
    }

    public function getDuelHandler(): DuelHandler
    {
        return $this->duelhandler;
    }
    public function getArenaHandler(): Arenahandler {
        return $this->arenadatahandler;
    }
    public function getKitManager(): KitManager
    {
        return $this->kitmanager;
    }
    public function getForms(): forms
    {
        return $this->forms;
    }

    public function getPlayerManager(): PlayerPractice
    {
        return $this->playermanager;
    }

    public function getPlayerDuelManager(): PlayerDuel
    {
        return $this->playerduelmanager;
    }

    public function getScoreboardManager(): ScoreboardManager
    {
        return $this->scoreboardManager;
    }

    public static function getInstance(): self{
        return self::$instance;
    }

    public function getArenas(): Arena
    {
        return $this->arenas;
    }

    private function setCommands()
    {
        $map = $this->getServer()->getCommandMap();
        $map->register("freeforall", new FreeForAllCommand());
        $map->register("spawn", new SpawnCommand());
        $map->register("duel", new DuelCommand());
    }



    private function setVariable()
    {
        $this->arenas = new Arena();
        $this->arenadatahandler = new Arenahandler();
        $this->forms = new forms();
        $this->kitmanager = new KitManager();
        $this->playermanager = new PlayerPractice();
        $this->scoreboardManager = new ScoreboardManager();
        $this->duelhandler = new DuelHandler();
        $this->playerduelmanager = new PlayerDuel();
    }

    private function setEntities()
    {

        EntityFactory::getInstance()->register(FishingHook::class, static function (World $world, CompoundTag $nbt): FishingHook {
            return new FishingHook(EntityDataHelper::parseLocation($nbt, $world),null, $nbt);
        }, ["FishingHook", "minecraft:fishing_hook"], EntityLegacyIds::FISHING_HOOK);
    }
    private function setItems()
    {
        ItemFactory::getInstance()->register(new Rod(new ItemIdentifier(ItemIds::FISHING_ROD, 0)), true);
        ItemFactory::getInstance()->register(new ItemPearl(new ItemIdentifier(ItemIds::ENDER_PEARL, 0)), true);

    }
    private function setUnicodes()
    {
        $this->saveResource("Unicodes.mcpack", true);
        $manager = $this->getServer()->getResourcePackManager();
        $pack = new ZippedResourcePack($this->getDataFolder(). "Unicodes.mcpack");
        $refection = new \ReflectionClass($manager);
        $property = $refection->getProperty("uuidList");
        $property->setAccessible(true);
        $currentUUID = $property->getValue($manager);
        $currentUUID[strtolower($pack->getPackId())] = $pack;
        $property->setValue($manager, $currentUUID);
        $property = $refection->getProperty("serverForceResources");
        $property->setAccessible(true);
        $property->setValue($manager, true);
    }

    private function setTask()
    {
        $this->getScheduler()->scheduleRepeatingTask(new ScoreboardTask(), 20);
    }



    public function onDisable(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {


        } // TODO: Change the autogenerated stub
    }
}