<?php

namespace Sheepy85\L5Localization\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Select extends GeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'locale:select';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate locale config and lang files for selected locales';
    private $select = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        // no argument or get list
        if ( $this->option( 'list' ) || $this->setSelect() ) {
            $this->showList();
            return;
        }

        $this->makeConfig();
        $this->makeLangs();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return __DIR__ . '/stubs/locale.stub';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return [
            [ 'locales' , InputArgument::OPTIONAL | InputArgument::IS_ARRAY , 'en es fr'] ,
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            [ 'list' , 'l' , InputOption::VALUE_NONE , 'Show Locales list'] ,
        ];
    }

    /**
     * Show the Locales list.
     *
     * @return string
     */
    protected function showList() {
        $locales = $this->laravel['config']['l5-localization::locales'];
        $langs = '';
        $i = 0;

        foreach ( $locales as $code => $locale ) {
            $langs .= $code . ",\t";
            if ( $i++ > 8 ) {
                $langs .= "\n";
                $i = 0;
            }
        }

        $this->info( $langs );
    }

    /**
     * Insert the locales for the given stub.
     *
     * @return string
     */
    protected function insertLocales() {
        $insert = '';

        foreach ( $this->select as $code => $lo ) {
            $insert .= "'$code' => ['name' => '$lo[name]' , 'script' => '$lo[script]' , 'dir' => '$lo[dir]' , 'native' => '$lo[native]'] ,\n";
        }

        return str_replace( '{{locales}}' , $insert , $this->files->get( $this->getStub() ) );
    }

    /**
     * Insert the locales for the given stub.
     *
     * @return string
     */
    protected function insertRoutes( $locale ) {
        return str_replace( '{{native}}' , $locale['native'] , $this->files->get( __DIR__ . '/stubs/routes.stub' ) );
    }

    protected function setSelect() {
        $locales = $this->laravel['config']['l5-localization::locales'];

        foreach ( array_map( 'strtolower' , $this->argument( 'locales' ) ) as $locale ) {
            $this->select[$locale] = $locales[$locale];
        }

        return !count( $this->select );
    }

    /**
     * Make the config file with the given locales.
     *
     * @return string
     */
    protected function makeLangs() {
        $lang_base = $this->laravel['path.lang'];

        foreach ( $this->select as $code => $locale ) {
            $lang = "$lang_base/$code";

            if ( !is_dir( $lang ) ) {
                mkdir( $lang , 0777 , true );
            }

            $this->files->put( $lang . '/routes.php' , $this->insertRoutes( $locale ) );
            $this->info( $lang . ' lang folder created successfully.' );
        }
    }

    /**
     * Make the config file with the given locales.
     *
     * @return string
     */
    protected function makeConfig() {
        $config = $this->laravel['path.config'] . '/locale.php';
        $this->files->put( $config , $this->insertLocales() );
        $this->info( $config . ' config created successfully.' );
    }

}
