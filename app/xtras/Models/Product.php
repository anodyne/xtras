<?php namespace Xtras\Models;

use Model;

class Product extends Model {

	protected $table = 'products';

	protected $fillable = array('name');

}