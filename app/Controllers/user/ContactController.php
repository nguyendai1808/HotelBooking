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

            $result = $this->ContactModel->createContact($_POST['fullname'], $_POST['email'], $_POST['subject'], $_POST['message']);
            if ($result) {
                echo "<script> alert('Gửi thành công');
                        window.location.href = '" . URLROOT . "/contact';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Gửi thất bại');
                        window.location.href = '" . URLROOT . "/contact';
                    </script>";
                exit();
            };
        }
        header('location:' . URLROOT . '/contact');
    }
}
