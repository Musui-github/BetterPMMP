<?php

namespace pocketmine\item;

class HorseArmor extends Item
{
	public const TYPE_LEATHER = 0;
	public const TYPE_IRON = 1;
	public const TYPE_GOLDEN = 2;
	public const TYPE_DIAMOND = 3;

	public function __construct(ItemIdentifier $identifier, protected $type, string $name = "Unknown", array $enchantmentTags = [])
	{
		parent::__construct($identifier, $name, $enchantmentTags);
	}

	/**
	 * @return int
	 */
	public function getType() : int{
		return $this->type;
	}

	/**
	 * @return int
	 */
	public function getMaxStackSize() : int{
		return 1;
	}
}