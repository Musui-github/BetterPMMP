<?php

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class LivingVelocityEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/**
	 * @param Living  $entity
	 * @param Living  $attacker
	 * @param Vector3 $velocity
	 * @param float   $force
	 * @param float   $verticalLimit
	 */
	public function __construct(
		Living $entity,
		protected Entity $attacker,
		protected Vector3 $velocity,
		protected float $force,
		protected float $verticalLimit
	){
		$this->entity = $entity;
	}

	/**
	 * @return Living
	 */
	public function getAttacker() : Living{
		return $this->attacker;
	}

	/**
	 * @return Vector3
	 */
	public function getVelocity() : Vector3{
		return $this->velocity;
	}

	/**
	 * @param Vector3 $vector3
	 *
	 * @return void
	 */
	public function setVelocity(Vector3 $vector3) : void{
		$this->velocity = $vector3;
	}

	/**
	 * @return float
	 */
	public function getForce() : float{
		return $this->force;
	}

	/**
	 * @param float $force
	 *
	 * @return void
	 */
	public function setForce(float $force) : void{
		$this->force = $force;
	}

	/**
	 * @return float
	 */
	public function getVerticalLimit() : float{
		return $this->verticalLimit;
	}

	/**
	 * @param float $limit
	 *
	 * @return void
	 */
	public function setVerticalLimit(float $limit) : void{
		$this->verticalLimit = $limit;
	}

	/**
	 * @param Vector3 $vector3
	 * @param Vector2 $velocity
	 *
	 * @return void
	 */
	public function calculateVelocity(Vector3 $vector3, Vector2 $velocity) : void{
		$f = sqrt($vector3->x ** 2 + $vector3->z ** 2);
		if($f <= 0){
			return;
		}

		$motionX = $this->getEntity()->getMotion()->x / 2;
		$motionY = $this->getEntity()->getMotion()->y / 2;
		$motionZ = $this->getEntity()->getMotion()->z / 2;
		$motionX += $vector3->x * $f * $velocity->x;
		$motionY += $velocity->y;
		$motionZ += $vector3->z * $f * $velocity->x;

		$this->setVelocity(new Vector3($motionX, $motionY, $motionZ));
	}
}