<?php namespace Xtras\Repositories\Interfaces;

interface BaseRepositoryInterface {
	
	public function all();
	public function create(array $data = [], $flashMessage = true);
	public function delete($id, $flashMessage = true);
	public function find($id);
	public function update($id, array $data = [], $flashMessage = true);

}