<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\math\Vector3;

/**
 * Called when an Entity, excluding players, changes a block directly
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityArrowPunchEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	public function __construct(
		Entity $entity,
		protected Arrow $arrow,
		protected float $multiplier,
		protected Vector3 $motion
	){
		$this->entity = $entity;
	}

	/**
	 * @return Arrow
	 */
	public function getArrow() : Arrow{
		return $this->arrow;
	}

	/**
	 * @return float
	 */
	public function getMultiplier() : float{
		return $this->multiplier;
	}

	/**
	 * @return Vector3
	 */
	public function getMotion() : Vector3{
		return $this->motion;
	}
}
