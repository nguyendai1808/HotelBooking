<?php
class App
{
    protected $controller = 'Home';
    protected $action = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->urlProcess();

        $path = './app/Controllers/user/';
        //lọc controller
        if (isset($url[0])) {

            if (strtolower($url[0]) === "admin") {
                $path = './app/Controllers/admin/';
                array_shift($url);
                $url = array_values($url);
            }

            $user_id = Session::get('user_id');
            if ($path == './app/Controllers/admin/') {
                if ($user_id) {
                    $db = new Database();
                    $sql = "SELECT loaitk FROM taikhoan where idtaikhoan = '$user_id'";
                    $account = $db->selectFirstColumnValue($sql, 'loaitk');
                    if ($account == 'admin') {
                        if (!empty($url[0]) && file_exists($path . $url[0] . 'Controller.php')) {
                            $this->controller = $url[0];
                        }
                    } else {
                        $this->controller = 'LoginAdmin';
                    }
                } else {
                    $this->controller = 'LoginAdmin';
                }
            } else {
                if (!empty($url[0])) {
                    $url_tmp = strtolower($url[0]);
                    if ($url_tmp == 'cart' || $url_tmp == 'history' || $url_tmp == 'personalinfo') {
                        if ($user_id) {
                            if (file_exists($path . $url[0] . 'Controller.php')) {
                                $this->controller = $url[0];
                            }
                        } else {
                            $this->controller = 'Login';
                        }
                    } else {
                        if (file_exists($path . $url[0] . 'Controller.php')) {
                            $this->controller = $url[0];
                        }
                    }
                }
            }

            unset($url[0]);
        }


        require_once  $path . $this->controller . 'Controller.php';

        //khởi tạo controller mới
        $this->controller = new $this->controller;

        //lọc action
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        }

        //get params
        $this->params = $url ? array_values($url) : [];

        //khởi tại class từ controller
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    public function urlProcess()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
