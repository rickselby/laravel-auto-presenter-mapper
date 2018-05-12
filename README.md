Laravel Auto Presenter Mapper
=============================

![PHP 7.0+](https://img.shields.io/badge/php-7.0%2B-blue.svg)
[![Build Status](https://img.shields.io/travis/rickselby/laravel-auto-presenter-mapper.svg)](https://travis-ci.org/rickselby/laravel-auto-presenter-mapper)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/6a69b118-1651-418b-a8b5-f2780dbc893c.svg)](https://insight.sensiolabs.com/projects/6a69b118-1651-418b-a8b5-f2780dbc893c)
[![Code Coverage](https://img.shields.io/codecov/c/github/rickselby/laravel-auto-presenter-mapper.svg)](https://codecov.io/gh/rickselby/laravel-auto-presenter-mapper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)

This is an extension to the excellent [laravel-auto-presenter](https://github.com/laravel-auto-presenter/laravel-auto-presenter)
that allows you to define presenters in a service provider or on-the-fly, rather than directly on the model.

## Compatibility Chart

| Laravel Auto Presenter Mapper                                              | Laravel   | PHP    |
|----------------------------------------------------------------------------|-----------|--------|
| **3.x**                                                                    | 5.5 – 5.6 | 7.1.3+ |
| [2.x](https://github.com/rickselby/laravel-auto-presenter-mapper/tree/2.x) | 5.1 – 5.5 | 7.0+   |
| [1.x](https://github.com/rickselby/laravel-auto-presenter-mapper/tree/1.x) | 5.1 – 5.4 | 5.5+   |

## Installing

Require the project using [Composer](https://getcomposer.org):

```bash
$ composer require rickselby/laravel-auto-presenter-mapper
```

Laravel 5.5 will auto-discover the package.

For Laravel 5.1-5.4, you should only add this service provider, not the original `laravel-auto-presenter` service provider, as this one
extends it.

In your `config/app.php` add this line to your 'providers' array...

```php
RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapperServiceProvider::class,
```

... and this line to your 'facades' array.

```php
'Presenters' => \RickSelby\LaravelAutoPresenterMapper\Facades\AutoPresenterMapperFacade::class,
```

## Usage

Read the docs at [github.com/laravel-auto-presenter/laravel-auto-presenter](https://github.com/laravel-auto-presenter/laravel-auto-presenter) for the basic use cases.

With this package, instead of altering your models to implement `HasPresenter`, you can define the presenters in a service
 provider using the facade. For example:

```php
public function register()
{
    \Presenters::map(User::class, UserPresenter::class);
}
```

This will work exactly how the laravel-auto-presenter works; any `User` models passed to a view will be wrapped in `UserPresenter`.

The `map` function also takes an array:

```php
public function register()
{
    \Presenters::map([
        User::class => UserPresenter::class,
        ...
    ]);
}
```

If you wish to declare a mapping on-the-fly, or override a mapping in a specific instance,
the facade can be called from anywhere:

```php
public function show(User $user)
{
    \Presenters::map(User::class, UserJSONPresenter::class);
    ...
}
```

### Decoratable

To mimic the `Decoratable` interface of the parent package, you can call `decoratable`:

```php
public function register()
{
    \Presenters::decorate(User::class);
    \Presenters::decorate([
        User::class,
        ...
    ]);
    ...
}
```

## License

Laravel Auto Presenter Mapper is licensed under [The MIT License (MIT)](LICENSE).
