<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Str,
	Model,
	Collection;
use Laracasts\Presenter\PresentableTrait;
use Dingo\Api\Transformer\TransformableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemModel extends Model implements TransformableInterface {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'slug',
		'desc', 'support', 'version', 'rating', 'status'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemPresenter';

	/*
	|---------------------------------------------------------------------------
	| Validation
	|---------------------------------------------------------------------------
	*/

	/*public static $rules = [
		'type_id'		=> 'required|integer',
		'product_id'	=> 'required|integer',
		'name'			=> 'required',
	];

	public static $customMessages = [
		'type_id.required' => "You must enter a type",
		'type_id.integer' => "You have entered an invalid value for the type. Please select the type from the dropdown.",
		'product_id.required' => "You must enter a product",
		'product_id.integer' => "You have entered an invalid value for the product. Please select the product from the dropdown.",
		'name.required' => "You must enter a name",
	];*/

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function product()
	{
		return $this->belongsTo('ProductModel');
	}

	public function type()
	{
		return $this->belongsTo('TypeModel');
	}

	public function user()
	{
		return $this->belongsTo('UserModel');
	}

	public function messages()
	{
		return $this->hasMany('ItemMessageModel', 'item_id');
	}

	public function meta()
	{
		return $this->hasOne('ItemMetaModel', 'item_id');
	}

	public function comments()
	{
		return $this->hasMany('CommentModel', 'item_id');
	}

	public function orders()
	{
		return $this->hasMany('OrderModel', 'item_id');
	}

	public function files()
	{
		return $this->hasMany('ItemFileModel', 'item_id')
			->orderBy('created_at', 'desc');
	}

	public function ratings()
	{
		return $this->hasMany('ItemRatingModel', 'item_id');
	}

	public function notifications()
	{
		return $this->hasMany('NotificationModel', 'item_id');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Accessors/Mutators
	|---------------------------------------------------------------------------
	*/

	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = ( ! empty($value)) 
			? $value 
			: Str::slug(Str::lower($this->attributes['name']));
	}

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeActive($query)
	{
		$query->where('status', (int) true);
	}

	public function scopeItemType($query, $typeId)
	{
		$query->where('type_id', (int) $typeId);
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function isActive()
	{
		return ( ! empty($this->meta->toArray()['file']));
	}

	public function isOwner(UserModel $user)
	{
		return (int) $this->user_id === (int) $user->id;
	}

	public function getLatestVersion()
	{
		return $this->getVersion($this->version);
	}

	public function getVersion($version)
	{
		// Get the appropriate files item
		$file = $this->files->filter(function($f) use ($version)
		{
			return $f->version == $version;
		})->first();

		// Start building a new collection
		$collection = $this->newCollection();

		// Put the meta record in
		$collection->put('meta', $this->meta);
		$collection->put('files', $file);

		return $collection;
	}

	public function updateRating()
	{
		$total = 0;

		foreach ($this->ratings as $rating)
		{
			$total += $rating->rating;
		}

		$final = ($total > 0)
			? $this->fill(['rating' => (float) $total / $this->ratings->count()])->save()
			: (float) 0;

		return true;
	}

	public function getTransformer()
	{
		return new \Xtras\Api\Transformers\ItemTransformer;
	}

}