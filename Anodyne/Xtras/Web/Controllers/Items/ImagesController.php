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