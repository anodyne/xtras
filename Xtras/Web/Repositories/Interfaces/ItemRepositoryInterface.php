<?php namespace Xtras\Repositories\Interfaces;

interface ItemRepositoryInterface extends BaseRepositoryInterface {

	public function findByAuthor($author);
	public function findByAuthorAndSlug($author, $name);
	public function findByName($name);
	public function findBySlug($slug);
	public function findByType($type);
	public function getItemTypes();
	public function getProducts();
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);
	public function search($input);
	public function searchAdvanced(array $input);

}