<?php

namespace pocketmine\command\arguments\list;

use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;

class RawTextArgumentCommand extends RawStringCommandArgument {

	public function getNetworkType() : int{
		return AvailableCommandsPacket::ARG_TYPE_RAWTEXT;
	}

	public function getTypeName() : string{
		return "text";
	}
}
