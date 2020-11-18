<?php

use Doctum\Doctum;
use Symfony\Component\Finder\Finder;

$dir = __DIR__ . '/../src';
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
]);
