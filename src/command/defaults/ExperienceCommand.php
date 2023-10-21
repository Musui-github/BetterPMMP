<?php

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;

class ExperienceCommand extends VanillaCommand{
	public function __construct(){
		parent::__construct(
			"experience",
			KnownTranslationFactory::pocketmine_command_experience_description(),
			KnownTranslationFactory::pocketmine_command_experience_description(),
			["xp"]);
		$this->setPermission(DefaultPermissionNames::COMMAND_EXPERIENCE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$xp = array_shift($args);
		$name = array_shift($args);

		if(($player = $sender->getServer()->getPlayerExact($name)) instanceof Player){
			if (str_ends_with($xp, "L")) {
				$player->getXpManager()->addXpLevels($player->getXpManager()->addXp($xp));
			} else {
				$player->getXpManager()->addXp($xp);
			}

			Command::broadcastCommandMessage($sender, KnownTranslationFactory::commands_experience_usage($xp, $player->getName()));
		}
		return true;
	}
}