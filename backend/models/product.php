<?php
class Product {
    private $conn;
    private $table = "products";

    public $id;
    public $name;
    public $brand;
    public $category;
    public $shade;
    public $skin;
    public $expiry;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO $this->table
        SET name=:name, brand=:brand, category=:category,
            shade=:shade, skin=:skin, expiry=:expiry, quantity=:quantity";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ":name"=>$this->name,
            ":brand"=>$this->brand,
            ":category"=>$this->category,
            ":shade"=>$this->shade,
            ":skin"=>$this->skin,
            ":expiry"=>$this->expiry,
            ":quantity"=>$this->quantity
        ]);
    }

    public function read() {
        $stmt = $this->conn->query("SELECT * FROM $this->table ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alerts(){
    $stmt = $this->conn->query("
        SELECT * FROM products
        WHERE quantity < 5 OR expiry < CURDATE()
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>