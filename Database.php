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

    public function select(string $table, array $columns = ["*"], array $conditions = [])
    {
        if (isset($conn)) {
            $strColumns = implode(", ", $columns);
            $query = "SELECT $strColumns FROM $table";
            if (!empty($conditions)) {
                $strConditions = implode(" AND ", $conditions);
                $query .= " WHERE $strConditions";
            }
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Please connect to database first.";
        }
    }
}
