# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [v1.x.x] - YYYY-MM-DD

## [v1.7.1] - 2022-05-04

- Fix detection of `Retry-After` header in ServerResponseException class and phpdoc

## [v1.7.0] - 2022-03-11

- Make topics more extendable and fix topicsToFcm
- Support laravel `9`
- Drop support for Laravel `5.{1,2,3,4,5}`
- Set the minium PHP version allowed to `7.1.3` like Laravel `5.6`
- Improve phpdoc blocs for easier phpstan analysis

## [v1.6.2] - 2021-04-03

- Set FCMManager::getContainer public

## [v1.6.1]

- Fix PHP 8.0 support

## [v1.6.0]

- Support laravel 8
- Support `illuminate/support` 8
- Support `guzzlehttp/guzzle` 7
- Add support for setDirectBootOk on OptionsBuilder
- Mark setDryRun as deprecated v1 FCM on OptionsBuilder
- Add Topics Creation And Subscription
- Drop dev dependency `mockery/mockery`
- Update rendered documentation
- Exclude `doc` folder from composer tarballs
- Add support for fcmOptions (#3)

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
