<?php


namespace controllers;


use components\base\Controller;

class PageController extends Controller
{

    public function actionView()
    {
        echo 'PageController::View';
        echo '<pre>';
        echo var_dump($this->route);
        echo '</pre>';
        echo '<pre>';
        echo var_dump($_REQUEST);
        echo '</pre>';
    }
}