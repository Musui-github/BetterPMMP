<?php

namespace pocketmine\world\gamerule;

final class GameruleIds
{
	public const DO_DAYLIGHT_CYCLE = 'doDaylightCycle';
	public const NATURAL_REGENERATION = 'naturalRegeneration';
	public const MOB_GRIEFING = 'mobGriefing';
	public const DO_WEATHER_CYCLE = 'doWeatherCycle';
	public const KEEP_INVENTORY = 'keepInventory';
	public const SHOW_COORDINATES = 'showcoordinates';
	public const TNT_EXPLODES = 'tntExplodes';
	public const COMMAND_BLOCK_OUTPUT = 'commandBlockOutput';
	public const DO_INSOMNIA = 'doInsomnia';
	public const MAX_ENTITY_CRAMMING = 'maxEntityCramming';
	public const RANDOM_TICK_SPEED = 'randomTickSpeed';
	public const SPAWN_RADIUS = 'spawnRadius';
	const TYPE_BOOL = 0;
	const TYPE_INT = 1;
	const TYPE_UNKNOWN = 2;

	/**
	 * @param string $id
	 *
	 * @return bool
	 */
	public static function validGamerule(string $id) : bool{
		return  match ($id) {
			self::DO_DAYLIGHT_CYCLE, self::NATURAL_REGENERATION, self::MOB_GRIEFING, self::DO_WEATHER_CYCLE, self::KEEP_INVENTORY, self::TNT_EXPLODES, self::COMMAND_BLOCK_OUTPUT, self::DO_INSOMNIA, self::MAX_ENTITY_CRAMMING, self::RANDOM_TICK_SPEED, self::SPAWN_RADIUS, self::SHOW_COORDINATES => true,
			default => false
		};
	}

	public static function getType(string $id) : int{
		return match ($id) {
			self::DO_DAYLIGHT_CYCLE, self::NATURAL_REGENERATION, self::MOB_GRIEFING, self::DO_WEATHER_CYCLE, self::KEEP_INVENTORY, self::TNT_EXPLODES, self::COMMAND_BLOCK_OUTPUT, self::DO_INSOMNIA, self::SHOW_COORDINATES => self::TYPE_BOOL,
			self::MAX_ENTITY_CRAMMING, self::RANDOM_TICK_SPEED, self::SPAWN_RADIUS => self::TYPE_INT,
			default => self::TYPE_UNKNOWN,
		};
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public static function boolVal(mixed $value) : bool{
		if($value === "true" || $value === "1") {
			return true;
		} elseif($value === "false" || $value === "0") {
			return false;
		} else return boolval($value);
	}
}