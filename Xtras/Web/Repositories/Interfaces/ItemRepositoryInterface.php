<?php namespace Xtras\Repositories\Interfaces;

interface ItemRepositoryInterface extends BaseRepositoryInterface {

	public function findByName($name);
	public function getItemTypes();
	public function getProducts();
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);

}