<?php

class Database
{
    private $di;
    private $pdo;
    private $stmt;

    private $debug;
    private $config;
    private $host;
    private $username;
    private $password;
    private $db;

    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->config = $this->di->get('config');
        $this->debug = $this->config->get('debug');
        $this->host = $this->config->get('host');
        $this->username = $this->config->get('username');
        $this->password = $this->config->get('password');
        $this->db = $this->config->get('db');

        $this->connectDB();
    }

    private function connectDB()
    {
        try
        {
            // echo "Connecting to DB";
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);

            if($this->debug)
            {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }
        catch(PDOException $e)
        {
            die($this->debug ? $e->getMessage() : "Error While performing something!");
        }
    }

    public function raw(string $sql, $mode = PDO::FETCH_OBJ)
    {
        return $this->pdo->query($sql)->fetchAll($mode);
    }

    public function query(string $sql)
    {
        return $this->pdo->query($sql);
    }

    /**
     * Function inserts $data in $table and returns the insert id of the record.
     * The insert id is actually returned so that it can be used for the linking tables.
     */
    public function insert(string $table, $data)
    {
        $keys = array_keys($data);
        $fields = "`" . implode("`, `", $keys). "`";

        $placeholders = ":" .implode(", :", $keys);

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $this->stmt = $this->pdo->prepare($sql);

        $this->stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function readData($table, $fields = [], $condition = "1", $readMode = PDO::FETCH_OBJ)
    {
        if(count($fields) == 0)
        {
            $columnNameString = "*";
        }
        else
        {
            $columnNameString = implode(", ", $fields);
        }
        $sql = "SELECT {$columnNameString} FROM {$table} WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        return $this->stmt->fetchAll($readMode);
    }

    public function hardDelete($table, $condition)
    {
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }
    public function delete($table, $condition)
    {
        $sql = "UPDATE {$table} SET deleted = 1 WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    public function update($table, $data, $condition = "1")
    {
        $columnKeyValue = "";
        $i = 0;
        foreach($data as $key=>$value)
        {
            $columnKeyValue .= "$key = :$key";
            $i++;
            if($i < count($data))
            {
                $columnKeyValue .= ", ";
            }
        }
        $sql = "UPDATE {$table} SET {$columnKeyValue} WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($data);
        return $this;
    }

    public function exists($table, $data)
    {
        $field = array_keys($data)[0];

        $result = $this->readData($table, [], "{$field} = '{$data[$field]}'", PDO::FETCH_ASSOC);
        if(count($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function existsExceptCurrent($table, $id, $data)
    {
        $field = array_keys($data)[0];

        $result = $this->readData($table, [], "{$field} = '{$data[$field]}' AND id != $id", PDO::FETCH_ASSOC);
        if(count($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollback()
    {
        return $this->pdo->rollback();
    }
}

?>