<?php
class CourseModel {
    private $db;

    public function __construct() {
        $this->db = new Database(); 
    }

    public function getAllCourses() {
        $this->db->query("SELECT * FROM courses ORDER BY course_id DESC");
        return $this->db->resultSet();
    }

    public function getCoursesByCategoryId($categoryId) {
        $this->db->query("SELECT * FROM courses WHERE category_id = ? ORDER BY course_id DESC");
        $this->db->bind(1, (int) $categoryId, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query("SELECT category_id, category_name, slug, description FROM categories ORDER BY category_name ASC");
        return $this->db->resultSet();
    }
    // slug SEO
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
    // bind param id 
    public function getCourseById($id) {
        $this->db->query("SELECT * FROM courses WHERE course_id = ?");
        $this->db->bind(1, (int) $id, PDO::PARAM_INT);
        return $this->db->single();
    }
}