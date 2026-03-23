<?php
class Client {
    private $conn;
    private $table = "clients";

    public $id;
    public $name;
    public $phone;
    public $skin_type;
    public $points;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO $this->table
        SET name=:name, phone=:phone, skin_type=:skin_type, points=0";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ":name"=>$this->name,
            ":phone"=>$this->phone,
            ":skin_type"=>$this->skin_type
        ]);
    }

    public function read() {
        $stmt = $this->conn->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>