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

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

/**
 * Called when a player has its gamemode changed
 */
class PlayerGameSpeedChangeEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	public const SERVER_REASON = 0;
	public const PLUGIN_REASON = 1;

	public function __construct(
		Player $player,
		protected float $speed,
		protected int $reason
	){
		$this->player = $player;
	}

	/**
	 * @return int
	 */
	public function getReason() : int{
		return $this->reason;
	}

	/**
	 * @param int $reason
	 *
	 * @return void
	 */
	public function setReason(int $reason) : void{
		$this->reason = $reason;
	}

	/**
	 * @return float
	 */
	public function getSpeed() : float{
		return $this->speed;
	}

	/**
	 * @param float $speed
	 *
	 * @return void
	 */
	public function setSpeed(float $speed) : void{
		$this->speed = $speed;
	}
}
