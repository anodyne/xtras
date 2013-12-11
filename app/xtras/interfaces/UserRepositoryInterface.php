<?php namespace Xtras\Interfaces;

interface UserRepositoryInterface {

	public function all();

	public function create(array $data);

	public function find($value);

	public function update($id, array $data);

}