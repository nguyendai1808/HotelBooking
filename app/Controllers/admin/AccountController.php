<?php
class Account extends Controller
{
    protected $AccountModel;

    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        $accounts =  $this->AccountModel->getAccount2();

        $this->view('admin', 'account/account.php', [
            'accounts' => $accounts
        ]);
    }

    public function create()
    {
        if (isset($_POST['create'])) {
            $result = $this->AccountModel->createAccount2($_POST['surname'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['pass'], $_POST['loaitk']);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/account';
                    </script>";
                exit();
            }
        }
        $this->view('admin', 'account/create.php');
    }

    public function detail($idtaikhoan)
    {
        if (!empty($idtaikhoan) && filter_var($idtaikhoan, FILTER_VALIDATE_INT)) {

            $account =  $this->AccountModel->findAccountById($idtaikhoan);

            $this->view('admin', 'account/detail.php', [
                'account' => $account
            ]);
        } else {
            header('location:' . URLROOT . '/admin/account');
        }
    }

    public function lock($idtaikhoan)
    {
        if (!empty($idtaikhoan) && filter_var($idtaikhoan, FILTER_VALIDATE_INT)) {

            $result = $this->AccountModel->lockAccount($idtaikhoan);
            if ($result) {
                header('location:' . URLROOT . '/admin/account');
            }
        } else {
            header('location:' . URLROOT . '/admin/account');
        }
    }

    public function unlock($idtaikhoan)
    {

        if (!empty($idtaikhoan) && filter_var($idtaikhoan, FILTER_VALIDATE_INT)) {

            $result = $this->AccountModel->unLockAccount($idtaikhoan);

            if ($result) {
                header('location:' . URLROOT . '/admin/account');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/account');
        }
    }
}
