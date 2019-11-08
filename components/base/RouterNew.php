<?php

namespace components\base;

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
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    // Функция для перенаправления URI по корректному маршруту
    public static function dispatch(string $uri)
    {
        $uri = self::removeQuerystring($uri);
        if (self::searchRoute($uri)) {
            //$controller = 'controllers\\' . self::upperCamelCase(self::$route['controller']).'Controller';
            $controller = 'controllers\\' . self::$route['controller'].'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                echo '<pre>';
                echo var_dump(self::$route);
                echo '</pre>';
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
    // Функция обрезает явные GET-параметры оставляя только неявный
    protected static function removeQuerystring($uri)
    {
        if ($uri) {
            $params = explode('?', $uri);
            if (strpos($params[0], '=') === false) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }

        return $uri;
    }
}