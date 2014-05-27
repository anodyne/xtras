<?php namespace Xtras\Traits;

use Session;

trait UtilityTrait {

	public function setFlashMessage($status, $message)
	{
		Session::flash('flashStatus', $status);
		Session::flash('flashMessage', $message);
	}

}