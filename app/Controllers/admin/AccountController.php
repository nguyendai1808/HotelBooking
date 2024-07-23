<?php
class Account extends Controller
{
    private $AccountModel;

    private $pagination;
    private $per_page = 50;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        $totalItems = $this->AccountModel->countAccountUser();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page);
            $accounts = $this->AccountModel->getAccountUserByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $accounts = null;
            $pag = null;
        }

        $this->view('admin', 'account/account.php', [
            'accounts' => $accounts,
            'pagination' => $pag
        ]);
    }


    public function page($current_page = 1)
    {
        $totalItems = $this->AccountModel->countAccountUser();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page, $current_page);
            $accounts = $this->AccountModel->getAccountUserByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $accounts = null;
            $pag = null;
        }

        $this->view('admin', 'account/account.php', [
            'accounts' => $accounts,
            'pagination' => $pag
        ]);
    }


    public function action()
    {
        if (isset($_POST['lock'])) {
            $result = $this->AccountModel->lockAccount($_POST['lock']);
            if ($result) {
                echo "<script> alert('Khóa tài khoản thành công');
                        window.location.href = '" . URLROOT . "/admin/account';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Lỗi');</script>";
                exit();
            }
        }

        if (isset($_POST['unlock'])) {
            $result = $this->AccountModel->unLockAccount($_POST['unlock']);
            if ($result) {
                echo "<script> alert('Mở khóa tài khoản thành công');
                    window.location.href = '" . URLROOT . "/admin/account';
                </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/account');
        }
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
            } else {
                echo "<script> alert('Lỗi');</script>";
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
}
