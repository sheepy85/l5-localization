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

/**
 * Generate Current URL to another locale.
 *
 * @param  string  $code
 * @return string
 */
if ( ! function_exists( 'url_locale' ) ) {

    function url_locale( $code ) {
        $route = Route::currentRouteName();

        // if locale not set concanate code to route name
        if ( !app( 'l5-localization' )->has() ) {
            return app( 'url' )->route( "$code.$route" );
        }

        // else replace the locale code in route name
        return app( 'url' )->route( substr_replace( $route , $code , 0 , strpos( $route , '.' ) ) );
    }

}
