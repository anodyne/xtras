<?php namespace Xtras\Controllers\Items;

use App,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	Response;

class FilesController extends \BaseController {

	protected $items;

	public function __construct(\ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				return View::make('pages.item.files')
					->withItem($item)
					->withFiles($item->files);
			}

			return $this->unauthorized("You do not have permission to manage files for this Xtra!");
		}

		return $this->errorNotFound("Xtra not found.");
	}

	public function create($author, $slug)
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			// Get the item
			$item = $this->items->findByAuthorAndSlug($author, $slug);

			if ($item)
			{
				if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
				{
					return View::make('pages.item.files-upload')
						->withItem($item)
						->with('hasFile', (bool) $item->getLatestVersion()['files'] != null);
				}

				return $this->errorUnauthorized("You do not have permission to upload files for this Xtra!");
			}

			return $this->errorNotFound("Xtra not found.");
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function remove($fileId)
	{
		// Get the file
		$file = $this->items->findFile($fileId);

		return partial('modal_content', [
			'modalHeader'	=> "Remove File",
			'modalBody'		=> View::make('pages.item.files-remove')->withFile($file),
			'modalFooter'	=> false,
		]);
	}

	public function destroy($fileId)
	{
		if ($this->currentUser->can('xtras.item.delete'))
		{
			// Get the file
			$file = $this->items->findFile($fileId);

			if ($file)
			{
				// Remove the file from the database
				$remove = $this->items->deleteFile($fileId);

				if ($remove)
				{
					// Get an instance of the filesystem
					$fs = App::make('xtras.filesystem');

					// Remove the file
					$fs->delete($file->filename);

					// Fire the event
					Event::fire('item.file.deleted', [$file]);

					// Set the flash message
					Flash::success("File was successfully removed.");
				}

				// Set the flash message
				Flash::error("The file could not be deleted. Please try again.");
			}
			else
			{
				// Set the flash message
				Flash::warning("No file found.");
			}

			return Redirect::route('files.index', [$file->item->user->username, $file->item->slug]);
		}

		return $this->errorUnauthorized("You do not have permission to remove Xtras.");
	}

	public function upload($itemId)
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			// Get the item
			$item = $this->items->find($itemId);

			if ($item)
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
						$contents = \File::get($file->getRealPath());

						// Upload the file
						$result = $fs->write($filename, $contents);

						if ($result)
						{
							// Update the database record
							$this->items->updateFileData($item->id, [
								'filename' => $filename,
								'version' => $item->version,
								'size' => $fs->getSize($filename),
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

			return $this->errorNotFound("Sorry, we couldn't find the Xtra you're looking for!");
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

}