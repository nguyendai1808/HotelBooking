<?php
class App
{
    private $controller = 'Home';
    private $action = 'index';
    private $params = [];
    private $controllerPath;

    public function __construct()
    {
        $url = $this->urlProcess();

        if ($this->isAdminPath($url)) {
            $this->handleAdminPath($url);
        } else {
            $this->handleUserPath($url);
        }

        require_once $this->getControllerPath();

        // Khởi tạo controller mới
        $this->controller = new $this->controller;

        // Lọc action
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        }

        // lấy params
        $this->params = $url ? array_values($url) : [];

        // Khởi tạo class từ controller
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    private function urlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }
        return [];
    }

    private function isAdminPath(&$url)
    {
        if (isset($url[0]) && strtolower($url[0]) === "admin") {
            array_shift($url);
            return true;
        }
        return false;
    }

    private function handleAdminPath(&$url)
    {
        $path = './app/Controllers/admin/';
        $user_id = Session::get('user_id');

        if ($user_id) {
            $account = Session::checkAccount($user_id);
            if ($account == 'admin') {
                if (isset($url[0]) && file_exists($path . ucfirst($url[0]) . 'Controller.php')) {
                    $this->controller = ucfirst($url[0]);
                }
            } else {
                $this->controller = 'LoginAdmin';
            }
        } else {
            $this->controller = 'LoginAdmin';
        }

        $this->controllerPath = $path . $this->controller . 'Controller.php';
        unset($url[0]);
    }

    private function handleUserPath(&$url)
    {
        $path = './app/Controllers/user/';
        $user_id = Session::get('user_id');

        if (isset($url[0])) {
            $url_tmp = strtolower($url[0]);

            if (in_array($url_tmp, ['cart', 'history', 'personalinfo'])) {
                if ($user_id) {
                    if (file_exists($path . ucfirst($url[0]) . 'Controller.php')) {
                        $this->controller = ucfirst($url[0]);
                    }
                } else {
                    $this->controller = 'Login';
                }
            } else {
                if (file_exists($path . ucfirst($url[0]) . 'Controller.php')) {
                    $this->controller = ucfirst($url[0]);
                }
            }
        }

        $this->controllerPath = $path . $this->controller . 'Controller.php';
        unset($url[0]);
    }

    private function getControllerPath()
    {
        return $this->controllerPath;
    }
}
