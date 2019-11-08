<?php

namespace controllers;


use components\base\Controller;

class PostController extends Controller
{

    public function actionIndex()
    {
        echo 'PostController -> actionIndex()';
    }

    public function actionView($category, $id, $parameter1)
    {
        echo 'PostController -> actionView()';
        echo '<br>' . $category;
        echo '<br>' . $id;
        echo '<br>' . $parameter1;
    }

    public function actionCreate()
    {
        echo '<pre>';
        var_dump($this->route);
        echo '</pre>';
    }
}