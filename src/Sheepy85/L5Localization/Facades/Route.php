<?php namespace Sheepy85\L5Localization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Sheepy85\L5Localization\Router
 */
class Route extends Facade {

   protected static function getFacadeAccessor() {
	  return 'l5-router';
   }

}
