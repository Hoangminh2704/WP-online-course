<?php
class UserController extends Controller {

    
    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASE_URL . '/user/my-courses';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    
    public function myCourses() {
        $this->requireLogin();

        $enrollmentModel = $this->model('EnrollmentModel');
        $courses = $enrollmentModel->getEnrollmentsByUser($_SESSION['user_id']);

        $data = [
            'title' => 'My Courses - EduStream',
            'courses' => $courses,
            'user_name' => $_SESSION['user_name'] ?? 'User',
            'total_courses' => count($courses)
        ];

        $this->view('user/my-courses', $data);
    }

    
    public function index() {
        header('Location: ' . BASE_URL . '/user/myCourses');
        exit;
    }

    
    public function profile() {
        $this->requireLogin();

        $userModel = $this->model('UserModel');
        $user = $userModel->findById($_SESSION['user_id']);

        $data = [
            'title' => 'My Profile - EduStream',
            'user' => $user
        ];

        $this->view('user/profile', $data);
    }
}
