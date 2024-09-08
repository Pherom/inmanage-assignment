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

    public function select(string $table, array $columns = ["*"], array $conditions = [])
    {
        if ($this->connected()) {
            $strColumns = implode(", ", $columns);
            $query = "SELECT $strColumns FROM $table";
            if (!empty($conditions)) {
                $strConditions = implode(" AND ", $conditions);
                $query .= " WHERE $strConditions";
            }
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Please connect to database first.";
        }
    }

    public function insert(string $table, array $data)
    {
        if ($this->connected()) {
            $strColumns = implode(", ", array_keys($data));
            $strPlaceholders = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO $table ($strColumns) VALUES ($strPlaceholders)";
            $stmt = $this->conn->prepare($query);
            foreach (array_keys($data) as $key) {
                $stmt->bindValue(":$key", $data[$key]);
            }
            $stmt->execute();
        } else {
            echo "Please connect to database first.";
        }
    }
}
