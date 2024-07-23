<?php

class Login extends Controller
{
    private $AccountModel;

    public function __construct()
    {
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $account = $this->AccountModel->checkAccount($email, $pass);
            if (empty($account)) {
                $this->view('user', 'login.php', [
                    'email' => $email,
                    'error' => 'Tài khoản hoặc mật khẩu không chính xác.'
                ]);
            } else {
                if ($account == 'Khóa') {
                    $this->view('user', 'login.php', [
                        'email' => $email,
                        'error' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên để mở khóa.'
                    ]);
                } else {
                    session_unset();
                    $user_id = $this->AccountModel->getIdAccountByEmail($email);
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

    public function forgotPass()
    {
        if (isset($_POST['forgot'])) {
            $email = $_POST['email'];
            $account = $this->AccountModel->checkEmail($email);
            if (empty($account)) {
                $this->view('user', 'forgot_pass.php', [
                    'email' => $email,
                    'error' => 'Email này không tồn tại'
                ]);
            } else {
                $otp = mt_rand(100000, 999999);
                Session::set('otp_forgot', $otp, 180);
                Session::set('email_forgot', $email, 900);

                $mail = new Mail();
                if ($mail->sendMail($email, 'Quên mật khẩu', 'Mã OTP của bạn là: ' . $otp)) {
                    $this->view('user', 'forgot_pass.php', [
                        'inputOTP' => 'Nhập mã OTP được gửi qua email',
                        'time' => 3
                    ]);
                } else {
                    $this->view('user', 'forgot_pass.php', [
                        'email' => $email,
                        'error' => 'Gửi mã OTP thất bại'
                    ]);
                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                }
            }
        }

        $this->view('user', 'forgot_pass.php', []);
    }

    public function inputOTP()
    {
        if (isset($_POST['confirm'])) {
            if (Session::get('otp_forgot')) {
                if (Session::get('otp_forgot') == $_POST['otp']) {
                    $this->view('user', 'forgot_pass.php', [
                        'email' => Session::get('email_forgot'),
                        'saveNewPass' => 'Hãy nhập mật khẩu mới'
                    ]);
                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                } else {
                    $this->view('user', 'forgot_pass.php', [
                        'inputOTP' => 'Nhập mã OTP của bạn',
                        'error' => 'Mã OTP của bạn không đúng!'
                    ]);
                }
            } else {
                $this->view('user', 'forgot_pass.php', [
                    'inputOTP' => 'Nhập mã OTP của bạn',
                    'error' => 'Đã hết thời gian mã OTP'
                ]);
            }
        } else {
            header('location:' . URLROOT . '/login/forgotPass');
        }
    }

    public function sendTo()
    {
        if (isset($_POST['sendTo'])) {
            $email = Session::get('email_forgot');
            if ($email) {
                $otp = mt_rand(100000, 999999);
                Session::set('otp_forgot', $otp, 180);
                $mail = new Mail();
                if ($mail->sendMail($email, 'Quên mật khẩu', 'Mã OTP của bạn là: ' . $otp)) {
                    $this->view('user', 'forgot_pass.php', [
                        'inputOTP' => 'Nhập mã OTP được gửi qua email',
                        'time' => 3
                    ]);
                } else {
                    $this->view('user', 'forgot_pass.php', [
                        'error' => 'Gửi mã OTP thất bại'
                    ]);
                    Session::delete('otp_forgot');
                    Session::delete('email_forgot');
                }
            } else {
                header('location:' . URLROOT . '/login/forgotPass');
            }
        } else {
            header('location:' . URLROOT . '/login/forgotPass');
        }
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
                echo "<script> alert('Lưu thất bại');
                    window.location.href = '" . URLROOT . "/login/forgotPass';
                </script>";
                exit();
            }
        } else {
            header('location:' . URLROOT . '/login/forgotPass');
        }
    }
}
