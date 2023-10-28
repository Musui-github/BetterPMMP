<?php

namespace pocketmine\utils\webhook\embed\field;

use pocketmine\utils\webhook\embed\field\types\FieldTypes;

class Field implements \JsonSerializable
{
	protected array $data = array();

	/**
	 * @param string $name
	 *
	 * @return void
	 */
	public function setName(string $name) : void{
		$this->data[FieldTypes::NAME] = $name;
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function setValue(string $value) : void{
		$this->data[FieldTypes::VALUE] = $value;
	}

	/**
	 * @param bool $value
	 *
	 * @return void
	 */
	public function inLine(bool $value = true) : void{
		$this->data[FieldTypes::INLINE] = $value;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		return $this->data;
	}
}