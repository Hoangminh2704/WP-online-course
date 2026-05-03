<?php
class CoursesController extends Controller {
    public function index() {
        $courseModel = $this->model('CourseModel');

        // Lấy danh sách courses
        $courses = $courseModel->getAllCourses();

        // Gửi dữ liệu sang View
        $data = [
            'title' => 'Danh sách Khóa học - EduStream',
            'courses' => $courses
        ];

        $this->view('catalog/catalog', $data);
    }

    public function detail($slug = '') {
        if (empty($slug)) {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseBySlug($slug);

        if (!$course) {
            http_response_code(404);
            die("Khóa học không tồn tại!");
        }

        $data = [
            'title' => htmlspecialchars($course['title']) . ' - EduStream',
            'course' => $course
        ];

        $this->view('course_detail/course_detail', $data);
    }
}