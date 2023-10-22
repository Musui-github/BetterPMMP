<?php

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\gamerule\GameruleIds;
use pocketmine\world\World;

class DayLockCommand extends VanillaCommand{
	public function __construct(){
		parent::__construct(
			"daylock",
			KnownTranslationFactory::pocketmine_command_day_lock_description(),
			KnownTranslationFactory::commands_daylock_usage(),
			["alwaysday", "eternalday"]);
		$this->setPermission(DefaultPermissionNames::COMMAND_DAYLOCK);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
		/** @var World[] $worlds */
		$worlds = $sender instanceof Player ? [$sender->getWorld()] : $sender->getServer()->getWorldManager()->getWorlds();

		count($args) == 0 ? $state = true : $state = $args[0];
		foreach($worlds as $world){
			if ($state) {
				$world->setTime(1000);
				$world->stopTime();
				$world->getGameruleManager()->setGamerule(GameruleIds::DO_DAYLIGHT_CYCLE, false);
			} else {
				$world->startTime();
				$world->getGameruleManager()->setGamerule(GameruleIds::DO_DAYLIGHT_CYCLE, true);
			}
		}
		Command::broadcastCommandMessage($sender, KnownTranslationKeys::COMMANDS_DAYLOCK_USAGE);
	}
}