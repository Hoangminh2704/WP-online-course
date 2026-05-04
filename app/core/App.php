<?php
class App {
    protected $controller = 'HomeController'; // Default controller
    protected $method = 'index';              // Default method
    protected $params = [];                  // URL parameters

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Find Controller
        if (isset($url[0]) && file_exists('app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Find Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Extract Parameters
        $this->params = $url ? array_values($url) : [];

        // 4. Dispatch: Controller -> Method(Parameters)
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}