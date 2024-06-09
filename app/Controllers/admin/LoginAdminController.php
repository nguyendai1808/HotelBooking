<?php
class LoginAdmin extends Controller
{
    protected $AccountModel;

    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['loginAdmin'])) {
            $account = $this->AccountModel->checkAccountAdmin($_POST['account'], $_POST['password']);
            if (empty($account)) {
                $this->view('admin', 'loginAdmin.php', [
                    'error' => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]);
            } else {
                if ($account == 'admin') {
                    $user_id = $this->AccountModel->getIdAccountByEmail($_POST['account']);
                    Session::set('user_id', $user_id);
                    header('location:' . URLROOT . '/admin');
                    exit();
                } else {
                    $this->view('admin', 'loginAdmin.php', [
                        'error' => 'Tài khoản của bạn không phải là tài khoản admin.'
                    ]);
                }
            }
        }
        $this->view('admin', 'loginAdmin.php');
    }

    public function logout()
    {
        // Xóa session và chuyển hướng về trang đăng nhập
        Session::destroy();
        header('location:' . URLROOT . '/admin/loginAdmin');
        exit;
    }
}
