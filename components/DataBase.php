<?php


class DataBase
{
    protected $connection;
    protected static $instance;

    protected function __construct()
    {
        $db = require_once ROOT . '/config/config_db.php';
        try {
            // Создаём новый объект PDO для подключения к базе данных
            $this->connection = new \PDO($db['dsn'], $db['user'], $db['pass']);
        } catch (PDOException $error) {
            // В случае невозможности подключения, выводим сообщение об ошибке
            echo 'Невозможно произвести подключение к серверу базы данных!' . PHP_EOL;
            die($error->getMessage());
        }
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

    public  function execute($sql)
    {
        $res = $this->connection->prepare($sql);
        return $res->execute($_REQUEST);
    }

    public function query($sql)
    {
        $res = $this->execute($sql);
        if ($res !== false) {
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
}