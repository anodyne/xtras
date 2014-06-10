<?php namespace Xtras\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function findBySlug($slug);

}