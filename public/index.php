<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Session\Adapter\Files;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Security;

include '../app/config/module.php';
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
// ...



$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/config/',
        APP_PATH . '/helpers/',
        APP_PATH . '/forms/',
    ]
);

$loader->register();


// Create a DI
$container = new FactoryDefault();

// View
$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);

// Url
$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);

// Database
$container->set(
    'db',
    function () {
        return new Postgresql(
            [
                'host'     => "db",
                'port'     => "5432",
                'username' => 'root', // Change it to your database username
                'password' => 'db_password', // Change it to your database password
                'dbname'   => 'db_name', // Change it to your database name
            ]
        );
    }
);

// Router
$container->set('router', function() {
    $router = new Router();
    $router->mount(new Routes());
    return $router;
});

// Session
$container->setShared('session', function() {
    $session = new Files();
    $session->start();
    return $session;
});

// Custom dispatcher (Overrides the default)
$container->set('dispatcher', function () use ($container) {
    $eventsManager = $container->getShared('eventsManager');

    // Custom ACL class
    $permission = new Permission();

    // Listen for events from the permission class
    $eventsManager->attach('dispatch', $permission);

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);
    return $dispatcher;
});

// Flash messages
$container->set('flash', function () {
        $flash = new FlashDirect(
            [
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ]
        );
        return $flash;
    }
);

// Set up the flash session service
$container->set(
    'flashSession',
    function () {
        return new FlashSession(
            [
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ]
        );
    }
);

$container->set(
    'security',
    function () {
        $security = new Security();

        $security->setWorkFactor(12);

        return $security;
    },
    true
);

// Handle the application
$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
}
catch (Exception $exception)
{
    echo 'Error: '.$exception->getMessage();
}
