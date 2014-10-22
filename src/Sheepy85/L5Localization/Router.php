<?php namespace Sheepy85\L5Localization;

use Illuminate\Support\Facades\Lang;

class Router {

   /**
	* Laravel app instance
	*
	* @var \Illuminate\Foundation\Application 
	*/
   private $app;

   /**
	* Set Laravel app instance
	*
	* @var \Illuminate\Foundation\Application 
	*/
   public function __construct( $app ) {
	  $this->app = $app;
   }

   /**
    * Create localizated Route
	* 
	* @param string $name [ get, post, put, delete, patch ]
	* @param array $args
	* @return \Illuminate\Routing\Router
	*/
   public function __call( $name , $args ) {
	  $methods = [ 'get' , 'post' , 'put' , 'delete' , 'patch' ];

	  if ( in_array( $name , $methods ) ) {
		 list($uri , $as , $uses , $locale) = $args;

		 if ( Lang::has( $uri ) ) {
			$uri = Lang::get( $uri , [ ] , $locale );
		 }

		 if ( $locale ) {
			$as = "$locale.$as";
		 }

		 return $this->app[ 'router' ]->{$name}( $uri , [ 'as' => $as , 'uses' => $uses ] );
	  }
   }

}
