<?php namespace Xtras\Data\Interfaces;

use User;

interface TypeRepositoryInterface extends BaseRepositoryInterface {

	public function all($onlyActive = true);
	public function getByPermissions(User $user, $label = 'name', $value = 'id');
	public function listAll($label = 'name', $value = 'id');
	
}