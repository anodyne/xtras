<?php namespace Xtras\Controllers\Items;

use App,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	Paginator,
	BaseController,
	ItemRepositoryInterface,
	UserRepositoryInterface,
	OrderRepositoryInterface;

class ItemController extends BaseController {

	protected $items;
	protected $users;
	protected $orders;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users, OrderRepositoryInterface $orders)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
		$this->orders = $orders;
	}

	public function show($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			$userRating = false;
			$notify = false;

			if ($this->currentUser)
			{
				$user = $this->currentUser;

				$userRating = $item->ratings->filter(function($r) use ($user)
				{
					return (int) $user->id === (int) $r->user_id;
				})->first();

				$notify = $this->currentUser->isBeingNotified($item);
			}

			return View::make('pages.item.show')
				->withItem($item)
				->withMetadata($item->metadata)
				->withFiles($item->files->sortBy('version', SORT_REGULAR, true))
				->withComments($item->comments->sortBy('created_at', SORT_REGULAR, true))
				->with('commentCount', ($item->comments->count() > 0) ? "({$item->comments->count()})" : "")
				->with('userRating', $userRating)
				->withNotify($notify);
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	public function ajaxStoreRating()
	{
		$this->items->rate($this->currentUser, Input::get('item'), Input::get('rating'));
	}

	public function skins()
	{
		return $this->getItemsByType('Skin', 'Skins');
	}

	public function ranks()
	{
		return $this->getItemsByType('Rank Set', 'Rank Sets');
	}

	public function mods()
	{
		return $this->getItemsByType('MOD', 'MODs');
	}

	public function download($author, $slug, $fileId)
	{
		// Get the specific file record
		$file = $this->items->findFile($fileId);

		if ((bool) $file->item->status and (bool) $file->item->admin_status)
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

	public function reportAbuse($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			// The combined array
			$input = array_merge(Input::all(), [
				'user_id'	=> $this->currentUser->id,
				'item_id'	=> $item->id,
			]);

			// Fire the event
			Event::fire('item.report.abuse', [$item, $input]);

			// Set the flash information
			Flash::success("Thank you for reporting the issue to Anodyne. An email has been sent to Anodyne with the details. We'll contact you further if we need additional information.");
			
			return Redirect::route('item.show', [$author, $slug]);
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	public function reportIssue($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			// The combined array
			$input = array_merge(Input::all(), [
				'user_id'	=> $this->currentUser->id,
				'item_id'	=> $item->id,
			]);

			// Fire the event
			Event::fire('item.report.issue', [$item, $input]);

			// Set the flash message
			Flash::success("Thank you for reporting the issue. An email has been sent to the developer with the details. They'll contact you further if they need additional information.");

			return Redirect::route('item.show', [$author, $slug]);
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	protected function getItemsByType($type, $label)
	{
		// Find all the mods
		$data = $this->items->getByPage($type, Input::get('page', 1), 15);

		// Build the paginator
		$paginator = Paginator::make($data->items, $data->totalItems, 15);

		return View::make('pages.item.list')
			->withType($label)
			->withItems($paginator);
	}

}