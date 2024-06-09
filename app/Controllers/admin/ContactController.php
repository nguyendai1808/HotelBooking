<?php
class Contact extends Controller
{
    protected $ContactModel;

    public function __construct()
    {
        //gọi model User
        $this->ContactModel = $this->model('ContactModel');
    }

    public function index()
    {
        $contacts = $this->ContactModel->getContacts();
        $this->view('admin', 'contact/contact.php', [
            'contacts' => $contacts
        ]);
    }


    public function feedback($idlienhe)
    {
        if (isset($_POST['feedback'])) {

            $mail = new Mail();
            $content = '<h2 style="color: gray;">Kính gửi ' . htmlspecialchars($_POST['fullname']) . '</h2>
            <p>Cảm ơn vì đã liên hệ với HotelBooking</p>
            <h3>Thông tin liên hệ của bạn</h3>
            <p>Chủ đề: ' . htmlspecialchars($_POST['subject']) . '</p>
            <p>Nội dung: ' . htmlspecialchars($_POST['message']) . '</p>
            <h3>Thông tin khách sạn phản hồi:</h3>
            <p>Nội dung: ' . htmlspecialchars($_POST['content']) . '</p>
            <p>Nếu có gì thắc mắc xin hãy liên hệ lại với tôi!</p>';

            if ($mail->sendMail($_POST['email'], 'Liên hệ HotelBooking', $content)) {
                $this->ContactModel->updadeContact($idlienhe);
                echo "<script> alert('Gửi thành công');
                        window.location.href = '" . URLROOT . "/admin/contact';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Gửi thất bại');
                        window.location.href = '" . URLROOT . "/admin/contact';
                    </script>";
                exit();
            }
        }

        $contact = $this->ContactModel->findContactById($idlienhe);
        $this->view('admin', 'contact/feedback.php', [
            'contact' => $contact
        ]);
    }

    public function delete($idlienhe = null)
    {
        if (!empty($idlienhe) && filter_var($idlienhe, FILTER_VALIDATE_INT)) {
            $delete = $this->ContactModel->deleteContact($idlienhe);
            if ($delete) {
                header('location:' . URLROOT . '/admin/contact');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/contact');
        }
    }
}
