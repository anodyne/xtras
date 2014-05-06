<?php namespace Xtras\Repositories\Contracts;

interface ItemRepositoryContract extends BaseRepositoryContract {

	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);

}