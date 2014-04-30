<?php namespace Xtras\Repositories\Contracts;

interface ItemRepositoryContract extends BaseRepositoryContract {

	public function findBySlug($slug);
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);

}