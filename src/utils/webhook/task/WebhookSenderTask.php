<?php

namespace pocketmine\utils\webhook\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\thread\NonThreadSafeValue;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\webhook\exeption\InvalidWebhookException;
use pocketmine\utils\webhook\Webhook;

class WebhookSenderTask extends Task
{
	use SingletonTrait;
	private static int $nextID = 0;

	public static function nextId() : int{
		return self::$nextID++;
	}

	/**
	 * @var Webhook[]
	 */
	protected array $webhooks = array();

	public function __construct()
	{
		Server::getInstance()->getScheduler()->scheduleRepeatingTask($this, 30);
	}

	/**
	 * @param Webhook $webhook
	 *
	 * @return void
	 */
	public function addWebhook(Webhook $webhook) : void{
		$this->webhooks[$webhook->getId()] = $webhook;
	}

	/**
	 * @param int $id
	 *
	 * @return void
	 */
	public function removeWebhook(int $id) : void{
		if(!isset($this->webhooks[$id])) {
			throw new InvalidWebhookException("Invalid webhook {$id}");
		}

		unset($this->webhooks[$id]);
	}

	public function onRun() : void{
		if(count($this->webhooks) <= 0) {
			return;
		}

		$webhook = reset($this->webhooks);
		$id = key($this->webhooks);

		if(!$webhook instanceof Webhook) {
			throw new InvalidWebhookException("Invalid webhook {$id}");
		}

		Server::getInstance()->getAsyncPool()->submitTask(new AsyncWebhook(new NonThreadSafeValue($webhook)));
	}
}