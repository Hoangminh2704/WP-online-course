<?php
class EnrollmentModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Kiểm tra user đã đăng ký khóa học chưa
     */
    public function isEnrolled($userId, $courseId) {
        $this->db->query("SELECT enrollment_id FROM enrollments WHERE user_id = ? AND course_id = ?");
        $this->db->bind(1, (int) $userId, PDO::PARAM_INT);
        $this->db->bind(2, (int) $courseId, PDO::PARAM_INT);
        return $this->db->single() !== false;
    }

    /**
     * Đăng ký khóa học (enroll)
     */
    public function enroll($userId, $courseId) {
        $this->db->query(
            "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)"
        );
        $this->db->bind(1, (int) $userId, PDO::PARAM_INT);
        $this->db->bind(2, (int) $courseId, PDO::PARAM_INT);
        return $this->db->execute();
    }

    /**
     * Lấy danh sách khóa học đã đăng ký của user
     */
    public function getEnrollmentsByUser($userId) {
        $this->db->query("
            SELECT e.*, c.title, c.image_url, c.price, c.instructor
            FROM enrollments e
            JOIN courses c ON e.course_id = c.course_id
            WHERE e.user_id = ?
            ORDER BY e.enrolled_at DESC
        ");
        $this->db->bind(1, (int) $userId, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    /**
     * Lấy danh sách course_id đã enroll (chỉ IDs)
     */
    public function getEnrolledCourseIds($userId) {
        $this->db->query("SELECT course_id FROM enrollments WHERE user_id = ?");
        $this->db->bind(1, (int) $userId, PDO::PARAM_INT);
        $rows = $this->db->resultSet();
        return array_column($rows, 'course_id');
    }
}
