<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\data\bedrock\item\BlockItemIdMap;
use pocketmine\item\StringToItemParser;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class BlockCommandArgument extends CommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_BLOCK_STATES;
	}

	public function getTypeName() : string{
		return "block";
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		return true;
	}

	public function parse(string $argument, CommandSender $sender) : \pocketmine\item\Item|bool|\pocketmine\item\enchantment\Enchantment|\pocketmine\entity\effect\Effect{
		$argument = str_starts_with($argument, "minecraft:") ? $argument : (str_contains($argument, ":") ? $argument : "minecraft:" . $argument);
		$blockIdentifier = StringToItemParser::getInstance()->parse($argument);

		if ($blockIdentifier != null) {
			return $blockIdentifier;
		}
		return false;
	}
}
