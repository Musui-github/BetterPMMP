<?php

namespace pocketmine\command\arguments\list;

use pocketmine\command\arguments\CommandArgument;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class PositionCommandArgument extends CommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_POSITION;
	}

	public function getTypeName() : string{
		return "x y z";
	}

	public function canParse(string $testString, CommandSender $sender) : bool{
		$position = explode(" ", $testString);
		if (count($position) === 3) {
			foreach($position as $vector) {
				if ($this->isValid($vector, $sender instanceof Vector3)) {
					return false;
				}
 			}
			return true;
		}
		return false;
	}

	public function parse(string $argument, CommandSender $sender) : Vector3{
		$values = [];
		$position = explode(" ", $argument);

		foreach ($position as $key => $vector) {
			$offset = 0;
			if  (preg_match("/^(?:~-|~\+)|~/", $vector) && $sender instanceof Entity) {
				$offset = substr($vector, 1);
				$pos = $sender->getPosition();

				$vector = match ($key) {
					0 =>  $pos->getX(),
					1 => $pos->getY(),
					2 => $pos->getZ(),
				};
			}

			$values[] = $vector + $offset;
		}

		return new Vector3(...$values);
	}

	public function isValid(string $coordinate, bool $locatable): bool {
		return (bool)preg_match("/^(?:" . ($locatable ? "(?:~-|~\+)?" : "") . "-?(?:\d+|\d*\.\d+))" . ($locatable ? "|~" : "") . "$/", $coordinate);
	}
}