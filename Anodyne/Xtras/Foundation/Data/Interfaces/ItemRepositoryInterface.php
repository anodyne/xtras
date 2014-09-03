<?php namespace Xtras\Foundation\Data\Interfaces;

use UserModel;

interface ItemRepositoryInterface extends BaseRepositoryInterface {

	public function addComment($id, array $data);
	public function addMessage($itemId, array $data);
	public function deleteFile($id);
	public function deleteImage($itemId, $imageNumber);
	public function deleteMessage($id);
	public function findByAuthor($author);
	public function findByAuthorAndSlug($author, $name);
	public function findByName($name);
	public function findBySlug($slug);
	public function findByType($type, $paginate = false, $splitByProduct = false);
	public function findComment($id);
	public function findFile($id);
	public function findMessage($id);
	public function getByPage($type, $page = 1, $limit = 15, $order = 'created_at', $direction = 'desc');
	public function getComments($id);
	public function getMessage($id);
	public function getProducts();
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);
	public function getTypes();
	public function getTypesByPermissions(UserModel $user);
	public function rate(UserModel $user, $itemId, $rating);
	public function search($input);
	public function searchAdvanced(array $input);
	public function updateFileData($id, array $data);
	public function updateMessage($id, array $data);
	public function updateMetaData($id, array $data);

}