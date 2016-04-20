<?php

namespace PHPLegends\ThumbLaravel\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
* Clear the folder of thumbs
*/
class ClearCommand extends Command 
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'thumb:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear the folder of thumbs.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$app = $this->laravel;

		$thumbPath = $app['config']->get('thumb::config.folder');

		if (strval($thumbPath) === '') {

			throw new \UnexpectedValueException(
				'The "thumb::config.folder" cannot be empty'
			);
		}

		$thumbDir = public_path($thumbPath);

		$app['files']->deleteDirectory($thumbDir, true);

		$this->output->writeln('<info>The thumbs caches are removed</info>');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
