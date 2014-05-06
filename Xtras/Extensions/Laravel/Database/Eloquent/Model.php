<?php namespace Xtras\Extensions\Laravel\Database\Eloquent;

use Date;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
	
	/*
	|--------------------------------------------------------------------------
	| Eloquent Model Method Overrides
	|--------------------------------------------------------------------------
	*/

	protected $dates = [];

	public function __construct(array $attributes = [])
	{
		$attributes = $this->scrubInputData($attributes);

		parent::__construct($attributes);
	}

	/**
	 * Get the attributes that should be converted to dates.
	 *
	 * @return array
	 */
	public function getDates()
	{
		return $this->dates;
	}

	/**
	 * Get a fresh timestamp for the model.
	 *
	 * We override this method from the Eloquent model so that we can ensure
	 * that every timestamp being generated is done so as UTC.
	 *
	 * @return mixed
	 */
	public function freshTimestamp()
	{
		return Date::now('UTC');
	}

	/**
	 * Return a timestamp as DateTime object.
	 *
	 * We override this method from the Eloquent model so that we can ensure
	 * that everything being stored in the database is being done so as UTC.
	 *
	 * @param	mixed	The value to store
	 * @return	Date
	 */
	protected function asDateTime($value)
	{
		if ( ! $value instanceof Date)
		{
			$format = $this->getDateFormat();

			return Date::createFromFormat($format, $value, 'UTC');
		}

		return $value;
	}

	/*
	|--------------------------------------------------------------------------
	| Model Helpers
	|--------------------------------------------------------------------------
	*/

	/**
	 * Scrub the data being used to make sure we're can store it in the table.
	 *
	 * @param	array	Array of data to scrub
	 * @return	array
	 */
	protected function scrubInputData(array $data)
	{
		// Loop through the data and scrub it for any issues
		foreach ($data as $key => $value)
		{
			// Make sure we're only using fillable fields
			if ( ! $this->isFillable($key))
			{
				unset($data[$key]);
			}
		}

		return $data;
	}

	/*
	|--------------------------------------------------------------------------
	| Model Scopes
	|--------------------------------------------------------------------------
	*/

	/**
	 * Ascending order scope.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field to order by
	 * @return	void
	 */
	public function scopeOrderAsc($query, $orderBy)
	{
		$this->orderScope($query, $orderBy, 'asc');
	}

	/**
	 * Descending order scope.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field to order by
	 * @return	void
	 */
	public function scopeOrderDesc($query, $orderBy)
	{
		$this->orderScope($query, $orderBy, 'desc');
	}

	/**
	 * Do the ordering.
	 *
	 * @param	Builder		Query Builder object
	 * @param	mixed		A string or array of strings of columns
	 * @param	string		The direction to order
	 * @return	void
	 */
	protected function orderScope($query, $column, $direction)
	{
		if (is_array($column))
		{
			foreach ($column as $col)
			{
				$query->orderBy($col, $direction);
			}
		}
		else
		{
			$query->orderBy($column, $direction);
		}
	}

	/**
	 * Grouping scope.
	 *
	 * @param	Builder		The query builder
	 * @param	string		The field to group by
	 * @return	void
	 */
	public function scopeGroup($query, $groupBy)
	{
		$query->groupBy($groupBy);
	}

}