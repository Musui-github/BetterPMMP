<?php

namespace pocketmine\world\gamerule;

use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use pocketmine\network\mcpe\protocol\types\IntGameRule;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\World;

class GameruleManager
{
	/**
	 * @param World       $world
	 * @param CompoundTag $tag
	 */
	public function __construct(
		protected World $world,
		protected CompoundTag $tag
	) {
		$this->tag->setByte(GameruleIds::DO_DAYLIGHT_CYCLE, $this->tag->getByte(GameruleIds::DO_DAYLIGHT_CYCLE, intval(true)));
		$this->tag->setByte(GameruleIds::NATURAL_REGENERATION, $this->tag->getByte(GameruleIds::NATURAL_REGENERATION, intval(true)));
		$this->tag->setByte(GameruleIds::MOB_GRIEFING, $this->tag->getByte(GameruleIds::MOB_GRIEFING, intval(true)));
		$this->tag->setByte(GameruleIds::DO_WEATHER_CYCLE, $this->tag->getByte(GameruleIds::DO_WEATHER_CYCLE, intval(true)));
		$this->tag->setByte(GameruleIds::KEEP_INVENTORY, $this->tag->getByte(GameruleIds::KEEP_INVENTORY, intval(false)));
		$this->tag->setByte(GameruleIds::TNT_EXPLODES, $this->tag->getByte(GameruleIds::TNT_EXPLODES, intval(true)));
		$this->tag->setByte(GameruleIds::COMMAND_BLOCK_OUTPUT, $this->tag->getByte(GameruleIds::COMMAND_BLOCK_OUTPUT, intval(false)));
		$this->tag->setByte(GameruleIds::DO_INSOMNIA, $this->tag->getByte(GameruleIds::DO_INSOMNIA, intval(false)));
		$this->tag->setInt(GameruleIds::MAX_ENTITY_CRAMMING, $this->tag->getInt(GameruleIds::MAX_ENTITY_CRAMMING, 24));
		$this->tag->setInt(GameruleIds::RANDOM_TICK_SPEED, $this->tag->getInt(GameruleIds::RANDOM_TICK_SPEED, 20));
		$this->tag->setInt(GameruleIds::SPAWN_RADIUS, $this->tag->getInt(GameruleIds::SPAWN_RADIUS, 5));
	}

	/**
	 * @param string $id
	 *
	 * @return int|null
	 */
	public function getGamerule(string $id) : ?int{
		return $this->tag->getByte($id) ?? null;
	}

	/**
	 * @param string   $id
	 * @param bool|int $value
	 *
	 * @return void
	 */
	public function setGamerule(string $id, bool|int $value) : void{
		if(is_bool($value)) {
			$this->getData()->setByte($id, intval($value));
		} else $this->getData()->setInt($id, $value);
		$this->syncAllGamerules();
	}

	/**
	 * @param Player $player
	 *
	 * @return void
	 */
	public function syncGamerules(Player $player) : void{
		$gamerules = [];
		foreach($this->getData()->getValue() as $id => $value) {
			if($value instanceof ByteTag) {
				$gamerules[strtolower($id)] = new BoolGameRule(boolval($value->getValue()), true);
			} else if($value instanceof IntTag) {
				$gamerules[strtolower($id)] = new IntGameRule($value->getValue(), true);
			}
		}

		$pk = GameRulesChangedPacket::create($gamerules);
		$player->getNetworkSession()->sendDataPacket($pk);
	}

	/**
	 * @return void
	 */
	public function syncAllGamerules() : void{
		foreach($this->world->getPlayers() as $player) {
			$this->syncGamerules($player);
		}
	}

	/**
	 * @return CompoundTag
	 */
	public function getData() : CompoundTag{
		return $this->tag;
	}
}