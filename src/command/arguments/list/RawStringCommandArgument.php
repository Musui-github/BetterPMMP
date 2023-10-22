<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class RawStringCommandArgument extends CommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_STRING;
	}

	public function getTypeName() : string{
		return "string";
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		return true;
	}

	public function parse(string $argument, CommandSender $sender) : string{
		return $argument;
	}
}
