<?php

namespace pocketmine\form;

use InvalidArgumentException;
use pocketmine\player\Player;
use WeakMap;

abstract class Form implements IForm {
	/** @var array */
	protected array $data = [];
	/**
	 * @var WeakMap<Player, ServerForm>
	 */
	public static WeakMap $serverForm;
	/**
	 * @var WeakMap<Player, int>
	 */
	public static WeakMap $playerFormId;
	/** @var callable|null */
	private $callable;

	public static function setServerForm(Player $player, ServerForm $form) : void{
		if (!isset(self::$serverForm)) {
			self::$serverForm = new WeakMap();
		}

		if (isset(self::$serverForm[$player])) {
			self::$serverForm[$player] = [];
		}

		self::$serverForm[$player] = $form;
	}

	public static function removeServerForm(Player $player, string $title): void
	{
		if (isset(self::$serverForm[$player])) {
			$list = self::$serverForm[$player];
			foreach ($list as $index => $value) {
				if ($value->getTitle() === $title) {
					unset(self::$serverForm[$player][$index]);
					return;
				}
			}
		}
	}

	public static function getServerFormOf(Player $player): ?ServerForm
	{
		if (!isset(self::$serverForm)) self::$serverForm = new WeakMap();
		return self::$serverForm[$player] ?? null;
	}

	public static function getIdOf(Player $player): int
	{
		if (!isset(self::$playerFormId)) self::$playerFormId = new WeakMap();
		if (!isset(self::$playerFormId[$player])) self::$playerFormId[$player] = 0;
		return self::$playerFormId[$player]++;
	}

	/**
	 * @return WeakMap
	 */
	public static function getServerForm(): WeakMap
	{
		return self::$serverForm;
	}

	/**
	 * @param callable|null $callable
	 */
	public function __construct(?callable $callable) {
		$this->callable = $callable;
	}

	/**
	 * @param Player $player
	 * @throws InvalidArgumentException
	 * @deprecated
	 * @see Player::sendForm()
	 */
	public function sendToPlayer(Player $player) : void {
		$player->sendForm($this);
	}

	public function getCallable() : ?callable {
		return $this->callable;
	}

	public function setCallable(?callable $callable) : void{
		$this->callable = $callable;
	}

	public function handleResponse(Player $player, $data) : void {
		$this->processData($data);
		$callable = $this->getCallable();
		if($callable !== null) {
			$callable($player, $data);
		}
	}

	public function processData(&$data) : void {
	}

	public function jsonSerialize() : array {
		return $this->data;
	}
}