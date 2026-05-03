<?php
class CoursesController extends Controller {

    /**
     * Trang danh sách khóa học
     */
    public function index() {
        $courseModel = $this->model('CourseModel');
        $courses = $courseModel->getAllCourses();

        $data = [
            'title' => 'Danh sách Khóa học - EduStream',
            'courses' => $courses
        ];

        $this->view('catalog/catalog', $data);
    }

    /**
     * Chi tiết khóa học
     */
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

        // Lấy trạng thái enrollment và cart
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

    /**
     * Đăng ký khóa học ngay (Enroll Now)
     */
    public function enroll() {
        // Yêu cầu đăng nhập
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
            $_SESSION['error'] = 'Khóa học không hợp lệ.';
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $enrollmentModel = $this->model('EnrollmentModel');
        $courseModel = $this->model('CourseModel');

        // Lấy slug để redirect về lại trang course
        $course = $courseModel->getCourseById($courseId);
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại.';
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        // Kiểm tra đã đăng ký chưa
        if ($enrollmentModel->isEnrolled($_SESSION['user_id'], $courseId)) {
            $_SESSION['error'] = 'Bạn đã sở hữu khóa học này rồi!';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        }

        // Đăng ký khóa học
        try {
            $enrollmentModel->enroll($_SESSION['user_id'], $courseId);

            // Xóa khỏi giỏ hàng nếu có
            $cartModel = $this->model('CartModel');
            $cartModel->removeFromCart($courseId);

            $_SESSION['success'] = 'Đăng ký khóa học thành công! Chúc mừng bạn đã sở hữu khóa học "' . $course['title'] . '".';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
            exit;
        }
    }

    /**
     * Thêm vào giỏ hàng (Add to Cart)
     */
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/courses');
            exit;
        }

        $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

        if ($courseId <= 0) {
            $_SESSION['error'] = 'Khóa học không hợp lệ.';
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/courses');
            exit;
        }

        // Kiểm tra khóa học có tồn tại không
        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseById($courseId);
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại.';
            header('Location: BASE_URL' . '/courses');
            exit;
        }

        // Kiểm tra đã đăng ký chưa
        if (isset($_SESSION['user_id'])) {
            $enrollmentModel = $this->model('EnrollmentModel');
            if ($enrollmentModel->isEnrolled($_SESSION['user_id'], $courseId)) {
                $_SESSION['error'] = 'Bạn đã sở hữu khóa học này rồi, không cần thêm vào giỏ hàng.';
                header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
                exit;
            }
        }

        $cartModel = $this->model('CartModel');

        // Kiểm tra đã trong giỏ chưa
        if ($cartModel->isInCart($courseId)) {
            $_SESSION['warning'] = 'Khóa học này đã có trong giỏ hàng của bạn.';
        } else {
            $cartModel->addToCart($courseId);
            $_SESSION['success'] = 'Đã thêm "' . $course['title'] . '" vào giỏ hàng!';
        }

        header('Location: ' . BASE_URL . '/courses/detail/' . $course['slug']);
        exit;
    }

    /**
     * Trang giỏ hàng
     */
    public function cart() {
        $cartModel = $this->model('CartModel');
        $courses = $cartModel->getCartWithDetails();

        $total = 0;
        foreach ($courses as $course) {
            $total += $course['price'];
        }

        $data = [
            'title' => 'Giỏ hàng - EduStream',
            'courses' => $courses,
            'total' => $total,
            'count' => count($courses)
        ];

        $this->view('cart/cart', $data);
    }

    /**
     * Xóa khóa học khỏi giỏ hàng
     */
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/courses/cart');
            exit;
        }

        $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

        if ($courseId > 0) {
            $cartModel = $this->model('CartModel');
            $cartModel->removeFromCart($courseId);
            $_SESSION['success'] = 'Đã xóa khóa học khỏi giỏ hàng.';
        }

        header('Location: ' . BASE_URL . '/courses/cart');
        exit;
    }

    /**
     * Checkout - Mua tất cả trong giỏ hàng
     */
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = BASE_URL . '/courses/cart';
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $cartModel = $this->model('CartModel');
        $courses = $cartModel->getCartWithDetails();

        if (empty($courses)) {
            $_SESSION['error'] = 'Giỏ hàng trống.';
            header('Location: ' . BASE_URL . '/courses/cart');
            exit;
        }

        $enrollmentModel = $this->model('EnrollmentModel');
        $count = 0;

        foreach ($courses as $course) {
            // Chỉ enroll nếu chưa có
            if (!$enrollmentModel->isEnrolled($_SESSION['user_id'], $course['course_id'])) {
                $enrollmentModel->enroll($_SESSION['user_id'], $course['course_id']);
                $count++;
            }
        }

        // Xóa giỏ hàng sau khi checkout
        $cartModel->clearCart();

        $_SESSION['success'] = "Đã đăng ký thành công $count khóa học! Chúc mừng bạn.";
        header('Location: ' . BASE_URL . '/user/my-courses');
        exit;
    }
}
