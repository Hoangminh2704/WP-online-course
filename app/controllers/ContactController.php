<?php
class ContactController extends Controller {

    public function index() {
        $data = [
            'title' => 'Contact Us - EduStream',
            'errors' => [],
            'old' => [
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => ''
            ],
            'success' => false
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
            $message = isset($_POST['message']) ? trim($_POST['message']) : '';

            $data['old']['name'] = $name;
            $data['old']['email'] = $email;
            $data['old']['subject'] = $subject;
            $data['old']['message'] = $message;

           
            // Name validation
            if (empty($name)) {
                $data['errors']['name'] = 'Name is required.';
            } elseif (strlen($name) < 2) {
                $data['errors']['name'] = 'Name must be at least 2 characters.';
            } elseif (strlen($name) > 100) {
                $data['errors']['name'] = 'Name cannot exceed 100 characters.';
            } elseif (!preg_match('/^[a-zA-ZÀ-ỹ\s\.]+$/u', $name)) {
                $data['errors']['name'] = 'Name can only contain letters, spaces, and periods.';
            }

            // Email validation
            if (empty($email)) {
                $data['errors']['email'] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Please enter a valid email address.';
            } elseif (strlen($email) > 255) {
                $data['errors']['email'] = 'Email cannot exceed 255 characters.';
            }

            // Subject validation
            if (empty($subject)) {
                $data['errors']['subject'] = 'Subject is required.';
            } elseif (strlen($subject) < 5) {
                $data['errors']['subject'] = 'Subject must be at least 5 characters.';
            } elseif (strlen($subject) > 200) {
                $data['errors']['subject'] = 'Subject cannot exceed 200 characters.';
            }

            // Message validation
            if (empty($message)) {
                $data['errors']['message'] = 'Message is required.';
            } elseif (strlen($message) < 10) {
                $data['errors']['message'] = 'Message must be at least 10 characters.';
            } elseif (strlen($message) > 5000) {
                $data['errors']['message'] = 'Message cannot exceed 5000 characters.';
            }

            

            if (empty($data['errors'])) {
                $data['success'] = true;
                $data['old'] = [
                    'name' => '',
                    'email' => '',
                    'subject' => '',
                    'message' => ''
                ];

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $data['csrf_token'] = $_SESSION['csrf_token'];

        $this->view('contact/contact', $data);
    }
}
