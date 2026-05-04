<?php
class SearchController extends Controller {
    /**
     * AJAX endpoint: /search/suggest?q=keyword
     * Returns JSON array of matching courses
     */
    public function suggest() {
        header('Content-Type: application/json');

        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($q) < 1) {
            echo json_encode(['results' => []]);
            return;
        }

        $searchModel = $this->model('SearchModel');
        $results = $searchModel->searchCourses($q);

        echo json_encode(['results' => $results]);
    }
}
