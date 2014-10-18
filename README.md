l5-localization
===============

Facade Alias : Locale

## Setup

Step 1: Add to stack
```php
// App\Providers\AppServiceProvider.php
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

## Examples

Example files in project folder [ config, lang ]

Locale::langs() looking for config/locale.php, optional paramater [true] for raw url generation

Locale::router() return Laravel Router instance and only accept [get, post, put, delete, patch] methoods
Generate route:cache for all of your languages
If routes lang file don't have the key, use as Uri
```php
// routes.php
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
POST hu/login           | hu.login | App\Http\Controllers\AuthController@login
```

make Url with helper to the session current locale:
```html
{{ lroute('news') }}
```

or laravel's helper
notice need to comment out the original function in Illuminate\Foundation\helpers.php file
```html
{{ route('news') }}
```