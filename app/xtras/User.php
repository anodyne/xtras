<?php namespace Xtras;

use Str;
use Hash;
use Model;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Model implements UserInterface, RemindableInterface {

	protected $connection = 'anodyneUsers';
	
	protected $table = 'users';

	protected $fillable = array('name', 'email', 'password', 'url', 'bio', 'slug');

	protected $hidden = array('password');

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	public function orders()
	{
		//$this->hasMany('Order');
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