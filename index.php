<?php
error_reporting(-1);

use components\base\RouterNew;

// Определяем корневой путь входной точки и записываем его в константу
define('ROOT', dirname(__FILE__));

$uri = ltrim($_SERVER['REQUEST_URI'], '/');

echo $uri;

// Функция автозагрузки классов-контроллеров
spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

RouterNew::setRoutes('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
RouterNew::setRoutes('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);
RouterNew::setRoutes('^pages/?(?P<action>[a-z-]+)?$', ['controller' => 'Post']);
// Правила по умолчанию
RouterNew::setRoutes('^$', ['controller' => 'Main', 'action' => 'index']);
RouterNew::setRoutes('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

RouterNew::dispatch($uri);
