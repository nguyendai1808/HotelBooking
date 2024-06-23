<?php
class Register extends Controller
{
    protected $AccountModel;

    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['register'])) {
            $account = $this->AccountModel->checkEmail($_POST['email']);
            if ($account > 0) {
                $this->view('user', 'register.php', [
                    'error' => 'Tài khoản đã có nsgười sử dụng.'
                ]);
            } else {
                if ($this->AccountModel->createAccount($_POST['surname'], $_POST['name'], $_POST['email'], $_POST['pass'], 'user')) {
                    $user_id = $this->AccountModel->getIdAccountByEmail($_POST['email']);
                    Session::set('user_id', $user_id);
                    echo '<script> alert("Đăng ký thành công");
                        location.href="' . URLROOT . '/home";
                    </script>';
                    exit();
                }
            }
        }
        $this->view('user', 'register.php', []);
    }
}
