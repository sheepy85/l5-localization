<?php
/**
 * Generate a Localized URL to a named route based on current locale.
 *
 * @param  string  $name
 * @param  array   $parameters
 * @param  bool    $absolute
 * @param  \Illuminate\Routing\Route  $route
 * @return string
 */
if ( function_exists( 'route' ) ) {

   //rename_function( 'route' , 'laravel_route' ); // PECL apd

   function lroute( $name , $parameters = array() , $absolute = true , $route = null ) {
	  return app( 'l5-localization' )->route( $name , $parameters , $absolute , $route );
   }

}
else {

   function route( $name , $parameters = array() , $absolute = true , $route = null ) {
	  return app( 'l5-localization' )->route( $name , $parameters , $absolute , $route );
   }

}
