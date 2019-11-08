<?php

namespace controllers;

class MainController
{
    public function __construct()
    {
        echo 'MainController ---> __construct()';
    }

    public function actionIndex()
    {
        echo 'MainController -> actionIndex()';
    }
}