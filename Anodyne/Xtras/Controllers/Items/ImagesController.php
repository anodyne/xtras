<?php namespace Xtras\Controllers\Items;

use App,
	Item,
	File,
	View,
	Event,
	Flash,
	Image,
	Input,
	Redirect,
	Response,
	BaseController,
	ItemRepositoryInterface;

class ImagesController extends BaseController {

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
				return View::make('pages.item.images')
					->withItem($item)
					->withMetadata($item->metadata);
			}

			return $this->errorUnauthorized("You don't have access to manage images for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	public function remove($itemId, $image)
	{
		// Get the item
		$item = $this->items->find($itemId);

		if ($item)
		{
			$content = ($this->checkPermissions($item))
				? View::make('pages.item.images-remove')->withItem($item)->withImage($image)
				: alert('danger', "You don't have access to manage images for this Xtra.");
		}
		else
		{
			$content = alert('danger', "We couldn't find the Xtra you're looking for.");
		}

		return partial('modal_content', [
			'modalHeader'	=> "Remove Image",
			'modalBody'		=> $content,
			'modalFooter'	=> false,
		]);
	}

	public function destroy($itemId, $imageNumber)
	{
		// Get the item
		$item = $this->items->find($itemId);

		if ($item)
		{
			if ($this->checkPermissions($item))
			{
				// Get an instance of the filesystem
				$fs = App::make('xtras.filesystem');

				// Delete the image from the filesystem
				$fs->delete($item->metadata->{"image{$imageNumber}"});
				$fs->delete($item->metadata->{"thumbnail{$imageNumber}"});

				// Remove the image
				$this->items->deleteImage($itemId, $imageNumber);

				Event::fire('item.image.deleted', [$item]);

				Flash::success("Image has been successfully removed.");

				return Redirect::route('item.images.index', [$item->user->username, $item->slug]);
			}

			return $this->errorUnauthorized("You don't have access to manage images for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
	}

	public function upload($itemId, $image)
	{
		if ($this->currentUser->can('xtras.item.upload') or $this->currentUser->can('xtras.admin'))
		{
			// Get the item
			$item = $this->items->find($itemId);

			if ($item)
			{
				if ($this->checkPermissions($item))
				{
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
						$result = $fs->put($fullFilename, File::get($file->getRealPath()));

						if ($result)
						{
							// Generate the thumbnails as well
							$img = Image::make($file->getRealPath())->resize(250, null, function($c)
							{
								$c->aspectRatio();
							});

							// Set the thumbnail name
							$thumbnailFilename = $baseFilename.$image."_thumb".$extension;

							// Save the thumbnail
							$fs->put($thumbnailFilename, $img->encode());

							// Update the database record
							$this->items->updateMetadata($item->id, [
								$image => $fullFilename,
								"thumbnail{$imageNumber}" => $thumbnailFilename,
							]);

							Event::fire('item.image.uploaded', [$item]);

							return Response::json('Success', 200);
						}

						return Response::json('Failure', 400);
					}

					return Response::json('No file input found', 500);
				}

				return $this->errorUnauthorized("You don't have access to manage images for this Xtra.");
			}

			return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
		}

		return $this->errorUnauthorized("You don't have access to upload files.");
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
			if ($this->checkPermissions($item))
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