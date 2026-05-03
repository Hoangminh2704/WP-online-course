<?php
class CartModel {

    /**
     * Lấy giỏ hàng từ session
     */
    public function getCart() {
        return $_SESSION['cart'] ?? [];
    }

    /**
     * Thêm khóa học vào giỏ hàng
     */
    public function addToCart($courseId) {
        $courseId = (int) $courseId;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!in_array($courseId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $courseId;
        }
    }

    /**
     * Xóa khóa học khỏi giỏ hàng
     */
    public function removeFromCart($courseId) {
        $courseId = (int) $courseId;
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_values(array_filter(
                $_SESSION['cart'],
                fn($id) => $id !== $courseId
            ));
        }
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    /**
     * Kiểm tra khóa học có trong giỏ hàng không
     */
    public function isInCart($courseId) {
        return in_array((int) $courseId, $this->getCart());
    }

    /**
     * Đếm số khóa học trong giỏ
     */
    public function count() {
        return count($this->getCart());
    }

    /**
     * Lấy thông tin khóa học trong giỏ hàng
     */
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
