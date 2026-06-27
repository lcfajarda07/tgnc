<?php

$tmpPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
$frameworkPath = $tmpPath.'/framework';

foreach ([
    $frameworkPath.'/views',
    $frameworkPath.'/cache',
    $frameworkPath.'/sessions',
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

$serverlessEnvironment = [
    'VIEW_COMPILED_PATH' => $frameworkPath.'/views',
    'APP_CONFIG_CACHE' => $frameworkPath.'/cache/config.php',
    'APP_EVENTS_CACHE' => $frameworkPath.'/cache/events.php',
    'APP_PACKAGES_CACHE' => $frameworkPath.'/cache/packages.php',
    'APP_ROUTES_CACHE' => $frameworkPath.'/cache/routes.php',
    'APP_SERVICES_CACHE' => $frameworkPath.'/cache/services.php',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($serverlessEnvironment as $key => $value) {
    if (getenv($key) === false) {
        putenv($key.'='.$value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

require __DIR__.'/../public/index.php';
