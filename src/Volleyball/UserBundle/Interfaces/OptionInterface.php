<?php
namespace Volleyball\UserBundle\Interfaces;

interface OptionInterface
{
	public function getName();

	public function getValue();

	public function getType();

	public function isDefault();
}
