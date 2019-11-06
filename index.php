<?php
// Определяем корневой путь входной точки и записываем его в константу
define('ROOT', dirname(__FILE__));

$uri = ltrim($_SERVER['REQUEST_URI'], '/');

require_once ROOT . '/components/base/RouterNew.php';

// Функция автозагрузки классов-контроллеров
spl_autoload_register(function ($class){
    $file = ROOT . "/controllers/$class.php";
    if (is_file($file)) {
        require_once $file;
    }
});

RouterNew::setRoutes('^pages/?(?P<action>[a-z-]+)?$', ['controller' => 'Post']);

// Правила по умолчанию
RouterNew::setRoutes('^$', ['controller' => 'Main', 'action' => 'index']);
RouterNew::setRoutes('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

RouterNew::dispatch($uri);
