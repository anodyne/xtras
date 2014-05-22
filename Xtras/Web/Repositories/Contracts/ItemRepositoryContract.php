<?php namespace Xtras\Repositories\Contracts;

interface ItemRepositoryContract extends BaseRepositoryContract {

	public function findByName($name);
	public function getItemTypes();
	public function getProducts();
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);

}