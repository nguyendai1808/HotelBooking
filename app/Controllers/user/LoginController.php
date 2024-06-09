<?php

class Login extends Controller
{
    protected $AccountModel;


    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['login'])) {
            $account = $this->AccountModel->checkAccount($_POST['email'], $_POST['password']);
            if (empty($account)) {
                $this->view('user', 'login.php', [
                    'error' => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]);
            } else {
                if ($account == 'Khóa') {
                    $this->view('user', 'login.php', [
                        'error' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên để mở khóa.'
                    ]);
                } else {
                    session_unset();
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
        header('location:' . URLROOT . '/login');
        exit;
    }

    public function forgotpass()
    {
        if (isset($_POST['forgot'])) {
            $account = $this->AccountModel->checkEmail($_POST['email']);
            if (empty($account)) {
                $this->view('user', 'forgotpass.php', [
                    'email' => $_POST['email'],
                    'error' => 'Email này không tồn tại'
                ]);
            } else {
                $otp = mt_rand(100000, 999999);
                Session::set('otp_forgot', $otp, 180);
                Session::set('email_forgot', $_POST['email'], 900);

                $mail = new Mail();
                if ($mail->sendMail($_POST['email'], 'Quên mật khẩu', 'Mã OTP của bạn là: ' . $otp)) {
                    $this->view('user', 'forgotpass.php', [
                        'inputOTP' => 'Nhập mã OTP được gửi qua email',
                        'time' => 3
                    ]);
                } else {
                    $this->view('user', 'forgotpass.php', [
                        'email' => $_POST['email'],
                        'error' => 'Gửi mã OTP thất bại'
                    ]);
                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                }
            }
        }

        $this->view('user', 'forgotpass.php', []);
    }

    public function inputOTP()
    {
        if (isset($_POST['confrim'])) {

            if (Session::get('otp_forgot')) {
                if (Session::get('otp_forgot') == $_POST['otp']) {

                    $this->view('user', 'forgotpass.php', [
                        'email' => Session::get('email_forgot'),
                        'saveNewPass' => 'Hãy nhập mật khẩu mới'
                    ]);

                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                } else {
                    $this->view('user', 'forgotpass.php', [
                        'inputOTP' => 'Nhập mã OTP của bạn',
                        'error' => 'Mã OTP của bạn không đúng!'
                    ]);
                }
            } else {
                $this->view('user', 'forgotpass.php', [
                    'inputOTP' => 'Nhập mã OTP của bạn',
                    'error' => 'Đã hết thời gian mã OTP'
                ]);
            }
        }

        if (isset($_POST['sendTo'])) {

            $email = Session::get('email_forgot');
            if ($email) {
                $otp = mt_rand(100000, 999999);
                Session::set('otp_forgot', $otp, 180);

                $mail = new Mail();
                if ($mail->sendMail($email, 'Quên mật khẩu', 'Mã OTP của bạn là: ' . $otp)) {
                    $this->view('user', 'forgotpass.php', [
                        'inputOTP' => 'Nhập mã OTP được gửi qua email',
                        'time' => 3
                    ]);
                } else {
                    $this->view('user', 'forgotpass.php', [
                        'error' => 'Gửi mã OTP thất bại'
                    ]);
                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                }
            } else {
                $this->view('user', 'forgotpass.php', []);
            }
        }

        $this->view('user', 'forgotpass.php', []);
    }


    public function saveNewPass()
    {
        if (isset($_POST['savePass'])) {

            $result = $this->AccountModel->changePass($_POST['email'], $_POST['newPass']);
            if ($result) {
                echo "<script> alert('Lưu thành công');
                        window.location.href = '" . URLROOT . "/login';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Lưu thất bại');</script>";
                $this->view('user', 'forgotpass.php');
            }
        }

        $this->view('user', 'forgotpass.php');
    }
}
