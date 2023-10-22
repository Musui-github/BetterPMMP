<?php

namespace pocketmine\entity;

use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

class Balloon extends Living
{
	protected ?Living $riding = null;

	protected function getInitialSizeInfo() : EntitySizeInfo{ return new EntitySizeInfo(0.25, 0.25); }
	public static function getNetworkTypeId() : string{ return EntityIds::BALLOON; }
	public function getName() : string{ return "Balloon"; }

	/**
	 * @param Living|null $living
	 *
	 * @return void
	 */
	public function setRiding(Living $living = null) : void{
		$this->riding = $living;
	}

	public function onUpdate(int $currentTick) : bool{
		if(!is_null($this->riding)) {
			if ($this->riding instanceof Balloon) {
				$this->flagForDespawn();
				return false;
			}

			$this->setPosition($this->riding->getPosition());
		} else {
			$this->flagForDespawn();
			return false;
		}

		return parent::onUpdate($currentTick);
	}
}