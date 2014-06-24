<?php namespace Xtras\Controllers;

use App,
	View,
	Event,
	Input,
	Redirect,
	Response,
	ItemRepositoryInterface,
	UserRepositoryInterface,
	OrderRepositoryInterface;

class ItemController extends BaseController {

	protected $items;
	protected $users;
	protected $orders;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users,
			OrderRepositoryInterface $orders)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
		$this->orders = $orders;
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

		return View::make('pages.error')
			->withType('danger')
			->withError("You do not have permission to create xtras!");
	}

	public function store()
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			if (Input::get('user_id') != $this->currentUser->id)
			{
				//
			}
			
			// Create the item
			$item = $this->items->create();

			// Fire the item creation event
			Event::fire('item.created', [$item]);

			return Redirect::route('item.upload', [$item->id]);
		}

		return View::make('pages.error')
			->withType('danger')
			->withError("You do not have permission to create xtras!");
	}

	public function show($author, $slug)
	{
		// Get the item by its ID
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			return View::make('pages.item.show')
				->withItem($item)
				->withMeta($item->meta)
				->withFiles($item->files->sortBy('version', SORT_REGULAR, true))
				->withComments($item->comments->sortBy('created_at', SORT_REGULAR, true));
		}

		// TODO: couldn't find the item
	}

	public function edit($id)
	{
		//
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

	public function upload($id)
	{
		return View::make('pages.item.upload')
			->withItem($this->items->find($id))
			->withBrowser(App::make('xtras.browser'));
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
			$filename = "{$item->user->slug}/{$item->slug}-{$item->version}";
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

	public function doImageUpload($id)
	{
		# code...
	}

	public function ajaxCheckName()
	{
		// Try to find any items
		$items = $this->users->findItemsByName($this->currentUser, Input::get('name'));

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
		$items = $this->items->findByType('skins');

		return View::make('pages.item.list')
			->withType('Skins')
			->withItems($items);
	}

	public function ranks()
	{
		// Find all the ranks
		$items = $this->items->findByType('ranks');

		return View::make('pages.item.list')
			->withType('Rank Sets')
			->withItems($items);
	}

	public function mods()
	{
		// Find all the mods
		$items = $this->items->findByType('mods');

		return View::make('pages.item.list')
			->withType('MODs')
			->withItems($items);
	}

	public function download($id, $fileId)
	{
		// Get the specific file record
		$file = $this->items->getFile($fileId);

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
		
		return Redirect::route('item.show', [$item->user->slug, $item->slug])
			->with('flashStatus', 'success')
			->with('flashMessage', "Thank you for reporting the issue to Anodyne. An email has been sent to Anodyne with the details. We'll contact you further if we need additional information.");
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

		return Redirect::route('item.show', [$item->user->slug, $item->slug])
			->with('flashStatus', 'success')
			->with('flashMessage', "Thank you for reporting the issue. An email has been sent to the developer with the details. They'll contact you further if they need additional information.");
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

			return Redirect::route('item.show', [$item->user->slug, $item->slug])
				->with('flashStatus', 'success')
				->with('flashMessage', "Your comment has been added!");
		}

		return Redirect::route('item.show', [$item->user->slug, $item->slug])
			->with('flashStatus', 'danger')
			->with('flashMessage', "There was a problem and your comment could not be added.");
	}

}