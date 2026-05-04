<?php
class CoursesController extends Controller {

    
    public function index() {
        $courseModel = $this->model('CourseModel');
        $courses = $courseModel->getAllCourses();

        $data = [
            'title' => 'Course Catalog - EduStream',
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
            die("Course not found!");
        }

        $enrolledCourseIds = [];
        $cartCourseIds = [];

        if (isset($_SESSION['user_id'])) {
            $enrollmentModel = $this->model('EnrollmentModel');
            $enrolledCourseIds = $enrollmentModel->getEnrolledCourseIds($_SESSION['user_id']);
        }

        $cartModel = $this->model('CartModel');
        $cartCourseIds = $cartModel->getCart();

        $data = [
            'title' => htmlspecialchars($course['title']) . ' - EduStream',
            'course' => $course,
            'is_enrolled' => in_array($course['course_id'], $enrolledCourseIds),
            'is_in_cart' => in_array($course['course_id'], $cartCourseIds),
            'is_logged_in' => isset($_SESSION['user_id'])
        ];

        $this->view('course_detail/course_detail', $data);
    }

    public function enroll() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/courses';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

        if ($courseId <= 0) {
            $_SESSION['error'] = 'Invalid course.';
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $enrollmentModel = $this->model('EnrollmentModel');
        $courseModel = $this->model('CourseModel');

        $course = $courseModel->getCourseById($courseId);
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        if ($enrollmentModel->isEnrolled($_SESSION['user_id'], $courseId)) {
            $_SESSION['error'] = 'You already own this course!';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        }

        try {
            $enrollmentModel->enroll($_SESSION['user_id'], $courseId);

            $cartModel = $this->model('CartModel');
            $cartModel->removeFromCart($courseId);

            $_SESSION['success'] = 'Successfully enrolled in "' . $course['title'] . '"! Congratulations on your new course.';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'An error occurred. Please try again.';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        }
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

        if ($courseId <= 0) {
            $_SESSION['error'] = 'Invalid course.';
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/courses');
            exit;
        }

        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseById($courseId);
        if (!$course) {
            $_SESSION['error'] = 'Course not found.';
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        if (isset($_SESSION['user_id'])) {
            $enrollmentModel = $this->model('EnrollmentModel');
            if ($enrollmentModel->isEnrolled($_SESSION['user_id'], $courseId)) {
                $_SESSION['error'] = 'You already own this course, no need to add it to cart.';
                header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
                exit;
            }
        }

        $cartModel = $this->model('CartModel');

        if ($cartModel->isInCart($courseId)) {
            $_SESSION['warning'] = 'This course is already in your cart.';
        } else {
            $cartModel->addToCart($courseId);
            $_SESSION['success'] = '"' . $course['title'] . '" has been added to your cart!';
        }

        header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
        exit;
    }

    public function cart() {
        $cartModel = $this->model('CartModel');
        $courses = $cartModel->getCartWithDetails();

        $total = 0;
        foreach ($courses as $course) {
            $total += $course['price'];
        }

        $data = [
            'title' => 'Shopping Cart - EduStream',
            'courses' => $courses,
            'total' => $total,
            'count' => count($courses)
        ];

        $this->view('cart/cart', $data);
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/courses/cart');
            exit;
        }

        $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

        if ($courseId > 0) {
            $cartModel = $this->model('CartModel');
            $cartModel->removeFromCart($courseId);
            $_SESSION['success'] = 'Course removed from your cart.';
        }

        header('Location: ' . BASE_URL . '/courses/cart');
        exit;
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASE_URL . '/courses/cart';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $cartModel = $this->model('CartModel');
        $courses = $cartModel->getCartWithDetails();

        if (empty($courses)) {
            $_SESSION['error'] = 'Your cart is empty.';
            header('Location: ' . BASE_URL . '/courses/cart');
            exit;
        }

        $enrollmentModel = $this->model('EnrollmentModel');
        $count = 0;

        foreach ($courses as $course) {
            if (!$enrollmentModel->isEnrolled($_SESSION['user_id'], $course['course_id'])) {
                $enrollmentModel->enroll($_SESSION['user_id'], $course['course_id']);
                $count++;
            }
        }

        $cartModel->clearCart();

        $_SESSION['success'] = "Successfully enrolled in $count course" . ($count != 1 ? "s" : "") . "! Congratulations!";
        header('Location: ' . BASE_URL . '/user/my-courses');
        exit;
    }
}
