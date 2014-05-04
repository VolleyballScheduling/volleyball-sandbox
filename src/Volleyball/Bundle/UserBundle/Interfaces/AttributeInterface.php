<?php
namespace Volleyball\Bundle\User\Interfaces;

interface AttributeInterface
{
	public function getName();

	public function getGroups();

	public function getDescription();

	public function getOptions();

	public function isRequired();
}