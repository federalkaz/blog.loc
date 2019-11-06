<?php


class PostController
{
    public function __construct()
    {
        echo 'PostController ---> __construct()';
    }

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
}