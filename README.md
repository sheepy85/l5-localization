l5-localization
===============
Simple Localization Middleware for Laravel 5 to make dynamic prefixed route names to the same controller actions.

Features
---------
* Seo friendly url generation: example.com/news, example.com/en/news, example.com/es/noticias, example.com/fr/nouvelles
* Session stored Localization data.
* Locale prefix Route names
* Lang file stored Route url with model name
* Route Cache

Facade Alias : Locale

## Setup

Step 1: Add to stack
```php
// App\Http\Kernel.php
protected $stack = [
    ...
    'Sheepy85\L5Localization\Middleware\Localization',
];
```

Step 2: Use routes.php file
```php
// App\Providers\RouteServiceProvider.php
public function map( Router $router ) {
    require app_path( 'Http/routes.php' ); // uncomment
}
```

Step 3: Add the ServiceProvider
```php
// config/app.php
'providers' => [
    ...
    'Sheepy85\L5Localization\L5LocalizationServiceProvider' ,
] ,
```

Step 4: Use file generator
```cmd
> php artisan locale:select en es fr
```
to get the full list of Localization short codes use -l or --list


## Examples

Example files in project folder.

`Locale::locales()` looking for config/locale.php, set optional parameter to `true` for raw url generation
`Locale::router()` return Laravel Router instance and only accept `[get, post, put, delete, patch]` methods

Generate route:cache for all of your languages
---------

1 arg: If your routes lang file don't contain the route name, use as raw Uri
2 arg: Route name
3 arg: Action
4 arg: Localization short code
```php
// routes.php
foreach ( Locale::locales( true ) as $code => $locale ) {
   Route::group( [
	   'namespace' => '\App\Http\Controllers' ,
	   'prefix' => $code , 
	   ] , function() use( $code ) {

	  Locale::router()->get( '/' , 'home' , 'HomeController@index' , $code );
	  Locale::router()->get( 'routes.news' , 'news' , 'HomeController@news' , $code );
	  Locale::router()->post( 'login' , 'login' , 'AuthController@login' , $code );
   } );
}
```

Result:
```cmd
GET|HEAD /              | home     | App\Http\Controllers\HomeController@index
GET|HEAD news           | news     | App\Http\Controllers\HomeController@news
POST login              | login    | App\Http\Controllers\AuthController@login
GET|HEAD en             | en.home  | App\Http\Controllers\HomeController@index
GET|HEAD en/news        | en.news  | App\Http\Controllers\HomeController@news
POST en/login           | en.login | App\Http\Controllers\AuthController@login
GET|HEAD hu             | hu.home  | App\Http\Controllers\HomeController@index
GET|HEAD hu/hirek       | hu.news  | App\Http\Controllers\HomeController@news
POST hu/belepes         | hu.login | App\Http\Controllers\AuthController@login
```

make Url
---------
with helper to the session current locale:
```html
{{ lroute('news') }}
```

or laravel's helper, notice need to comment out the original function in `Illuminate\Foundation\helpers.php` file
```html
{{ route('news') }}
```

Api Locale::
---------
* `has()` Determine localization status
* `get()` Get current localization
* `set( $locale )` Set current localization
* `flush()` Unset Session variable
* `exist( $locale )` Determine localization adjustable
* `notExist( $locale )` Determine localization not adjustable
* `fallback()` Set fallback localization
* `locale()` Get current localization
* `name()` Get current localization english name
* `native()` Get current localization native name
* `script()` Get current localization code script
* `direction()` Get current localization read direction
* `locales( $withNull = false )` Get available localizations, optional empty first row
