<?php namespace Xtras\Models\Eloquent;

use Zizaco\Entrust\EntrustRole;

class RoleModel extends EntrustRole {

	protected $connection = 'anodyneUsers';
	
	protected $table = 'roles';

	protected $fillable = ['name'];

}