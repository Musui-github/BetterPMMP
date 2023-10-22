<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class FloatCommandArgument extends CommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_FLOAT;
	}

	public function getTypeName() : string{
		return "float";
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		return (bool)preg_match("/^-?(?:\d+|\d*\.\d+)$/", $testString);
	}

	public function parse(string $argument, CommandSender $sender) : float{
		return (float)$argument;
	}
}
