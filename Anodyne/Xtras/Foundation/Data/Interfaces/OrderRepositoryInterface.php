<?php namespace Xtras\Foundation\Data\Interfaces;

interface OrderRepositoryInterface {

	public function create(\User $user, \ItemFile $file);

}