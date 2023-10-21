<?php

namespace pocketmine\item;

use pocketmine\entity\Location;
use pocketmine\entity\projectile\IceBomb as IceBombEntity;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

class IceBomb extends ProjectileItem
{
	/**
	 * @return int
	 */
	public function getMaxStackSize() : int{
		return 16;
	}

	/**
	 * @return int
	 */
	public function getCooldownTicks() : int{
		return 10;
	}

	protected function createEntity(Location $location, Player $thrower) : Throwable{
		return new IceBombEntity($location, $thrower);
	}

	public function getThrowForce() : float{
		return 1.5;
	}
}