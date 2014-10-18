<?php namespace Sheepy85\L5Localization\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Select extends Command {

   /**
	* The console command name.
	*
	* @var string
	*/
   protected $name = 'locale:select';

   /**
	* The console command description.
	*
	* @var string
	*/
   protected $description = 'Generate config and lang files for selected locales';

   /**
	* Create a new command instance.
	*
	* @return void
	*/
   public function __construct() {
	  parent::__construct();
   }

   /**
	* Execute the console command.
	*
	* @return mixed
	*/
   public function fire() {
	  //
   }

   /**
	* Get the console command arguments.
	*
	* @return array
	*/
   protected function getArguments() {
	  return [
		  ['locales' , InputArgument::REQUIRED , 'en, hu' ] ,
	  ];
   }

   /**
	* Get the console command options.
	*
	* @return array
	*/
   protected function getOptions() {
	  return [
		  [ ] ,
	  ];
   }

}
