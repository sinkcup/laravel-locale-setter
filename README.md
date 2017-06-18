# Laravel Locale Setter Middleware

This package detect Accept-Language in HTTP header(query string and cookie will be comming), setLocale, then you can use [Laravel localization](https://laravel.com/docs/localization) for I18N.

[![CircleCI](https://circleci.com/gh/sinkcup/laravel-locale-setter.svg?style=svg)](https://circleci.com/gh/sinkcup/laravel-locale-setter)

## Installation

Install the package via Composer:

```
composer require sinkcup/laravel-locale-setter
```

Next, add the package's service provider to your `config/app.php`:

```
// config/app.php

'providers' => [
    sinkcup\LaravelLocaleSetter\LocaleServiceProvider::class
]
```

and then you'll just need to publish the package's configuration:

```
php artisan vendor:publish --provider="sinkcup\LaravelLocaleSetter\LocaleServiceProvider"
```

which will create `config/locale.php`.

## Usage

### Global Middleware

Normally, it should run during every HTTP request, simply add the middleware class to the $middleware property of your `app/Http/Kernel.php` class. For example:

```
// app/Http/Kernel.php

protected $middleware = [
    \sinkcup\LaravelLocaleSetter\Http\Middleware\DetectLocale::class,
];
```

### Assigning Middleware To Routes

if you would like to assign middleware to specific routes, you should add the middleware class to the $routeMiddleware property of your `app/Http/Kernel.php` class. For example:

```
// app/Http/Kernel.php

protected $routeMiddleware = [
    'locale' => \sinkcup\LaravelLocaleSetter\Http\Middleware\DetectLocale::class,
]
```

Once the middleware has been defined in the HTTP kernel, you may use the middleware method to assign middleware to a route:

```
Route::group(['middleware' => ['auth:api', 'locale']], function () {
    Route::resource('/users', 'UserController');
    Route::resource('/photos', 'PhotoController');
});
```

## Config

Linux locale and HTML 4 language code followed [RFC1766](https://www.w3.org/TR/html4/references.html#ref-RFC1766) which was released at March 1995. It's out-of-date.

Due to historical reasons, Linux locale and browsers are still using old standard at now.

iOS want to change it, use [zh-Hans](https://developer.apple.com/library/content/documentation/MacOSX/Conceptual/BPInternational/LanguageandLocaleIDs/LanguageandLocaleIDs.html) and zh-Hans-CN, but it's wrong too.

If you want to do something right, follow the modern standard - [BCP47](https://www.w3.org/TR/html5/dom.html#the-lang-and-xml:lang-attributes) which HTML5 using, and map old language codes to new.

You should use cmn-Hans, cmn-Hans-CN, cmn-Hant and cmn-Hant-TW, instead of zh-CN, zh-TW, zh-Hans and zh-Hant.

create dirs:

```
    resources/lang/cmn_Hans
    resources/lang/cmn_Hant
```

then use:

```
// config/locale.php

'locale_map' => [
    'cmn_hans' => 'cmn_Hans',
    'zh_cn' => 'cmn_Hans',
    'zh_hans' => 'cmn_Hans',
    'cmn_hant' => 'cmn_Hant',
    'zh_hant' => 'cmn_Hant',
    'zh_hk' => 'cmn_Hant',
    'zh_tw' => 'cmn_Hant',
],
```

If you care about regional differences, create dirs:

```
    resources/lang/cmn_Hans_CN
    resources/lang/cmn_Hans_HK
    resources/lang/cmn_Hant_HK
    resources/lang/cmn_Hant_TW
```

then use:

```
// config/locale.php

'locale_map' => [
    'cmn_hans_cn' => 'cmn_Hans_CN',
    'zh_cn' => 'cmn_Hans_CN',
    'cmn_hans_hk' => 'cmn_Hans_HK',
    'cmn_hant_hk' => 'cmn_Hant_HK',
    'zh_hk' => 'cmn_Hant_HK',
    'cmn_hant_tw' => 'cmn_Hant_TW',
    'zh_tw' => 'cmn_Hant_TW',
],
```
