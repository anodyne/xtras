<?php namespace Xtras\Models\Eloquent;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

	protected $connection = 'anodyneUsers';
	
	protected $table = 'roles';

}