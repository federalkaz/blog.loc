<?php


namespace components;


class DataBase
{
    protected $pdo;
    protected static $instance;

    protected function __construct()
    {
        $db = require_once ROOT . '/config/config_db.php';
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
    }

    private function __clone () {}
    private function __wakeup () {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}