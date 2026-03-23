<?php
class Sale {
    private $conn;
    private $table = "sales";

    public $product_id;
    public $client_id;
    public $quantity;
    public $total;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {

        // Ajouter vente
        $query = "INSERT INTO $this->table
        SET product_id=:product_id, client_id=:client_id,
            quantity=:quantity, total=:total";

        $stmt = $this->conn->prepare($query);

        $success = $stmt->execute([
            ":product_id"=>$this->product_id,
            ":client_id"=>$this->client_id,
            ":quantity"=>$this->quantity,
            ":total"=>$this->total
        ]);

        if($success){
            // réduire stock
            $update = "UPDATE products SET quantity = quantity - :q WHERE id=:id";
            $stmt2 = $this->conn->prepare($update);
            $stmt2->execute([
                ":q"=>$this->quantity,
                ":id"=>$this->product_id
            ]);

            // ajouter points fidélité
            $points = floor($this->total / 1000);
            $updateClient = "UPDATE clients SET points = points + :p WHERE id=:id";
            $stmt3 = $this->conn->prepare($updateClient);
            $stmt3->execute([
                ":p"=>$points,
                ":id"=>$this->client_id
            ]);
        }

        return $success;
    }
}
?>