<?php
class CartModel {

    
    public function getCart() {
        return $_SESSION['cart'] ?? [];
    }

    public function addToCart($courseId) {
        $courseId = (int) $courseId;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!in_array($courseId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $courseId;
        }
    }

    public function removeFromCart($courseId) {
        $courseId = (int) $courseId;
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_values(array_filter(
                $_SESSION['cart'],
                fn($id) => $id !== $courseId
            ));
        }
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    
    public function isInCart($courseId) {
        return in_array((int) $courseId, $this->getCart());
    }

    public function count() {
        return count($this->getCart());
    }

    public function getCartWithDetails() {
        if (empty($this->getCart())) {
            return [];
        }
        $db = new Database();
        $placeholders = implode(',', array_fill(0, count($this->getCart()), '?'));
        $db->query("SELECT * FROM courses WHERE course_id IN ($placeholders)");
        foreach ($this->getCart() as $i => $id) {
            $db->bind($i + 1, $id, PDO::PARAM_INT);
        }
        return $db->resultSet();
    }
}
