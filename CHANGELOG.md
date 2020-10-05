# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [v1.x.x]

- Support laravel 8
- Support `illuminate/support` 8
- Support `guzzlehttp/guzzle` 7
- Add support for setDirectBootOk on OptionsBuilder
- Mark setDryRun as deprecated v1 FCM on OptionsBuilder
- Add Topics Creation And Subscription

## [v1.5.0]

- Add support for images on PayloadNotificationBuilder
- Fix phpdoc errors reported on phpstan level 2 and 3
- Add logger injection

## [v1.4.0]

- Support laravel 7
- Re-write ci to use GitHub actions
- Update package to @code-lts
- Replace coveralls by codecov
- Remove composer lock file
- Make test suite run from phpunit 5 to 9
- Update README.md
- Add a CHANGELOG.md
- Add a `.gitattributes` file

## [v1.3.1]

- Allow `monolog/monolog:^2.0`

## [v1.3.0]

- Support laravel 6
- Use `Illuminate\Support\Str` functions instead of helpers
- Improve the README.md
