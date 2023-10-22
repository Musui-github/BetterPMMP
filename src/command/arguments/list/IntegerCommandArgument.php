<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class IntegerCommandArgument extends CommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_INT;
	}

	public function getTypeName() : string{
		return "int";
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		return preg_match("/^-?(?:\d+)$/", $testString);
	}

	public function parse(string $argument, CommandSender $sender) : int{
		return (int)$argument;
	}
}