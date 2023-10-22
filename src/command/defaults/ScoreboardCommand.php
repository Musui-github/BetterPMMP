<?php

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;

class ScoreboardCommand extends VanillaCommand{
	public function __construct(){
		parent::__construct(
			"scoreboard",
			KnownTranslationFactory::pocketmine_command_help_description(),
			KnownTranslationFactory::commands_scoreboard_usage(),
			["board", "sb"]);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
	}
}