<?php

namespace controllers;

class MainController extends App
{

    public function actionIndex()
    {
        //echo 'MainController -> actionIndex()';
        $name = 'Имя';
        $this->set(['name' => $name, 'title' => 'Заголовок']);
    }
}