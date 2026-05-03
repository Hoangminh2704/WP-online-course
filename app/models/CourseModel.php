<?php
class CourseModel {
    private $db;

    public function __construct() {
        // Gọi class Database ở file core/Database.php mà bạn đã tạo hôm qua
        $this->db = new Database(); 
    }

    // Hàm lấy toàn bộ khóa học
    public function getAllCourses() {
        $this->db->query("SELECT * FROM courses ORDER BY course_id DESC");
        return $this->db->resultSet();
    }
    // Thêm hàm này vào class Course trong app/models/Course.php
    public function getCourseBySlug($slug) {
        $sql = "SELECT c.*,
                    cat.category_name,
                    l.location_name, l.address, l.map_link
                FROM courses c
                LEFT JOIN categories cat ON c.category_id = cat.category_id
                LEFT JOIN locations l ON c.location_id = l.location_id
                WHERE c.slug = :slug";

        $this->db->query($sql);
        $this->db->bind(':slug', $slug);

        return $this->db->single();
    }
}