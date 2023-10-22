<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\types\command\CommandEnum;

abstract class StringEnumerationCommandArgument extends CommandArgument {

	protected const VALUES = [];

	public function __construct(string $name, bool $optional = false){
		parent::__construct($name, $optional);
		$this->commandParameter->enum = new CommandEnum("", $this->getEnumValues());
	}

	public function getNetworkType() : int{
		return -1;
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		return (bool)preg_match(
			"/^(" . implode("|", array_map("\\strtolower", $this->getEnumValues())) . ")$/iu",
			$testString
		);
	}

	public function getValue(string $string){
		return self::VALUES[strtolower($string)];
	}

	public function getEnumValues(): array{
		return array_keys(self::VALUES);
	}
}
