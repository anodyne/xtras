<?php namespace Xtras\Data\Interfaces;

interface BaseRepositoryInterface {
	
	public function all();
	public function create(array $data);
	public function delete($id);
	public function find($id);
	public function update($id, array $data);

}