<?php namespace Xtras\Data\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface {

	public function all($onlyActive = true);
	public function listAll($label = 'name', $value = 'id');
	
}