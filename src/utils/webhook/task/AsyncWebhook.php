<?php

namespace pocketmine\utils\webhook\task;

use CurlHandle;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\thread\NonThreadSafeValue;
use pocketmine\utils\webhook\exeption\CurlException;
use pocketmine\utils\webhook\exeption\InvalidWebhookException;
use pocketmine\utils\webhook\Webhook;

class AsyncWebhook extends AsyncTask
{
	public function __construct(
		protected NonThreadSafeValue $value
	) {}

	public function onRun() : void
	{
		$deserialize = $this->value->deserialize();
		$handle = curl_init($deserialize->getUrl());
		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($deserialize->jsonSerialize()));
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
		curl_exec($handle);
		$this->setResult($handle);
	}

	public function onCompletion() : void
	{
		$webhook = $this->value->deserialize();;
		$result = $this->getResult();

		if(!$webhook instanceof Webhook) {
			throw new InvalidWebhookException("Invalid webhook in NonThreadSafeValue");
		}

		if(!$result instanceof CurlHandle) {
			throw new CurlException("Invalid curl result");
		}

		if(!curl_errno($result)) {
			WebhookSenderTask::getInstance()->removeWebhook($webhook->getId());
		} else Server::getInstance()->getLogger()->debug(curl_error($result));

		curl_close($result);
	}
}