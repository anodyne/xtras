<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Str,
	Hash,
	Model,
	Config;
use Zizaco\Entrust\HasRole;
use Illuminate\Auth\UserTrait,
	Illuminate\Auth\UserInterface,
	Illuminate\Auth\Reminders\RemindableTrait,
	Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserModel extends Model implements UserInterface, RemindableInterface {

	use HasRole;
	use UserTrait;
	use RemindableTrait;
	use PresentableTrait;
	use SoftDeletingTrait;

	protected $connection = 'anodyneUsers';

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
		return $this->hasMany('ItemModel', 'user_id');
	}

	public function orders()
	{
		return $this->hasMany('OrderModel', 'user_id');
	}

	public function notifications()
	{
		return $this->hasMany('NotificationModel', 'user_id');
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

	public function itemNotify(ItemModel $item)
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