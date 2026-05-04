<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    
    public function findByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = ?");
        $this->db->bind(1, $email);
        return $this->db->single();
    }

    
    public function findById($id) {
        $this->db->query("SELECT user_id, full_name, email, role, created_at FROM users WHERE user_id = ?");
        $this->db->bind(1, (int) $id, PDO::PARAM_INT);
        return $this->db->single();
    }

    public function create($fullName, $email, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query(
            "INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'student')"
        );
        $this->db->bind(1, $fullName);
        $this->db->bind(2, $email);
        $this->db->bind(3, $hash);
        return $this->db->execute();
    }

    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        if (!$user) return false;
        return password_verify($password, $user['password_hash']);
    }


    public function emailExists($email) {
        $this->db->query("SELECT user_id FROM users WHERE email = ?");
        $this->db->bind(1, $email);
        return $this->db->single() !== false;
    }
}
