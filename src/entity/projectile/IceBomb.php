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

namespace pocketmine\entity\projectile;

use pocketmine\block\Air;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\Water;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\world\particle\WaterParticle;

class IceBomb extends Throwable{
	public static function getNetworkTypeId() : string{ return EntityIds::ICE_BOMB; }

	protected function onHit(ProjectileHitEvent $event) : void{
		for($i = 0; $i < 6; ++$i){
			$this->getWorld()->addParticle($this->location->add(0, 0.8, 0), new WaterParticle());
		}
	}

	public function onUpdate(int $currentTick) : bool{
		$position = $this->getPosition();

		$target = ($world = $this->getWorld())->getBlock($position);

		if ($target instanceof Air) $target = $world->getBlock($position->add(0, -1, 0));

		if(!$target instanceof Air) {
			$radiusX = mt_rand(1, 2);
			$radiusZ = mt_rand(1, 2);
			for ($x = -$radiusX; $x <= $radiusX; $x++) {
				for ($y = -1; $y <= 1; $y++){
					for($z = -$radiusZ; $z <= $radiusZ; $z++){
						$block = $world->getBlock($position->add($x, $y, $z));
						if($block instanceof Water){
							$world->setBlock($position->add($x, $y, $z), VanillaBlocks::ICE());
						}
					}
				}
			}

			$this->flagForDespawn();
			return false;
		}
		return parent::onUpdate($currentTick);
	}
}
