<?php namespace Xtras\Data\Models;

use Str, Sanitize;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Item extends \Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'slug',
		'desc', 'support', 'version', 'rating', 'status'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function product()
	{
		return $this->belongsTo('Product');
	}

	public function type()
	{
		return $this->belongsTo('Type');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function messages()
	{
		return $this->hasMany('ItemMessage');
	}

	public function metadata()
	{
		return $this->hasOne('ItemMetadata');
	}

	public function comments()
	{
		return $this->hasMany('Comment');
	}

	public function orders()
	{
		return $this->hasMany('Order');
	}

	public function files()
	{
		return $this->hasMany('ItemFile')->orderBy('created_at', 'desc');
	}

	public function ratings()
	{
		return $this->hasMany('ItemRating');
	}

	public function notifications()
	{
		return $this->hasMany('Notification');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Accessors/Mutators
	|---------------------------------------------------------------------------
	*/

	public function setDescAttribute($value)
	{
		$this->attributes['desc'] = Sanitize::string($value);
	}

	public function setNameAttribute($value)
	{
		$this->attributes['name'] = Sanitize::string($value);
	}

	public function setProductIdAttribute($value)
	{
		$this->attributes['product_id'] = Sanitize::integer($value);
	}

	public function setRatingAttribute($value)
	{
		$this->attributes['rating'] = Sanitize::float($value);
	}

	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = ( ! empty($value)) 
			? Sanitize::string($value)
			: Str::slug(Str::lower($this->attributes['name']));
	}

	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = Sanitize::integer($value);
	}

	public function setSupportAttribute($value)
	{
		$this->attributes['support'] = (filter_var($value, FILTER_VALIDATE_EMAIL))
			? Sanitize::email($value)
			: Sanitize::url($value);
	}

	public function setTypeIdAttribute($value)
	{
		$this->attributes['type_id'] = Sanitize::integer($value);
	}

	public function setUserIdAttribute($value)
	{
		$this->attributes['user_id'] = Sanitize::integer($value);
	}

	public function setVersionAttribute($value)
	{
		$this->attributes['version'] = Sanitize::string($value);
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
		return ( ! empty($this->metadata->toArray()['file']));
	}

	public function isOwner(User $user)
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
		$collection->put('metadata', $this->metadata);
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

}