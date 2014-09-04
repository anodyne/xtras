<?php namespace Xtras\Controllers\Items;

use View,
	Event,
	Flash,
	Input,
	Redirect,
	ItemUpdateValidator,
	ItemCreationValidator,
	ItemRepositoryInterface,
	UserRepositoryInterface,
	OrderRepositoryInterface;

class AdminController extends \BaseController {

	protected $items;
	protected $users;
	protected $itemCreate;
	protected $itemUpdate;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users, ItemCreationValidator $itemCreate,
			ItemUpdateValidator $itemUpdate)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
		$this->itemCreate = $itemCreate;
		$this->itemUpdate = $itemUpdate;
	}

	public function index()
	{
		if ($this->currentUser->can('xtras.admin'))
		{
			// Find all the skins
			$data = $this->items->getByPage(false, Input::get('page', 1), 25, 'name', 'asc');

			// Build the paginator
			$paginator = \Paginator::make($data->items, $data->totalItems, 25);

			return View::make('pages.item.admin')->withItems($paginator);
		}

		return $this->unauthorized("You do not have permissions to manage Xtras!");
	}

	public function create()
	{
		if ($this->currentUser->can('xtras.item.create') or $this->currentUser->can('xtras.admin'))
		{
			$products[''] = "Choose a product";
			$products += $this->items->getProducts();

			$types[''] = "Choose a type";
			$types += $this->items->getTypesByPermissions($this->currentUser);

			return View::make('pages.item.create')->with(compact('products', 'types'));
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function store()
	{
		if ($this->currentUser->can('xtras.item.create') or $this->currentUser->can('xtras.admin'))
		{
			// Validate the form
			$this->itemCreate->validate(Input::all());

			// Create the item
			$item = $this->items->create(Input::all());

			// Fire the item creation event
			Event::fire('item.created', [$item]);

			// Set the flash message
			Flash::success("Xtra was successfully created. Use the page below to upload your Xtra's zip file.");

			return Redirect::route('files.create', [$item->user->username, $item->slug]);
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function edit($author, $slug, $admin = false)
	{
		if ($this->currentUser->can('xtras.item.edit') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$item = $this->items->findByAuthorAndSlug($author, $slug);

			if ($item)
			{
				if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
				{
					return View::make('pages.item.edit')
						->withItem($item)
						->withMeta($item->meta)
						->withAdmin($admin);
				}

				return $this->errorUnauthorized("You do not have permissions to edit Xtras other than your own!");
			}

			return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
		}

		return $this->errorUnauthorized("You do not have permission to edit Xtras.");
	}

	public function update($author, $slug, $admin = false)
	{
		if ($this->currentUser->can('xtras.item.edit') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$xtra = $this->items->findByAuthorAndSlug($author, $slug);
			
			if ($xtra->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				// Validate the form
				$this->itemUpdate->validate(Input::all());
				
				// Update the item
				$item = $this->items->update($xtra->id, Input::all());

				// Fire the item update event
				Event::fire('item.updated', [$item->id]);

				if ( ! $admin)
				{
					// Set the flash message
					Flash::success("Your Xtra was successfully updated. If you're releasing a new version of this Xtra, make sure you upload the new zip file.");

					return Redirect::route('account.xtras');
				}

				// Set the flash message
				Flash::success("Xtra was successfully updated.");

				return Redirect::route('item.admin');
			}

			return $this->errorUnauthorized("You do not have permissions to edit Xtras other than your own!");
		}

		return $this->errorUnauthorized("You do not have permission to edit Xtras.");
	}

	public function remove($itemId, $admin = false)
	{
		if ($this->currentUser->can('xtras.item.delete') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$item = $this->items->find($itemId);

			return partial('modal_content', [
				'modalHeader'	=> "Remove Xtra",
				'modalBody'		=> View::make('pages.item.remove')->with(compact('item', 'admin')),
				'modalFooter'	=> false,
			]);
		}

		return partial('modal_content', [
			'modalHeader'	=> "Remove Xtra",
			'modalBody'		=> alert('danger', "You do not have the permissions to remove this Xtra!"),
			'modalFooter'	=> false,
		]);
	}

	public function destroy($itemId, $admin = false)
	{
		if ($this->currentUser->can('xtras.item.delete') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item we're trying to delete
			$xtra = $this->items->find($itemId);

			if ($xtra)
			{
				if ($xtra->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
				{
					// Remove the item
					$item = $this->items->delete($itemId);

					// Fire the event
					Event::fire('item.deleted', [$item]);

					// Set the flash message
					Flash::success("Xtra has been successfully removed.");

					if ($admin and $this->currentUser->can('xtras.admin'))
					{
						return Redirect::route('item.admin');
					}

					return Redirect::route('account.xtras');
				}

				return $this->errorUnauthorized("You do not have permissions to remove Xtras that are not your own!");
			}

			return $this->errorNotFound("We could not find the Xtra you were looking for.");
		}

		return $this->errorUnauthorized("You do not have permissions to remove Xtras!");
	}

	public function ajaxCheckName($name)
	{
		// Try to find any items
		$items = $this->users->findItemsByName($this->currentUser, $name);

		// If we already have something, no dice...
		if ($items->count() > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}