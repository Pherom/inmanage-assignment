<?php
include("config.php");

class Database
{
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;
    private $conn = null;

    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Failed to connect to database: " . $e->getMessage();
        }
    }

    public function connected()
    {
        return isset($this->conn);
    }

    private function bindValues(PDOStatement $stmt, array $data)
    {
        foreach (array_keys($data) as $key) {
            $stmt->bindValue(":$key", $data[$key]);
        }
    }

    private function addConditionsToQuery(string $query, array $conditions)
    {
        if (!empty($conditions)) {
            $strConditions = implode(" AND ", $conditions);
            $query .= " WHERE $strConditions";
        }
        return $query;
    }

    private function generateSetString(array $data)
    {
        $setInstructions = array();
        foreach (array_keys($data) as $key) {
            array_push($setInstructions, "$key = :$key");
        }
        return implode(", ", $setInstructions);
    }

    private function generateSchemaString(array $columns, array $constraints)
    {
        $strSchema = "";
        foreach ($columns as $column) {
            $columnName = $column["name"];
            $columnDef = $column["definition"];
            $strSchema .= "$columnName $columnDef, ";
        }
        if (!empty($constraints)) {
            $strSchema .= implode($constraints);
        } else {
            $strSchema = rtrim($strSchema, ", ");
        }
        return $strSchema;
    }

    public function select(string $table, array $columns = ["*"], array $conditions = [])
    {
        $result = null;
        if ($this->connected()) {
            $strColumns = implode(", ", $columns);
            $query = "SELECT $strColumns FROM $table";
            $query = $this->addConditionsToQuery($query, $conditions);
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

    public function insert(string $table, array $data)
    {
        $result = false;
        if ($this->connected()) {
            $strColumns = implode(", ", array_keys($data));
            $strPlaceholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO $table ($strColumns) VALUES ($strPlaceholders)";
            $stmt = $this->conn->prepare($query);
            $this->bindValues($stmt, $data);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function update(string $table, array $data, array $conditions)
    {
        $result = false;
        if ($this->connected()) {
            $strSet = $this->generateSetString($data);
            $query = "UPDATE $table SET $strSet";
            $query = $this->addConditionsToQuery($query, $conditions);
            $stmt = $this->conn->prepare($query);
            $this->bindValues($stmt, $data);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function delete(string $table, array $conditions)
    {
        $result = false;
        if ($this->connected()) {
            $query = "DELETE FROM $table";
            $query = $this->addConditionsToQuery($query, $conditions);
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function createTable(string $table, array $columns, array $constraints)
    {
        $result = false;
        if ($this->connected()) {
            $strSchema = $this->generateSchemaString($columns, $constraints);
            $query = "CREATE TABLE IF NOT EXISTS $table ($strSchema)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute();
        }
        return $result;
    }

    public function tableExists(string $table)
    {
        $result = false;
        if ($this->connected()) {
            $query = "SELECT COUNT(*)
                      FROM information_schema.TABLES
                      WHERE TABLE_SCHEMA = '". DB_NAME ."'
                      AND TABLE_NAME = '$table'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchColumn() > 0;
        }
        return $result;
    }
}
