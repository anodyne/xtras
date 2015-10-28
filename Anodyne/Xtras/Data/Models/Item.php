<?php namespace Xtras\Data\Models;

use Str,
	Model,
	SoftDeletingTrait;
use Laracasts\Presenter\PresentableTrait;

class Item extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'slug',
		'desc', 'support', 'version', 'rating', 'status', 'admin_status',
		'award_creativity', 'award_presentation', 'award_technical'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Data\Presenters\ItemPresenter';

	public static $sanitizeRules = [
		'user_id'				=> 'integer',
		'type_id'				=> 'integer',
		'product_id'			=> 'integer',
		'name'					=> 'string',
		'slug'					=> 'string',
		'desc'					=> 'string',
		'support'				=> 'string',
		'version'				=> 'string',
		'rating'				=> 'float',
		'status'				=> 'integer',
		'admin_status'			=> 'integer',
		'award_creativity'		=> 'integer',
		'award_presentation'	=> 'integer',
		'award_technical'		=> 'integer',
	];

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
		$query->where('status', (int) true)
			->where('admin_status', (int) true);
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

	/**
	 * Is the item active? We base this on whether or not it has any files
	 * attached to it.
	 *
	 * @return	bool
	 */
	public function isActive()
	{
		return ( ! empty($this->metadata->toArray()['file']));
	}

	/**
	 * Is the passed user the owner of the item?
	 *
	 * @param	User	$user	The user to check against
	 * @return	bool
	 */
	public function isOwner(User $user)
	{
		return (int) $this->user_id === (int) $user->id;
	}

	/**
	 * Get the latest version of the item.
	 *
	 * @return	Collection
	 */
	public function getLatestVersion()
	{
		return $this->getVersion($this->version);
	}

	/**
	 * Get a collection of information about the current version.
	 *
	 * @param	mixed	$version	The version to retrieve
	 * @return	Collection
	 */
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

	/**
	 * Is the support field an email address?
	 *
	 * @return	bool
	 */
	public function supportIsEmail()
	{
		if (filter_var($this->support, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}

		return false;
	}

	/**
	 * Update the item's rating.
	 *
	 * @return	bool
	 */
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