# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.0.1] - 2018-05-14
### Fixed
- Fix passing an array of classes to `decorate`

## [3.0.0] - 2018-05-12
### Changed
- Supports `laravel-auto-presenter/laravel-auto-presenter` 7.x

## [2.2.1] - 2018-05-14
### Fixed
- Fix passing an array of classes to `decorate` (backported from 3.0.1)

## [2.2.0] - 2018-05-12
### Added
- Add `decorate` to mark a class as decoratable 
  (mimicing the `Decoratable` interface of `laravel-auto-presenter/laravel-auto-presenter`)

## [2.1.0] - 2017-10-27
### Added
- Remove a presenter from the mapping with `remove`

## [2.0.1] - 2017-09-29
### Fixed
- Exclude `laravel-auto-presenter/laravel-auto-presenter` from automatic discovery in Laravel 5.5+ 

## [2.0.0] - 2017-09-23
### Changed
- Supports `laravel-auto-presenter/laravel-auto-presenter` 6.x

## [1.1.0] - 2017-05-06
### Changed
- The `map` function now accepts an array of presenters, keyed by model

## [1.0.0] - 2017-03-03
### Added
- Add a decorator for `laravel-auto-presenter/laravel-auto-presenter` that loads presenters from a service provider
- Add a facade for defining or overriding presenters on the fly
