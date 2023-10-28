<?php

namespace pocketmine\utils\webhook;

use JsonSerializable;
use pocketmine\utils\webhook\embed\Embed;
use pocketmine\utils\webhook\task\WebhookSenderTask;
use pocketmine\utils\webhook\types\WebhookTypes;

class Webhook implements JsonSerializable
{
	protected array $data = array();
	protected string $url = "";
	protected int $id = WebhookSenderTask::$nextID++;

	/**
	 * @return string|null
	 */
	public function getContent() : mixed{
		return $this->data[WebhookTypes::CONTENT] ?? null;
	}

	/**
	 * @param string $content
	 *
	 * @return void
	 */
	public function setContent(string $content) : void{
		$this->data[WebhookTypes::CONTENT] = $content;
	}

	/**
	 * @return string|null
	 */
	public function getUsername() : mixed{
		return $this->data[WebhookTypes::USERNAME] ?? null;
	}

	/**
	 * @param string $username
	 *
	 * @return void
	 */
	public function setUsername(string $username) : void{
		$this->data[WebhookTypes::USERNAME] = $username;
	}

	/**
	 * @param string $avatarUrl
	 *
	 * @return void
	 */
	public function setAvatar(string $avatarUrl) : void{
		$this->data[WebhookTypes::AVATAR_URL] = $avatarUrl;
	}

	/**
	 * @return mixed|null
	 */
	public function getEmbeds() : mixed{
		return $this->data[WebhookTypes::EMBEDS] ?? null;
	}

	/**
	 * @param Embed $embed
	 *
	 * @return void
	 */
	public function addEmbed(Embed $embed) : void{
		if(!isset($this->data[WebhookTypes::EMBEDS])) {
			$this->data[WebhookTypes::EMBEDS] = [];
		}

		$this->data[WebhookTypes::EMBEDS][] = $embed->jsonSerialize();
	}

	/**
	 * @return string
	 */
	public function getUrl() : string{
		return  $this->url;
	}

	/**
	 * @param string $url
	 *
	 * @return void
	 */
	public function setUrl(string $url) : void{
		$this->url = $url;
	}

	/**
	 * @return int
	 */
	public function getId() : int{
		return $this->id;
	}

	public function send()
	{
		WebhookSenderTask::getInstance()->addWebhook($this);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() : array{
		return $this->data;
	}
}