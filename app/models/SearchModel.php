<?php
class SearchModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    
    public function searchCourses($keyword, $limit = 8) {
        $sql = "SELECT c.course_id, c.title, c.slug, c.price, c.instructor, c.image_url
                FROM courses c
                WHERE c.title LIKE ?
                   OR c.instructor LIKE ?
                ORDER BY c.title ASC
                LIMIT ?";

        $this->db->query($sql);
        $this->db->bind(1, '%' . $keyword . '%');
        $this->db->bind(2, '%' . $keyword . '%');
        $this->db->bind(3, (int) $limit, PDO::PARAM_INT);

        $rows = $this->db->resultSet();

        // Format
        $results = [];
        foreach ($rows as $row) {
            $results[] = [
                'title' => $row['title'],
                'url' => BASE_URL . '/courses/detail/' . $row['slug'],
                'price' => $row['price'],
                'instructor' => $row['instructor'] ?? ''
            ];
        }

        return $results;
    }
}
