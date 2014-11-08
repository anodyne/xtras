<?php namespace Xtras\Commands;

use Mail;
use Illuminate\Console\Command;

class DeployedCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'xtras:deployed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Notify of a completed deployment.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$data['content'] = "# Deployment Complete

The deployment to AnodyneXtras is complete and the site is back up and available for the public.";

		Mail::send('emails.basic', $data, function($msg)
		{
			$msg->to(config('anodyne.email.general'))
				->subject(config('anodyne.email.subject').' Deployment Complete');
		});
	}

}