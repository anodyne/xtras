<?php namespace Xtras;

use Model;

class Product extends Model {

	protected $table = 'products';

	protected $fillable = array('name');

}