<?php namespace Xtras\Data\Interfaces;

use User;

interface ItemRepositoryInterface extends BaseRepositoryInterface {

	public function addComment($itemId, array $data);
	public function addMessage($itemId, array $data);
	public function deleteFile($fileId);
	public function deleteImage($itemId, $imageNum);
	public function deleteMessage($msgId);
	public function findByAuthor($author);
	public function findByAuthorAndSlug($author, $name);
	public function findByName($name);
	public function findBySlug($slug);
	public function findByType($type, $paginate = false, $split = false);
	public function findComment($commentId);
	public function findFile($fileId);
	public function findMessage($msgId);
	public function getByPage($type, $page = 1, $limit = 15, $order = 'created_at', $direction = 'desc');
	public function getComments($itemId);
	public function getMessage($msgId);
	public function getRecentlyAdded($number);
	public function getRecentlyUpdated($number);
	public function rate(User $user, $itemId, $value);
	public function reportSizes();
	public function search($input);
	public function searchAdvanced(array $input);
	public function updateFileData($itemId, array $data);
	public function updateMessage($msgId, array $data);
	public function updateMetadata($itemId, array $data);

}