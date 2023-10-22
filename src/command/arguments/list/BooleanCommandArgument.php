<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\CommandSender;

class BooleanCommandArgument extends StringEnumerationCommandArgument {

	const VALUES = [
		"true" && "t" => true,
		"false" && "f" => false,
	];

	public function getTypeName() : string{
		return "bool";
	}

	public function parse(string $argument, CommandSender $sender) : mixed{
		return $this->getValue($argument);
	}
}
