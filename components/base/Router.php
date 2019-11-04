<?php


class Router
{
    // Массив с маршрутами
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include "$routesPath";
    }

    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        // Получаем строку запроса
        $uri = $this->getURI();

        // Проверяем наличие такого маршрута в routes.php
        foreach ($this->routes as $uriPattern => $path) {


            // сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {
                // получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // определяем какой контроллер и action обрабатывают запрос
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // подключаем файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once "$controllerFile";
                }

                //Создаём объект и вызываем метод
                $controllerObject = new $controllerName;
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);
                if ($result != null) {
                    break;
                }
            }
        }
    }
}