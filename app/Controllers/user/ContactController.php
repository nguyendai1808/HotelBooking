<?php
class Contact extends Controller
{
    private $ContactModel;
    private $HotelModel;

    public function __construct()
    {
        $this->HotelModel = $this->model('HotelModel');
        $this->ContactModel = $this->model('ContactModel');
    }

    public function index()
    {
        $Hotel = $this->HotelModel->getHotel();

        $this->view('user', 'contact.php', [
            'hotel' => $Hotel
        ]);
    }

    public function send()
    {
        if (isset($_POST['send'])) {

            $email = $_POST['email'];
            if (Validate::checkEmail($email)) {
                $result = $this->ContactModel->createContact($_POST['fullname'], $email, $_POST['subject'], $_POST['message']);
                if ($result) {
                    echo "<script> alert('Gửi thành công');
                            window.location.href = '" . URLROOT . "/contact';
                        </script>";
                    exit();
                } else {
                    echo "<script> alert('Chức năng này hiện đang lỗi vui lòng thử lại sau');
                            window.location.href = '" . URLROOT . "/contact';
                        </script>";
                    exit();
                };
            } else {
                echo "<script> alert('Email này không hợp lệ hãy nhập đúng email của bạn');
                    window.history.back();
                </script>";
                exit();
            }
        } else {
            header('location:' . URLROOT . '/contact');
        }
    }
}
