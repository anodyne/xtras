<?php namespace Xtras\Controllers\Items;

use App,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	Response;

class ImagesController extends \BaseController {

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
				return View::make('pages.item.images')
					->withItem($item)
					->withMetadata($item->metadata);
			}

			return $this->unauthorized("You do not have permission to manage images for this Xtra!");
		}

		return $this->errorNotFound("Xtra not found.");
	}

	public function remove($itemId, $image)
	{
		// Get the item
		$item = $this->items->find($itemId);

		return partial('modal_content', [
			'modalHeader'	=> "Remove Image",
			'modalBody'		=> View::make('pages.item.images-remove')
				->withItem($item)
				->withImage($image),
			'modalFooter'	=> false,
		]);
	}

	public function destroy($itemId, $imageNumber)
	{
		// Get the item
		$item = $this->items->find($itemId);

		if ($item)
		{
			if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				// Get an instance of the filesystem
				$fs = App::make('xtras.filesystem');

				// Delete the image from the filesystem
				$fs->delete($item->metadata->{"image{$imageNumber}"});
				$fs->delete($item->metadata->{"thumbnail{$imageNumber}"});

				// Remove the image
				$this->items->deleteImage($itemId, $imageNumber);

				// Fire the event
				Event::fire('item.image.deleted', [$item]);

				// Set the flash message
				Flash::success("Image has been successfully removed.");

				return Redirect::route('item.images.index', [$item->user->username, $item->slug]);
			}

			return $this->errorUnauthorized("You do not have permission to manage images for this Xtra!");
		}

		return $this->errorNotFound("Xtra could not be found!");
	}

	public function upload($itemId, $image)
	{
		if ($this->currentUser->can('xtras.item.create'))
		{
			// Get the item
			$item = $this->items->find($itemId);

			if (Input::hasFile($image))
			{
				// Get the image number
				$imageNumber = substr($image, -1);

				// Get the uploaded file
				$file = Input::file($image);

				// Set the base filename and extension
				$baseFilename = "{$item->user->username}/{$item->slug}-";
				$extension = ".{$file->getClientOriginalExtension()}";

				// Set the filename
				$fullFilename = $baseFilename.$image.$extension;

				// Get an instance of the filesystem
				$fs = App::make('xtras.filesystem');

				// Upload the file
				$result = $fs->put($fullFilename, \File::get($file->getRealPath()));

				if ($result)
				{
					// Generate the thumbnails as well
					$img = \Image::make($file->getRealPath())->resize(250, null, function($c)
					{
						$c->aspectRatio();
					});

					// Set the thumbnail name
					$thumbnailFilename = $baseFilename.$image."_thumb".$extension;

					// Save the thumbnail
					$fs->put($thumbnailFilename, $img->encode());

					// Update the database record
					$this->items->updateMetaData($item->id, [
						$image => $fullFilename,
						"thumbnail{$imageNumber}" => $thumbnailFilename,
					]);

					// Fire the event
					Event::fire('item.image.uploaded', [$item]);

					return Response::json('Success', 200);
				}

				return Response::json('Failure', 400);
			}

			return Response::json('No file input', 500);
		}

		return $this->errorUnauthorized("You do not have permission to create Xtras.");
	}

	public function primary()
	{
		// Get the data
		$itemId = Input::get('item');
		$imageNumber = Input::get('image');

		// Get the item
		$item = $this->items->find($itemId);

		if ($item)
		{
			if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				// Get an instance of the filesystem
				$fs = App::make('xtras.filesystem');

				// Build the temporary image names
				$tempExt = substr($item->metadata->{"image{$imageNumber}"}, -4);
				$tempImage = "{$item->user->username}/{$item->slug}-image0{$tempExt}";
				$tempThumb = "{$item->user->username}/{$item->slug}-image0_thumb{$tempExt}";

				// 1. Rename the one we're changing to 0
				$fs->rename($item->metadata->{"image{$imageNumber}"}, $tempImage);
				$fs->rename($item->metadata->{"thumbnail{$imageNumber}"}, $tempThumb);

				// 2. Rename the primary to the one we just renamed
				$fs->rename($item->metadata->image1, $item->metadata->{"image{$imageNumber}"});
				$fs->rename($item->metadata->thumbnail1, $item->metadata->{"thumbnail{$imageNumber}"});

				// 3. Rename 0 to 1
				$fs->rename($tempImage, $item->metadata->image1);
				$fs->rename($tempThumb, $item->metadata->thumbnail1);

				return Response::json("Success", 200);
			}

			return Response::json("Unauthorized", 403);
		}

		return Response::json("Not found", 404);
	}

}