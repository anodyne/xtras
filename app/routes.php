<?php

/**
 * Routes for the system are stored in the XtrasRoutingServiceProvider.
 */

Route::get('email', function()
{
	// Get the item
	$item = ItemModel::first();

	if ($item)
	{
		// Get the user it's coming from
		$user = UserModel::find(5);

		$emailData = [
			'subject' => "Issue Reported - ".$item->present()->name,
			'content' => "Content",
			'from' => $user->present()->email,
			'to' => $item->user->present()->email,
			'name' => HTML::link(route('item.show', [$item->user->slug, $item->slug]), $item->present()->name),
			'type' => $item->present()->type,
			'userName' => $user->present()->name,
			'userEmail' => $user->present()->email,
		];

		return View::make('emails.issue')->with($emailData);
	}
});