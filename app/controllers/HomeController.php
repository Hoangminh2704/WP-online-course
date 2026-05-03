<?php
class HomeController extends Controller {
    public function index() {
        // Gửi dữ liệu từ Controller sang View
        $data = [
            'title' => 'Trang chủ nền tảng Khóa học',
            'message' => 'MVC Framework đã hoạt động hoàn hảo!'
        ];
        
        $this->view('home/home', $data);
    }
}