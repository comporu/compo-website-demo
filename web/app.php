<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__ . '/../app/autoload.php';

if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__ . '/../.env');
}

$env = 'prod';
$debug = false;

if ($debug) {
    umask(0000);

    Debug::enable();
}

/** @noinspection PhpUndefinedClassInspection */
$kernel = new AppKernel($env, $debug);

//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//\Symfony\Component\HttpFoundation\Request::enableHttpMethodParameterOverride();

$request = Sonata\PageBundle\Request\RequestFactory::createFromGlobals('host');

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
