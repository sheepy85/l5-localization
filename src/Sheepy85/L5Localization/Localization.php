<?php

namespace Sheepy85\L5Localization;

use Illuminate\Support\Facades\Session;

class Localization {

    /**
     * Session variable name
     *
     * @var string 
     */
    private $sessionKey = 'locale';

    /**
     * Available localizations
     *
     * @var array 
     */
    private $_locales;

    /**
     * Laravel app instance
     *
     * @var \Illuminate\Foundation\Application 
     */
    private $app;

    /**
     * Fallback localization
     *
     * @var string 
     */
    private $fallback;

    /**
     * Set private variables
     * 
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct( $app ) {
        $this->app = $app;
        $this->_locales = $this->app['config']['locale.locales'];
        $this->fallback = $this->app['config']['app.fallback_locale'];
    }

    /**
     * Determine localization status
     * 
     * @return bool
     */
    public function has() {
        return Session::has( $this->sessionKey );
    }

    /**
     * Get current localization
     * 
     * @return string
     */
    public function get() {
        return $this->has() ? Session::get( $this->sessionKey ) : $this->fallback;
    }

    /**
     * Set current localization
     * 
     * @param string $locale
     */
    public function set( $locale ) {
        Session::put( $this->sessionKey , $locale );
        $this->app->setLocale( $locale );
    }

    /**
     * Unset Session variable
     * 
     * 
     */
    public function flush() {
        Session::flush( $this->sessionKey );
    }

    /**
     * Determine localization adjustable
     * 
     * @param string $locale
     * @return bool
     */
    public function exist( $locale ) {
        return !$this->notExist( $locale );
    }

    /**
     * Determine localization not adjustable
     * 
     * @param string $locale
     * @return bool
     */
    public function notExist( $locale ) {
        return empty( $this->_locales[$locale] );
    }

    /**
     * Set fallback localization
     * 
     */
    public function fallback() {
        $this->flushLocale();
        $this->app->setLocale( $this->fallback );
    }

    /**
     * Get current localization
     * 
     * @return array
     */
    public function locale() {
        return $this->_locales[$this->get()];
    }

    /**
     * Get current localization english name
     * 
     * @return string
     */
    public function name() {
        return $this->_locales[$this->get()]['name'];
    }

    /**
     * Get current localization native name
     * 
     * @return string
     */
    public function native() {
        return $this->_locales[$this->get()]['native'];
    }

    /**
     * Get current localization code script
     * 
     * @return string
     */
    public function script() {
        return $this->_locales[$this->get()]['script'];
    }

    /**
     * Get current localization read direction
     * 
     * @return string
     */
    public function direction() {
        return $this->_locales[$this->get()]['dir'];
    }

    /**
     * Get available localizations, optional empty first row
     * 
     * @param bool $withNull
     * @return array
     */
    public function locales( $withNull = false ) {
        return $withNull ? array_merge( [ null => null] , $this->_locales ) : $this->_locales;
    }

    /**
     * 
     * @return \Illuminate\Routing\Router
     */
    public function router() {
        return $this->app['l5-router'];
    }

    /**
     * Get the URL to a named route.
     *
     * @param  string  $name
     * @param  mixed   $parameters
     * @param  bool  $absolute
     * @return string
     *
     */
    public function route( $name , $parameters = array() , $absolute = true , $route = null ) {
        if ( $this->has() ) {
            $name = $this->get() . '.' . $name;
        }
        return $this->app['url']->route( $name , $parameters , $absolute , $route );
    }

}
