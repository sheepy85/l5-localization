<?php namespace Sheepy85\L5Localization;

use Illuminate\Support\Facades\Session;

class Localization {

   private $sessionKey = 'locale';
   private $langs;
   private $app;
   private $fallback;

   public function __construct( $app ) {
	  $this->app = $app;
	  $this->langs = $this->app[ 'config' ][ 'locale.locales' ];
	  $this->fallback = $this->app[ 'config' ][ 'app.fallback_locale' ];
   }

   public function has() {
	  return Session::has( $this->sessionKey );
   }

   public function get() {
	  return Session::get( $this->sessionKey );
   }

   public function set( $locale ) {
	  Session::put( $this->sessionKey , $locale );
	  $this->app->setLocale( $locale );
   }

   public function flush() {
	  return Session::flush( $this->sessionKey );
   }

   public function exist( $locale ) {
	  return !$this->notExist( $locale );
   }

   public function notExist( $locale ) {
	  return empty( $this->langs[ $locale ] );
   }

   public function fallback() {
	  $this->flushLocale();
	  $this->app->setLocale( $this->fallback );
   }

   public function locale() {
	  return $this->langs[ $this->get() ];
   }

   public function name() {
	  return $this->langs[ $this->get() ][ 'name' ];
   }

   public function native() {
	  return $this->langs[ $this->get() ][ 'native' ];
   }

   public function script() {
	  return $this->langs[ $this->get() ][ 'script' ];
   }

   public function direction() {
	  return $this->langs[ $this->get() ][ 'dir' ];
   }

   public function langs( $withRaw = false ) {
	  if ( $withRaw ) {
		 return array_merge( [ null => null ] , $this->langs );
	  }
	  return $this->langs;
   }

   public function router() {
	  return $this->app[ 'l5-router' ];
   }

   public function route( $name , $parameters = array() , $absolute = true , $route = null ) {
	  if ( $this->has() ) {
		 $name = $this->get() . '.' . $name;
	  }
	  return $this->app[ 'url' ]->route( $name , $parameters , $absolute , $route );
   }

}
