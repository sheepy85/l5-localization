<?php namespace Sheepy85\L5Localization;

use Illuminate\Support\Facades\Lang;

class Router {

   private $app;

   public function __construct( $app ) {
	  $this->app = $app;
   }

   public function __call( $name , $args ) {
	  $methods = [ 'get' , 'post' , 'put' , 'delete' , 'patch' ];

	  if ( in_array( $name , $methods ) ) {
		 list($uri , $as , $uses , $locale) = $args;

		 if ( Lang::has( $uri ) ) {
			$uri = Lang::get( $uri , [ ] , $locale );
		 }

		 return $this->app[ 'router' ]->{$name}( $uri , [ 'as' => "$locale.$as" , 'uses' => $uses ] );
	  }
   }

}
