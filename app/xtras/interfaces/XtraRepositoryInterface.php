<?php namespace Xtras\Interfaces;

interface XtraRepositoryInterface {

	public function find($value);

	public function getNewest($limit);

	public function getRecentlyUpdated($limit);

}