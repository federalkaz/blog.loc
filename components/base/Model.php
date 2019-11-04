<?php


abstract class Model
{
    protected $connection;
    protected $table;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

}