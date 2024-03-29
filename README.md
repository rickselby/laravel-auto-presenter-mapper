Laravel Auto Presenter Mapper
=============================

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
![Packagist Version](https://img.shields.io/packagist/v/rickselby/laravel-auto-presenter-mapper)

This is an extension to the excellent [laravel-auto-presenter](https://github.com/laravel-auto-presenter/laravel-auto-presenter)
that allows you to define presenters in a service provider or on-the-fly, rather than directly on the model.

## Compatibility Chart

| Laravel Auto Presenter Mapper                                              | `laravel-auto-presenter` |
|----------------------------------------------------------------------------|--------------------------|
| **3.x**                                                                    | 7.x                      |
| [2.x](https://github.com/rickselby/laravel-auto-presenter-mapper/tree/2.x) | 6.x                      |
| [1.x](https://github.com/rickselby/laravel-auto-presenter-mapper/tree/1.x) | 5.x                      |

## Installing

Require the project using [Composer](https://getcomposer.org):

```bash
$ composer require rickselby/laravel-auto-presenter-mapper
```

Laravel 5.5+ will auto-discover the package.

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
