<?php namespace Xtras\Controllers\Items;

use App,
	File,
	Item,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	Response,
	BaseController,
	ItemRepositoryInterface;

class FilesController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;

		// Before filter to check if the user has permissions
		$this->beforeFilter('@checkEditPermissions');
	}

	public function index($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($this->checkPermissions($item))
			{
				return View::make('pages.item.files')
					->withItem($item)
					->withFiles($item->files);
			}

			return $this->errorUnauthorized("You don't have access to manage files for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	public function create($author, $slug)
	{
		if ($this->currentUser->can('xtras.item.upload') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$item = $this->items->findByAuthorAndSlug($author, $slug);

			if ($item)
			{
				if ($this->checkPermissions($item))
				{
					return View::make('pages.item.files-upload')
						->withItem($item)
						->with('hasFile', (bool) $item->getLatestVersion()['files'] != null);
				}

				return $this->errorUnauthorized("You don't have access to upload files for this Xtra.");
			}

			return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
		}

		return $this->errorUnauthorized("You don't have access to upload files.");
	}

	public function upload($itemId)
	{
		if ($this->currentUser->can('xtras.item.upload') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$item = $this->items->find($itemId);

			if ($item)
			{
				if ($this->checkPermissions($item))
				{
					// Figure out if this is a new version we need to notify for
					$notifyForNewVersion = ($item->getLatestVersion()['files'] === null);

					if (Input::hasFile('file'))
					{
						// Get an instance of the filesystem
						$fs = App::make('xtras.filesystem');

						// Get the uploaded file
						$file = Input::file('file');

						// Set the filename
						$filename = "{$item->user->username}/{$item->slug}-{$item->version}";
						$filename.= ".{$file->getClientOriginalExtension()}";

						if ($fs->has($filename))
						{
							return Response::json('File already exists', 409);
						}
						else
						{
							// Get the contents of the uploaded file
							$contents = File::get($file->getRealPath());

							// Upload the file
							$result = $fs->write($filename, $contents);

							if ($result)
							{
								// Update the database record
								$this->items->updateFileData($item->id, [
									'filename'	=> $filename,
									'version'	=> $item->version,
									'size'		=> (int) $fs->getSize($filename),
								]);

								// Fire the event
								Event::fire('item.file.uploaded', [$item]);

								// Fire the notify event if we need to
								if ($notifyForNewVersion)
								{
									Event::fire('item.notify', [$item]);
								}

								return Response::json('Success', 200);
							}

							return Response::json('Could not upload file', 400);
						}
					}

					return Response::json('No file input', 500);
				}

				return $this->errorUnauthorized("You don't have access to upload files for this Xtra.");
			}

			return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
		}

		return $this->errorUnauthorized("You don't have access to upload files.");
	}

	public function remove($fileId)
	{
		// Get the file
		$file = $this->items->findFile($fileId);

		if ($file)
		{
			$content = ($this->checkPermissions($file->item))
				? View::make('pages.item.files-remove')->withFile($file)
				: alert('danger', "You don't have access to manage files for this Xtra.");
		}
		else
		{
			$content = alert('danger', "We couldn't find the file you're looking for.");
		}

		return partial('modal_content', [
			'modalHeader'	=> "Remove File",
			'modalBody'		=> $content,
			'modalFooter'	=> false,
		]);
	}

	public function destroy($fileId)
	{
		// Get the file
		$file = $this->items->findFile($fileId);

		if ($file)
		{
			if ($this->checkPermissions($file->item))
			{
				// Remove the file from the database
				$remove = $this->items->deleteFile($fileId);

				if ($remove)
				{
					// Get an instance of the filesystem
					$fs = App::make('xtras.filesystem');

					// Remove the file
					$fs->delete($file->filename);

					Event::fire('item.file.deleted', [$file]);

					Flash::success("File was successfully removed.");
				}
				else
				{
					Flash::error("The file couldn't be removed. Please try again.");
				}
			}
			else
			{
				Flash::error("You don't have access to manage files for this Xtra.");
			}
		}
		else
		{
			Flash::warning("No file found.");
		}

		return Redirect::route('item.files.index', [$file->item->user->username, $file->item->slug]);
	}

	public function checkPermissions(Item $item)
	{
		if ($item->isOwner($this->currentUser) or $this->currentUser->can('xtras.admin'))
		{
			return true;
		}

		return false;
	}

	public function checkEditPermissions()
	{
		if ( ! $this->currentUser->can('xtras.item.edit') and ! $this->currentUser->can('xtras.admin'))
		{
			return $this->errorUnauthorized("You don't have access to edit Xtras!");
		}
	}

}