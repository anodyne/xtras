<?php namespace Xtras\Foundation\Data\Models;

use Config;
use Zizaco\Entrust\HasRole;
use Illuminate\Auth\UserTrait,
	Illuminate\Auth\UserInterface;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends \Model implements UserInterface {

	use HasRole;
	use UserTrait;
	use PresentableTrait;
	use SoftDeletingTrait;

	protected $connection = 'users';

	protected $table = 'users';

	protected $fillable = ['remember_token'];

	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\UserPresenter';

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	public function items()
	{
		return $this->hasMany('Item');
	}

	public function orders()
	{
		return $this->hasMany('Order');
	}

	public function notifications()
	{
		return $this->hasMany('Notification');
	}

	public function roles()
	{
		return $this->belongsToMany(
			Config::get('entrust::role'),
			Config::get('entrust::assigned_roles_table'),
			'user_id',
			'role_id'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeUsername($query, $username)
	{
		$query->where('username', $username);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	public function daysSinceRegistration()
	{
		return (int) \Date::now()->diffInDays($this->created_at);
	}

	public function itemNotify(Item $item)
	{
		$notification = $this->notifications->filter(function($n) use ($item)
		{
			return (int) $n->item_id === (int) $item->id;
		})->first();

		if ($notification)
		{
			return true;
		}

		return false;
	}

}