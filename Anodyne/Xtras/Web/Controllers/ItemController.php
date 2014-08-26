<?php namespace Xtras\Controllers;

use App,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	Response,
	ItemUpdateValidator,
	ItemCreationValidator,
	ItemRepositoryInterface,
	UserRepositoryInterface,
	OrderRepositoryInterface;

class ItemController extends BaseController {

	protected $items;
	protected $users;
	protected $orders;
	protected $itemCreate;
	protected $itemUpdate;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users, OrderRepositoryInterface $orders,
			ItemCreationValidator $itemCreate, ItemUpdateValidator $itemUpdate)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
		$this->orders = $orders;
		$this->itemCreate = $itemCreate;
		$this->itemUpdate = $itemUpdate;
	}

	public function create()
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			$products[''] = "Choose a product";
			$products += $this->items->getProducts();

			$types[''] = "Choose a type";
			$types += $this->items->getTypesByPermissions($this->currentUser);

			return View::make('pages.item.create')
				->withProducts($products)
				->withTypes($types);
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function store()
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			// Validate the form
			$this->itemCreate->validate(Input::all());

			// Create the item
			$item = $this->items->create();

			// Fire the item creation event
			Event::fire('item.created', [$item]);

			return Redirect::route('item.upload', [$item->id]);
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function show($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			return View::make('pages.item.show')
				->withItem($item)
				->withMeta($item->meta)
				->withFiles($item->files->sortBy('version', SORT_REGULAR, true))
				->withComments($item->comments->sortBy('created_at', SORT_REGULAR, true));
		}

		return $this->errorNotFound("Xtra not found.");
	}

	public function edit($author, $slug)
	{
		if ($this->currentUser->can('xtras.item.edit'))
		{
			// Get the item
			$item = $this->items->findByAuthorAndSlug($author, $slug);

			if ($item)
			{
				return View::make('pages.item.edit')
					->withItem($item)
					->withMeta($item->meta);
			}
		}

		return $this->errorUnauthorized("You do not have permission to edit Xtras.");
	}

	public function update($id)
	{
		if ($this->currentUser->can('xtras.item.edit'))
		{
			// Get the item
			$xtra = $this->items->find($id);
			
			if ($xtra->user->id != $this->currentUser->id)
			{
				return View::make('pages.error')
					->withType('danger')
					->withError("You do not have permission to edit Xtras that are not your own!");
			}

			// Validate the form
			$this->itemUpdate->validate(Input::all());
			
			// Update the item
			$item = $this->items->update($id, Input::all());

			// Fire the item update event
			Event::fire('item.updated', [$item]);

			return Redirect::route('item.upload', [$item->id]);
		}

		return $this->errorUnauthorized("You do not have permission to edit Xtras.");
	}

	public function destroy($id)
	{
		//
	}

	public function upload($id)
	{
		return View::make('pages.item.upload')
			->withItem($this->items->find($id))
			->withBrowser(App::make('browser'));
	}
	
	public function doZipUpload($id)
	{
		// Get the item
		$item = $this->items->find($id);

		if (Input::hasFile('file'))
		{
			// Get the uploaded file
			$file = Input::file('file');

			// Set the filename
			$filename = "{$item->user->username}/{$item->slug}-{$item->version}";
			$filename.= ".{$file->getClientOriginalExtension()}";

			// Get the contents of the uploaded file
			$contents = \File::get($file->getRealPath());

			// Get an instance of the filesystem
			$fs = App::make('xtras.filesystem');

			// Upload the file
			$result = $fs->write($filename, $contents);

			if ($result)
			{
				// Update the database record
				$this->items->updateFileData($item->id, [
					'filename' => $filename,
					'version' => $item->version,
				]);

				// Fire the event
				Event::fire('item.uploaded', [$item]);

				return Response::json('success', 200);
			}

			return Response::json('failure', 400);
		}
	}

	public function doImagesUpload($id, $image)
	{
		// Get the item
		$item = $this->items->find($id);

		if (Input::hasFile($image))
		{
			// Get the uploaded file
			$file = Input::file($image);

			// Set the filename
			$filename = "{$item->user->username}/{$item->slug}-{$image}";
			$filename.= ".{$file->getClientOriginalExtension()}";

			// Get the contents of the uploaded file
			$contents = \File::get($file->getRealPath());

			// Get an instance of the filesystem
			$fs = App::make('xtras.filesystem');

			// Upload the file
			$result = $fs->write($filename, $contents);

			if ($result)
			{
				// Update the database record
				$this->items->updateMetaData($item->id, [$image => $filename]);

				// Fire the event
				Event::fire('item.uploaded', [$item]);

				return Response::json('success', 200);
			}

			return Response::json('failure', 400);
		}
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

	public function skins()
	{
		// Find all the skins
		$data = $this->items->getByPage('Skin', Input::get('page', 1), 15);

		// Build the paginator
		$paginator = \Paginator::make($data->items, $data->totalItems, 15);

		return View::make('pages.item.list')
			->withType('Skins')
			->withItems($paginator);
	}

	public function ranks()
	{
		// Find all the ranks
		$data = $this->items->getByPage('Rank Set', Input::get('page', 1), 15);

		// Build the paginator
		$paginator = \Paginator::make($data->items, $data->totalItems, 15);

		return View::make('pages.item.list')
			->withType('Rank Sets')
			->withItems($paginator);
	}

	public function mods()
	{
		// Find all the mods
		$data = $this->items->getByPage('MOD', Input::get('page', 1), 15);

		// Build the paginator
		$paginator = \Paginator::make($data->items, $data->totalItems, 15);

		return View::make('pages.item.list')
			->withType('MODs')
			->withItems($paginator);
	}

	public function download($id, $fileId)
	{
		// Get the specific file record
		$file = $this->items->getFile($fileId);

		if ((bool) $file->item->status)
		{
			// Grab just the filename for easy use
			$filename = $file->filename;

			// Add an order record
			$this->orders->create($this->currentUser, $file);

			// Get the filesystem out of the container
			$fs = App::make('xtras.filesystem');

			// Start reading
			$stream = $fs->readStream($filename);

			// Send the right headers
			header("Content-Type: application/zip");
			header("Content-Length: ".$fs->getSize($filename));
			header("Content-disposition: attachment; filename=\"".basename($filename)."\"");

			// Dump the attachment and stop the script
			fpassthru($stream);
			exit;
		}
	}

	public function reportAbuse($id)
	{
		// Get the item
		$item = $this->items->find($id);

		// The combined array
		$input = array_merge(Input::all(), [
			'user_id'	=> $this->currentUser->id,
			'item_id'	=> $item->id,
		]);

		// Fire the event
		Event::fire('item.report.abuse', [$item, $input]);

		// Set the flash information
		Flash::success("Thank you for reporting the issue to Anodyne. An email has been sent to Anodyne with the details. We'll contact you further if we need additional information.");
		
		return Redirect::route('item.show', [$item->user->username, $item->slug]);
	}

	public function reportIssue($id)
	{
		// Get the item
		$item = $this->items->find($id);

		// The combined array
		$input = array_merge(Input::all(), [
			'user_id'	=> $this->currentUser->id,
			'item_id'	=> $item->id,
		]);

		// Fire the event
		Event::fire('item.report.issue', [$item, $input]);

		// Set the flash message
		Flash::success("Thank you for reporting the issue. An email has been sent to the developer with the details. They'll contact you further if they need additional information.");

		return Redirect::route('item.show', [$item->user->username, $item->slug]);
	}

	public function storeComment($id)
	{
		// Get the item
		$item = $this->items->find($id);

		// The combined array
		$input = array_merge(Input::all(), [
			'user_id'	=> $this->currentUser->id,
			'item_id'	=> $item->id,
		]);

		// Store the comment
		$comment = $this->items->addComment($id, $input);

		if ($comment)
		{
			// Fire the event
			Event::fire('item.comment', [$item, $comment, $input]);

			return Redirect::route('item.show', [$item->user->username, $item->slug])
				->with('flashStatus', 'success')
				->with('flashMessage', "Your comment has been added!");
		}

		return Redirect::route('item.show', [$item->user->username, $item->slug])
			->with('flashStatus', 'danger')
			->with('flashMessage', "There was a problem and your comment could not be added.");
	}

	public function messages($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			return View::make('pages.item.messages')
				->withItem($item)
				->withMessages($item->messages);
		}

		return $this->errorNotFound("Xtra not found.");
	}

}