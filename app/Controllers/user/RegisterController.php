<?php
class Register extends Controller
{
    private $AccountModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['register'])) {

            $email = $_POST['email'];;
            if (Validate::checkEmail($email)) {
                $account = $this->AccountModel->checkEmail($email);
                if ($account > 0) {
                    echo '<script> alert("Tài khoản đã có nsgười sử dụng.");
                            window.history.back()
                        </script>';
                    exit();
                } else {
                    if ($this->AccountModel->createAccount($_POST['surname'], $_POST['name'], $email, $_POST['pass'], 'user')) {
                        $user_id = $this->AccountModel->getIdAccountByEmail($email);
                        Session::set('user_id', $user_id);
                        echo '<script> alert("Đăng ký thành công");
                            location.href="' . URLROOT . '/home";
                        </script>';
                        exit();
                    }
                }
            } else {
                echo '<script> alert("Email này không hợp lệ.");
                    window.history.back()
                </script>';
                exit();
            }
        }
        $this->view('user', 'register.php', []);
    }
}
