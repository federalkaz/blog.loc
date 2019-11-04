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

    // Запись
    public function setContent(string $table, array $data)
    {
        // Подготавливаем SQL-запрос
        $sql = "INSERT INTO `{$table}` (`id`,";
        // заполняем запрос полями которые должны быть в таблице БД
        foreach ($data as $field => $value) {
            $sql .= " `{$field}`,";
        }
        // убираем лишнюю запятую в конце последнего поля
        $sql = rtrim($sql, ',');
        // продолжаем подготовку SQL-запроса
        $sql .= ") VALUES (NULL,";
        // заполняем запрос значениями которые будут записываться в БД
        foreach ($data as $field => $value) {
            // отслеживаем последнюю итерацию
            if (next($data)) {
                $sql .= " :{$field}, ";
            } else {
                // как только отследили - записываем в другом формате, т.к. её значение будет заполняться не через $_REQUEST
                $sql .= " {$value}";
            }
        }
        $sql .= ")";
        try {
            $statement = $this->connection->prepare($sql);
            // Выполняем запрос
            $statement->execute($_REQUEST);
        } catch (PDOException $error) {
            // В случае ошибки - выводим сообщение
            echo 'Невозможно произвести запись данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }

    // Чтение
    public function getAllContent(string $table, $orderByField = 'id', $orderByParam = 'DESC', $where = '1') : array
    {
        // Подготовим SQL-запрос
        $sql = "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderByField} {$orderByParam}";
        $statement = $this->connection->prepare($sql);
        // Выполняем его
        $statement->execute();
        // Получаем набор данных
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        // И возвращаем
        return $data;
    }

    public function getLimitContent(string $table, string $orderByField = 'id', string $orderByParam = 'DESC', $where = '1', $start = 0, $numResourcePerPage = 5) : array
    {
        $sql = "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderByField} {$orderByParam} LIMIT {$start}, {$numResourcePerPage}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Обновление
    public function updateContent(string $table, array $data)
    {
        $sql = "UPDATE `{$table}` SET ";
        foreach ($data as $field => $value) {
            $sql .= "`{$field}` = :{$field}, ";
        }
        $sql = rtrim($sql, ' ,');
        $sql .= " WHERE `id` = :id";
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute($_REQUEST);
        } catch (PDOException $error) {
            echo 'Невозможно произвести обновление данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }

    // Удаление
    public function deleteContent(string $table)
    {
        // Подготавливаем SQL-запрос
        $sql = "DELETE FROM `{$table}` WHERE `id` = :id";
        try {
            $statement = $this->connection->prepare($sql);
            // Выполняем запрос к БД
            $statement->execute($_REQUEST);
        } catch (PDOException $error) {
            // В случае ошибки выводим сообщение
            echo 'Невозможно произвести удаление данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }
}