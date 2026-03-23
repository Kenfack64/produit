<?php
require_once '../models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($this->db);
    }

    /**
     * Tente de connecter un utilisateur
     * @param object $data {email, password}
     * @return array ['success' => bool, 'message' => string, 'user' => array|null]
     */
    public function login($data) {
        if (empty($data->email) || empty($data->password)) {
            return ['success' => false, 'message' => 'Email et mot de passe requis'];
        }

        $user = $this->userModel->findByEmail($data->email);

        if ($user && password_verify($data->password, $user['password'])) {
            // Stocker l'utilisateur en session
            session_start();
            $_SESSION['user'] = $user;
            return [
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']]
            ];
        } else {
            return ['success' => false, 'message' => 'Email ou mot de passe incorrect'];
        }
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Déconnexion réussie'];
    }

    /**
     * Vérifie si l'utilisateur est connecté
     */
    public function checkAuth() {
        session_start();
        if (isset($_SESSION['user'])) {
            return ['success' => true, 'user' => $_SESSION['user']];
        }
        return ['success' => false, 'message' => 'Non authentifié'];
    }
}