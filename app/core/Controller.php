<?php
class Controller {
    // Hàm gọi Model
    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    // Hàm gọi View
    public function view($view, $data = []) {
        if (file_exists('app/views/' . $view . '.php')) {
            extract($data);
            require_once 'app/views/' . $view . '.php';
        } else {
            die("View $view không tồn tại.");
        }
    }
}