<?php
class AuthController extends Controller {

    private function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    private function redirectIfLoggedIn() {
        if ($this->isLoggedIn()) {
            $base = rtrim(BASE_URL, '/');
            header('Location: ' . ($base ?: '/'));
            exit;
        }
    }

    public function login() {
        $this->redirectIfLoggedIn();

        $data = [
            'title' => 'Login',
            'errors' => [],
            'old' => ['email' => '']
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $data['old']['email'] = $email;

            // Validate
            if (empty($email)) {
                $data['errors']['email'] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Invalid email format.';
            }

            if (empty($password)) {
                $data['errors']['password'] = 'Password is required.';
            }

            if (empty($data['errors'])) {
                $userModel = $this->model('UserModel');
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password_hash'])) {
                    // Login successful
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];

                    $base = rtrim(BASE_URL, '/');
                    $redirect = isset($_SESSION['redirect_after_login'])
                        ? $_SESSION['redirect_after_login']
                        : ($base ?: '/');
                    unset($_SESSION['redirect_after_login']);
                    header('Location: ' . $redirect);
                    exit;
                } else {
                    $data['errors']['general'] = 'Invalid email or password.';
                }
            }
        }

        $this->view('auth/login', $data);
    }

    public function register() {
        $this->redirectIfLoggedIn();

        $data = [
            'title' => 'Register',
            'errors' => [],
            'old' => [
                'full_name' => '',
                'email' => ''
            ]
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $passwordConfirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

            $data['old']['full_name'] = $fullName;
            $data['old']['email'] = $email;

            // Validate
            if (empty($fullName)) {
                $data['errors']['full_name'] = 'Full name is required.';
            } elseif (strlen($fullName) < 2) {
                $data['errors']['full_name'] = 'Full name must be at least 2 characters.';
            }

            if (empty($email)) {
                $data['errors']['email'] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Invalid email format.';
            } else {
                $userModel = $this->model('UserModel');
                if ($userModel->emailExists($email)) {
                    $data['errors']['email'] = 'Email already registered.';
                }
            }

            if (empty($password)) {
                $data['errors']['password'] = 'Password is required.';
            } elseif (strlen($password) < 6) {
                $data['errors']['password'] = 'Password must be at least 6 characters.';
            }

            if ($password !== $passwordConfirm) {
                $data['errors']['password_confirm'] = 'Passwords do not match.';
            }

            if (empty($data['errors'])) {
                $userModel = $this->model('UserModel');
                $userModel->create($fullName, $email, $password);

                // Auto-login after registration
                $_SESSION['user_id'] = $userModel->findByEmail($email)['user_id'];
                $_SESSION['user_name'] = $fullName;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'student';

                $base = rtrim(BASE_URL, '/');
                header('Location: ' . ($base ?: '/'));
                exit;
            }
        }

        $this->view('auth/register', $data);
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        // Redirect to home page
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}
