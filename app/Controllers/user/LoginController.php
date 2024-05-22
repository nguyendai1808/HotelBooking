<?php


class Login extends Controller
{
    protected $AccountModel;


    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('Accounts');
    }

    public function index()
    {
        if (isset($_POST['login'])) {
            $account = $this->AccountModel->checkAccount($_POST['email'], $_POST['password']);
            if ($account == null) {
                $this->view('user', 'login.php', [
                    'error' => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]);
            } else {
                if ($account == 2) {
                    $this->view('user', 'login.php', [
                        'error' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên để mở khóa.'
                    ]);
                } else {

                    $user_id = $this->AccountModel->getIdAccountByEmail($_POST['email']);
                    Session::set('user_id', $user_id);
                    header('location:' . URLROOT . '/home');
                    exit();
                }
            }
        }
        $this->view('user', 'login.php', []);
    }

    public function logout()
    {
        // Xóa session và chuyển hướng về trang đăng nhập
        Session::destroy();
        header('location:' . URLROOT . '/home');
        exit;
    }
}
