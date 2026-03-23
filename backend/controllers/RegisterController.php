<?php
require_once '../config/Database.php';
require_once '../models/User.php'; // à créer

class RegisterController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    public function register($data) {
        // Validation des champs obligatoires
        if (empty($data->name) || empty($data->email) || empty($data->password) || empty($data->confirm_password)) {
            return ['success' => false, 'message' => 'Tous les champs sont requis'];
        }

        if ($data->password !== $data->confirm_password) {
            return ['success' => false, 'message' => 'Les mots de passe ne correspondent pas'];
        }

        if (strlen($data->password) < 8) {
            return ['success' => false, 'message' => 'Le mot de passe doit contenir au moins 8 caractères'];
        }

        // Vérifier si l'email existe déjà
        if ($this->user->emailExists($data->email)) {
            return ['success' => false, 'message' => 'Cet email est déjà utilisé'];
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);

        // Assigner les propriétés
        $this->user->name = $data->name;
        $this->user->email = $data->email;
        $this->user->password = $hashedPassword;
        $this->user->role = $data->role ?? 'user'; // par défaut 'user'
        // shop_id sera défini après création de la boutique, ou on peut créer une boutique vide
        $this->user->shop_id = null; // ou 0

        // Appeler la méthode create du modèle
        if ($this->user->create()) {
            // Optionnel : créer automatiquement une boutique pour l'utilisateur
            return ['success' => true, 'message' => 'Inscription réussie', 'user_id' => $this->user->id];
        } else {
            return ['success' => false, 'message' => 'Erreur lors de l\'inscription'];
        }
    }
}