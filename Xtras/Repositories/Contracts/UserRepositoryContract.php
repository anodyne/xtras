<?php namespace Xtras\Repositories\Contracts;

interface UserRepositoryContract extends BaseRepositoryContract {

	public function findBySlug($slug);

}