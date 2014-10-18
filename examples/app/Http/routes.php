<?php
foreach ( Locale::langs( true ) as $key => $locale ) {
   Route::group( [
	   'prefix' => $key ,
	   'namespace' => 'App\Http\Controllers' ,
	   ] , function() use( $key ) {

	  Locale::router()->get( '/' , 'home' , 'HomeController@index' , $key );
	  Locale::router()->get( 'routes.news' , 'news' , 'HomeController@news' , $key );
	  Locale::router()->post( 'login' , 'login' , 'AuthController@login' , $key );
   } );
}
