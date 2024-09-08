<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "inmanage-assignment-db";
    private $conn;

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
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Failed to connect to database: " . $e->getMessage();
        }
    }

    public function connected()
    {
        return isset($conn);
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
}
