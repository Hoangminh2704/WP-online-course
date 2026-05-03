<?php
class App {
    protected $controller = 'HomeController'; // Controller mặc định
    protected $method = 'index';            // Hàm mặc định
    protected $params = [];                 // Tham số

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Tìm Controller
        if (isset($url[0]) && file_exists('app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Tìm Hàm (Method)
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Lấy Tham số (Params)
        $this->params = $url ? array_values($url) : [];

        // 4. Chạy Controller -> Hàm(Tham số)
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}