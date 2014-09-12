<?php namespace Xtras\Data\Interfaces;

interface OrderRepositoryInterface {

	public function create(\User $user, \ItemFile $file);

}