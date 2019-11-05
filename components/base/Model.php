<?php


abstract class Model
{
    protected $connection;
    protected $table;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

    ///////////////////////////////////////////////////////////////////////////////
    /// CRUD///////////////////////////////////////////////////////////////////////
    /// ///////////////////////////////////////////////////////////////////////////
    /// Create
    public function create(string $table, array $data)
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
            // Выполняем запрос
            /*
            $statement = $this->connection->prepare($sql);
            $statement->execute($_REQUEST);
            */
            $this->connection->execute($sql);
        } catch (PDOException $error) {
            // В случае ошибки - выводим сообщение
            echo 'Невозможно произвести запись данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }

    /// Read
    public function readAll(string $table, $orderByField = 'id', $orderByParam = 'DESC', $where = '1'): array
    {
        // Подготовим SQL-запрос
        $sql = "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderByField} {$orderByParam}";
        // Выполняем его и получаем набор данных
        /*
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        */
        $data = $this->connection->query($sql);
        // И возвращаем
        return $data;
    }

    public function readById(string $table, string $orderByField = 'id', string $orderByParam = 'DESC', $where = '1', $start = 0, $numResourcePerPage = 5): array
    {
        $sql = "SELECT * FROM {$table} WHERE {$where} ORDER BY {$orderByField} {$orderByParam} LIMIT {$start}, {$numResourcePerPage}";
        /*
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        */
        $data = $this->connection->query($sql);
        return $data;
    }

    /// Update
    public function update(string $table, array $data)
    {
        $sql = "UPDATE `{$table}` SET ";
        foreach ($data as $field => $value) {
            $sql .= "`{$field}` = :{$field}, ";
        }
        $sql = rtrim($sql, ' ,');
        $sql .= " WHERE `id` = :id";
        try {
            /*
            $statement = $this->connection->prepare($sql);
            $statement->execute($_REQUEST);
            */
            $this->connection->execute($sql);
        } catch (PDOException $error) {
            echo 'Невозможно произвести обновление данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }

    ///Delete
    public function delete(string $table)
    {
        // Подготавливаем SQL-запрос
        $sql = "DELETE FROM `{$table}` WHERE `id` = :id";
        try {
            /*
            $statement = $this->connection->prepare($sql);
            $statement->execute($_REQUEST);
            */
            $this->connection->execute($sql);
        } catch (PDOException $error) {
            // В случае ошибки выводим сообщение
            echo 'Невозможно произвести удаление данных!' . PHP_EOL;
            die($error->getMessage());
        }
    }
}