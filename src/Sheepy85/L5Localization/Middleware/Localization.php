<?php namespace Sheepy85\L5Localization\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Sheepy85\L5Localization\Facades\Localization as Locale;

class Localization implements Middleware {

   /**
	* Handle localization resolving for incoming request.
	* 
	* @param \Illuminate\Http\Request $request
	* @param Closure $next
	* @return mixed
	*/
   public function handle( $request , Closure $next ) {
	  $segment = $request->segment( 1 );

	  // no segment or 'raw' url flush session variable | url: /news
	  if ( is_null( $segment ) || Locale::notExist( $segment ) ) {
		 Locale::flush();
		 return $next( $request );
	  }

	  // valid locale | url: /en/news
	  Locale::set( $segment );
	  return $next( $request );
   }

}
