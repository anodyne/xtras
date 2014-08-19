<?php namespace Xtras\Foundation\Data\Models\Eloquent;

use Str, Model, Collection;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'slug',
		'desc', 'support', 'version'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Foundation\Data\Presenters\ItemPresenter';

	/*
	|---------------------------------------------------------------------------
	| Validation
	|---------------------------------------------------------------------------
	*/

	public static $rules = [
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
	];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public static $relationsData = [
		'product'	=> [self::BELONGS_TO, 'ProductModel'],
		'type'		=> [self::BELONGS_TO, 'TypeModel'],
		'user'		=> [self::BELONGS_TO, 'UserModel'],
		'messages'	=> [self::HAS_MANY, 'ItemMessageModel', 'foreignKey' => 'item_id'],
		'meta'		=> [self::HAS_ONE, 'ItemMetaModel', 'foreignKey' => 'item_id'],
		'ratings'	=> [self::HAS_MANY, 'ItemRatingModel', 'foreignKey' => 'item_id'],
		'comments'	=> [self::HAS_MANY, 'CommentModel', 'foreignKey' => 'item_id'],
		'orders'	=> [self::HAS_MANY, 'OrderModel', 'foreignKey' => 'item_id'],
		'files'		=> [self::HAS_MANY, 'ItemFileModel', 'foreignKey' => 'item_id'],
	];

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

}