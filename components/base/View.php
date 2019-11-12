<?php


namespace components\base;


class View
{
    // текущий маршрту и параметры (controller, action , params)
    public $route = [];
    // текущий вид
    public $view;
    // текущий шаблон
    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($vars)
    {
        if (is_array($vars)) extract($vars);
        $file_view = ROOT . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if (file_exists($file_view)) {
            require  $file_view;
        } else {
            echo "<p>Не найден вид <b>{$file_view}</b></p>";
        }
        $content = ob_get_clean();

        $file_layout = ROOT . "/views/layouts/{$this->layout}.php";
        if (file_exists($file_layout)) {
            require $file_layout;
        } else {
            echo "<p>Не найден шаблон <b>{$file_layout}</b></p>";
        }
    }
}