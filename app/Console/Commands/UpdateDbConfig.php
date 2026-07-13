<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Config as MyConfigurator;
use App\Models\GoogleRecaptcha;

class UpdateDbConfig extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'update:db-config';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load Database Config';

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
	 * @return int
	 */
	public function handle() {
		MyConfigurator::refreshCache();
		$this->info('Database Config has been loaded successfully.');

		GoogleRecaptcha::refreshCache();
		$this->info('Recaptcha Config has been loaded successfully.');

		return Command::SUCCESS;
	}
}
