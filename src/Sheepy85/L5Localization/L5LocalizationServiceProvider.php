<?php namespace Sheepy85\L5Localization;

use Illuminate\Support\ServiceProvider;

class L5LocalizationServiceProvider extends ServiceProvider {

   protected $defer = false;

   public function boot() {
	  $this->package( 'sheepy85/l5-localization' );
   }

   public function register() {
	  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
	  $loader->alias( 'Locale' , 'Sheepy85\L5Localization\Facades\Localization' );

	  $this->app[ 'l5-localization' ] = $this->app->share( function($app) {
		 return new Localization( $app );
	  } );

	  $this->app[ 'l5-router' ] = $this->app->share( function($app) {
		 return new Router( $app );
	  } );
   }

   public function provides() {
	  return [ ];
   }

}
