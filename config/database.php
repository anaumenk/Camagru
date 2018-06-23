<?php
use PDO;
class Db {
    protected $db;

    public function __construct() {
        $DB_DSN = "mysql:host=localhost; dbname=camagru";
        $DB_USER = "root";
        $DB_PASSWORD = "fktrcfylhf";
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
