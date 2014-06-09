<?php namespace Xtras\Models\Eloquent;

use Str,
	Hash,
	Model;
use Illuminate\Auth\UserTrait,
	Illuminate\Auth\UserInterface,
	Illuminate\Auth\Reminders\RemindableTrait,
	Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserModel extends Model implements UserInterface, RemindableInterface {

	use UserTrait;
	use RemindableTrait;
	use PresentableTrait;
	use SoftDeletingTrait;

	protected $connection = 'anodyneUsers';
	
	protected $table = 'users';

	protected $fillable = ['name', 'email', 'password', 'url', 'bio', 'slug',
		'remember_token'];

	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\UserPresenter';

	// Hash the password automatically
	public static $passwordAttributes  = ['password'];
	public $autoHashPasswordAttributes = true;

	/*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'items'		=> [self::HAS_MANY, 'ItemModel', 'foreignKey' => 'user_id'],
		'orders'	=> [self::HAS_MANY, 'OrderModel', 'foreignKey' => 'user_id'],
	];

	/*
	|---------------------------------------------------------------------------
	| Model Hooks
	|---------------------------------------------------------------------------
	*/

	public function beforeSave()
	{
		// If the name has changed, update the slug
		if ($this->isDirty('name'))
		{
			$this->slug = Str::slug(Str::lower($this->name));
		}
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
	| Model Methods
	|--------------------------------------------------------------------------
	*/

	public function access()
	{
		return 1;
	}

}