<?php


class RouterNew
{
    // Массив со всеми маршрутами
    protected static $routes = [];
    // Массив с текущим маршрутом вызываемым в URL-адресе
    protected static $route = [];


    // Функция добавления маршрутов
    public static function setRoutes(string $regexp, $route = []): void
    {
        // заполняем массив значениями
        self::$routes[$regexp] = $route;
    }
    // Функция получения всех маршрутов
    public static function getRoutes(): array
    {
        return self::$routes;
    }
    // Функция получения текущего маршрута вызываемого в URL-адресе
    public static function getRoute(): array
    {
        return self::$route;
    }
    // Функция поиска вызываемого маршрута в URL-адресе в списке всех маршрутов
    public static function searchRoute(string $uri)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("~$pattern~i", $uri, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    // Функция для перенаправления URI по корректному маршруту
    public static function dispatch(string $uri)
    {
        if (self::searchRoute($uri)) {
            $controller = self::upperCamelCase(self::$route['controller']).'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller;
                $action = 'action' . self::upperCamelCase(self::$route['action']);
                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                } else {
                    echo "<br>Метод <b>$controller::$action</b> не найден!";
                }
            } else {
                echo "Контроллер <b>{$controller}</b> не найден!";
            }
        } else {
            http_response_code(404);
            include ROOT . '/views/404.html';
        }
    }
    // Функция для правильного преобразования имён классов из URI (post-manager в PostManager)
    protected static function upperCamelCase(string $name): string
    {
        return preg_replace("/ /", "", ucwords(str_replace('-', ' ', $name)));
    }
}