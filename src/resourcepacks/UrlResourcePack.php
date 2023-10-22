<?php

namespace pocketmine\resourcepacks;

class UrlResourcePack implements ResourcePack
{
	public function __construct(
		protected string $name,
		protected string $id,
		protected string $version,
		protected string $url,
		protected string $encryptionKey = ""
	) {}

	public function getPackName() : string{
		return $this->name;
	}

	public function getPackId() : string{
		return $this->id;
	}

	public function getPackSize() : int{
		return 0;
	}

	public function getPackVersion() : string{
		return $this->version;
	}

	public function getSha256() : string{
		return "";
	}

	public function getPackChunk(int $start, int $length) : string
	{
		return 0;
	}

	/**
	 * @return string
	 */
	public function getUrl() : string{
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function getEncryptionKey() : string{
		return $this->encryptionKey;
	}
}