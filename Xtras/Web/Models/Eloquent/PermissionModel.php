<?php namespace Xtras\Models\Eloquent;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	protected $connection = 'anodyneUsers';
	
	protected $table = 'permissions';

}