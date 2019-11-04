<?php
// Определяем корневой путь входной точки и записываем его в константу
define('ROOT', dirname(__FILE__));
// подключаем базу данных
require_once ROOT . '/components/DataBase.php';


// Подключаем компонент "Роутер"
require_once(ROOT . '/components/base/Router.php');

// Запускаем Роутер
$router = new Router();
$router->run();
