<?php

namespace pocketmine\form;

class ServerForm extends CustomForm{
	public function __construct(?callable $callable)
	{
		parent::__construct($callable);
		$this->setIcon();
	}

	public function setIcon(int $type = -1, string $path = "") {
		$this->data["icon"]["type"] = $type === 0 ? "path" : "url";
		$this->data["icon"]["data"] = $path;
	}
}