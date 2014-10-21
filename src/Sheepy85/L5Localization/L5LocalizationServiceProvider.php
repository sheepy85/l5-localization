<?php

namespace Sheepy85\L5Localization;

use Illuminate\Support\ServiceProvider;

class L5LocalizationServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the package's component namespaces.
     *
     * @return void
     */
    public function boot() {
        $this->package( 'sheepy85/l5-localization' );
    }

    /**
     * Register the service provider, alias and command.
     *
     * @return void
     */
    public function register() {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias( 'Locale' , 'Sheepy85\L5Localization\Facades\Localization' );

        $this->app['l5-localization'] = $this->app->share( function($app) {
            return new Localization( $app );
        } );

        $this->app['l5-router'] = $this->app->share( function($app) {
            return new Router( $app );
        } );

        $this->app['command.l5-localization.select'] = $this->app->share( function($app) {
            return new Console\Select( $app['files'] );
        } );

        $this->commands( 'command.l5-localization.select' );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}
