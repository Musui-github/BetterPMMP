<?php

namespace pocketmine\utils\webhook\embed;

use JsonSerializable;
use pocketmine\utils\webhook\embed\field\Field;
use pocketmine\utils\webhook\embed\types\EmbedTypes;

class Embed implements JsonSerializable
{
	protected array $data = array();

	/**
	 * @param string $title
	 *
	 * @return void
	 */
	public function setTitle(string $title) : void{
		$this->data[EmbedTypes::TITLE] = $title;
	}

	/**
	 * @param string $description
	 *
	 * @return void
	 */
	public function setDescription(string $description) : void{
		$this->data[EmbedTypes::DESCRIPTION] = $description;
	}

	/**
	 * @param string $color
	 *
	 * @return void
	 */
	public function setColor(string $color) : void{
		$this->data[EmbedTypes::COLOR] = $color;
	}

	/**
	 * @param string $url
	 *
	 * @return void
	 */
	public function setThumbnail(string $url) : void{
		$this->data[EmbedTypes::THUMBNAIL] = [
			"url" => $url
		];
	}

	/**
	 * @param string $footer
	 *
	 * @return void
	 */
	public function setFooter(string $footer) : void{
		$this->data[EmbedTypes::FOOTER] = $footer;
	}

	/**
	 * @param Field $field
	 *
	 * @return void
	 */
	public function addField(Field $field) : void{
		if(isset($this->data[EmbedTypes::FIELDS])) {
			$this->data[EmbedTypes::FIELDS] = [];
		}

		$this->data[EmbedTypes::FIELDS][] = $field->jsonSerialize();
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		return $this->data;
	}
}