<?php namespace Xtras\Services;

class SanitizerService {

	public function email($input)
	{
		return $this->sanitize(strip_tags($input), FILTER_SANITIZE_EMAIL);
	}

	public function float($input)
	{
		return $this->sanitize($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_SCIENTIFIC);
	}

	public function integer($input)
	{
		return $this->sanitize($input, FILTER_SANITIZE_NUMBER_INT);
	}

	public function string($input)
	{
		return $this->sanitize(strip_tags($input), FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
		//return $this->sanitize($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_ENCODE_AMP);
	}

	public function url($input)
	{
		return $this->sanitize(strip_tags($input), FILTER_SANITIZE_URL);
	}

	protected function sanitize($input, $filter, $options = '')
	{
		if (is_array($input))
		{
			$arr = [];

			foreach ($input as $key => $value)
			{
				$arr[$key] = filter_var(trim($value), $filter, $options);
			}
		}

		return filter_var(trim($input), $filter, $options);
	}

}