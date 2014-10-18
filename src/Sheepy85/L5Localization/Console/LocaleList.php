<?php namespace Sheepy85\L5Localization\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LocaleList extends Command {

   /**
	* The console command name.
	*
	* @var string
	*/
   protected $name = 'locale:list';

   /**
	* The console command description.
	*
	* @var string
	*/
   protected $description = 'Show avalaible locales';

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
		  [ ] ,
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
