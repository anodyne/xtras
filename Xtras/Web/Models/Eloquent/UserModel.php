<?php namespace Xtras\Models\Eloquent;

use Str,
	Hash,
	Model;
use Illuminate\Auth\UserInterface,
	Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserModel extends Model implements UserInterface, RemindableInterface {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $connection = 'anodyneUsers';
	
	protected $table = 'users';

	protected $fillable = ['name', 'email', 'password', 'url', 'bio', 'slug',
		'remember_token'];

	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\UserPresenter';

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

	/*
	|--------------------------------------------------------------------------
	| Model Accessors and Mutators
	|--------------------------------------------------------------------------
	*/

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = (Str::length($value) < 60) 
			? Hash::make($value)
			: $value;
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	public function scopeSlug($query, $slug)
	{
		$query->where('slug', $slug);
	}

	/*
	|--------------------------------------------------------------------------
	| Model Boot
	|--------------------------------------------------------------------------
	*/

	public static function boot()
	{
		parent::boot();

		/**
		 * When the user is being saved, convert their name into the profile
		 * slug and drop everything to lowercase.
		 */
		static::saving(function($user)
		{
			$user->slug = Str::lower(Str::slug($user->name));
		});
	}

	/*
	|--------------------------------------------------------------------------
	| UserInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/*
	|--------------------------------------------------------------------------
	| RemindableInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}