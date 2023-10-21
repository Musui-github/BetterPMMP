<?php

namespace pocketmine\entity;

use pocketmine\item\HorseArmor;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\player\Player;

class Horse extends Living{
	protected ?HorseArmor $armor = null;

	protected function getInitialSizeInfo() : EntitySizeInfo{
		return new EntitySizeInfo(1, 1);
	}

	public static function getNetworkTypeId() : string{
		return EntityIds::HORSE;
	}

	public function getName() : string{
		return "Horse";
	}

	/**
	 * @param HorseArmor|null $armor
	 */
	public function setArmor(?HorseArmor $armor = null) : void{
		$this->armor = $armor;
	}

	/**
	 * @return HorseArmor|null
	 */
	public function getArmor() : ?HorseArmor{
		return $this->armor;
	}

	public function onInteract(Player $player, Vector3 $clickPos) : bool{
		$item = $player->getInventory()->getItemInHand();

		if ($item instanceof HorseArmor) {
			if ($this->getArmor() != null) {
				$this->getWorld()->dropItem($this->getPosition(), $this->getArmor());
			}
			$this->setArmor($item);
			return true;
		}

		return false;
	}
}