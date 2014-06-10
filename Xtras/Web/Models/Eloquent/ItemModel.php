<?php namespace Xtras\Models\Eloquent;

use Str, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ItemModel extends Model {

	use PresentableTrait;
	use SoftDeletingTrait;

	protected $table = 'items';

	protected $fillable = ['user_id', 'type_id', 'product_id', 'name', 'slug',
		'desc', 'support'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Xtras\Presenters\ItemPresenter';

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
		'meta'		=> [self::HAS_MANY, 'ItemMetaModel', 'foreignKey' => 'item_id'],
		'ratings'	=> [self::HAS_MANY, 'ItemRatingModel', 'foreignKey' => 'item_id'],
		'comments'	=> [self::HAS_MANY, 'CommentModel', 'foreignKey' => 'item_id'],
		'orders'	=> [self::HAS_MANY, 'OrderModel', 'foreignKey' => 'item_id'],
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
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function isActive()
	{
		return ( ! empty($this->meta->toArray()['file']));
	}

}