<?php namespace Xtras\Interfaces;

interface ItemRepositoryInterface {

	public function find($value);

	public function getNewest($limit);

	public function getRecentlyUpdated($limit);

}