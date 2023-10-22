<?php

namespace pocketmine\command\arguments;

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;

abstract class CommandArgument {

	/**
	 * @var CommandParameter
	 */
	protected CommandParameter $commandParameter;

	/**
	 * @var string
	 */
	private string $name;
	/**
	 * @var bool
	 */
	private bool $optional;

	/**
	 * @param string $name
	 * @param bool   $optional
	 */
	public function __construct(string $name, bool $optional = false) {
		$this->name = $name;
		$this->optional = $optional;

		$this->commandParameter = new CommandParameter();
		$this->commandParameter->paramName = $name;
		$this->commandParameter->paramType = AvailableCommandsPacket::ARG_FLAG_VALID; $this->commandParameter->paramType |= $this->getNetworkType();
		$this->commandParameter->isOptional = $this->isOptional();
	}

	/**
	 * @return int
	 */
	abstract public function getNetworkType(): int;

	/**
	 * @return string
	 */
	abstract public function getTypeName(): string;

	/**
	 * @param string        $testString
	 * @param CommandSender $sender
	 *
	 * @return bool
	 */
	abstract public function canParse(string $testString, CommandSender $sender): bool;

	/**
	 * @param string        $argument
	 * @param CommandSender $sender
	 *
	 * @return mixed
	 */
	abstract public function parse(string $argument, CommandSender $sender): mixed;

	/**
	 * @return string
	 */
	public function getName() : string{
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function isOptional() : bool{
		return $this->optional;
	}

	/**
	 * @return CommandParameter
	 */
	public function getCommandParameter() : CommandParameter{
		return $this->commandParameter;
	}
}