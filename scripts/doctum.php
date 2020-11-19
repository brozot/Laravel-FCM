<?php

use Doctum\Doctum;
use Doctum\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$dir = realpath(__DIR__ . '/../src');
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir);

return new Doctum($iterator, [
    'theme'                => 'markdown',
    'template_dirs'        => [__DIR__ . '/doctum-themes'],
    'title'                => 'Laravel / Lumen package for Firebase Cloud Messaging',
    'build_dir'            => __DIR__ . '/../doc/',
    'cache_dir'            => __DIR__ . '/../build/cache/',
    'remote_repository'    => new GitHubRemoteRepository('code-lts/Laravel-FCM', realpath($dir . '/../')),
]);
