<?php

foreach ( Locale::codes( true ) as $code ) {
   Route::group( [
	   'prefix' => $code ,
	   'namespace' => '\App\Http\Controllers' ,
	   ] , function() use( $code ) {

	  Locale::router()->get( '/' , 'home' , 'HomeController@index' , $code );
	  Locale::router()->get( 'routes.news' , 'news' , 'HomeController@news' , $code );
	  Locale::router()->post( 'login' , 'login' , 'AuthController@login' , $code );
   } );
}
