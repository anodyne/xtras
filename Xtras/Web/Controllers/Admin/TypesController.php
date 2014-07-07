<?php namespace Xtras\Controllers\Admin;

use View,
	Event,
	Input,
	Redirect,
	TypeRepositoryInterface;
use Xtras\Controllers\BaseController;

class TypesController extends BaseController {

	protected $types;

	public function __construct(TypeRepositoryInterface $types)
	{
		parent::__construct();

		$this->types = $types;

		// Before filter to check if the user has permissions
		$this->beforeFilter('@checkPermissions');
	}

	public function index()
	{
		return View::make('pages.admin.types.index')
			->withTypes($this->types->all());
	}

	public function create()
	{
		return partial('modal_content', [
			'modalHeader'	=> "Create Item Type",
			'modalBody'		=> View::make('pages.admin.types.create'),
			'modalFooter'	=> false,
		]);
	}

	public function store()
	{
		// Create the product
		$type = $this->types->create(Input::all());

		// Fire the event
		Event::fire('type.created', [$type]);

		return Redirect::route('admin.types.index');
	}

	public function edit($id)
	{
		// Get the product
		$type = $this->types->find($id);

		return partial('modal_content', [
			'modalHeader'	=> "Edit Item Type",
			'modalBody'		=> View::make('pages.admin.types.edit')->withType($type),
			'modalFooter'	=> false,
		]);
	}

	public function update($id)
	{
		// Update the product
		$type = $this->types->update($id, Input::all());

		// Fire the event
		Event::fire('type.updated', [$type]);

		return Redirect::route('admin.types.index');
	}

	public function remove($id)
	{
		// Get the product
		$type = $this->types->find($id);

		return partial('modal_content', [
			'modalHeader'	=> "Delete Item Type",
			'modalBody'		=> View::make('pages.admin.types.remove')->withType($type),
			'modalFooter'	=> false,
		]);
	}

	public function destroy($id)
	{
		// Remove the product
		$type = $this->types->delete($id);

		// Fire the event
		Event::fire('type.deleted', [$type]);

		return Redirect::route('admin.types.index');
	}

	public function checkPermissions()
	{
		if ( ! $this->currentUser->can('xtras.admin'))
		{
			return $this->errorUnauthorized("You do not have permissions to manage item types.");
		}
	}

}