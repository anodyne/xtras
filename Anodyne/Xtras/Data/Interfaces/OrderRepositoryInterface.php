<?php namespace Xtras\Data\Interfaces;

use User, ItemFile;

interface OrderRepositoryInterface {

	public function create(User $user, ItemFile $file);

}