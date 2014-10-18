<?php namespace Sheepy85\L5Localization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Sheepy85\L5Localization\Localization
 */
class Localization extends Facade {

   /**
	* Get the registered name of the component.
	*
	* @return string
	*/
   protected static function getFacadeAccessor() {
	  return 'l5-localization';
   }

}
