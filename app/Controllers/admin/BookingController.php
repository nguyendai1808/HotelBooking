<?php
class Booking extends Controller
{
    private $BookingModel;
    private $CustomerModel;
    private $RoomModel;

    public function __construct()
    {
        //gọi model User
        $this->BookingModel = $this->model('BookingModel');
        $this->CustomerModel = $this->model('CustomerModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        $bookings = $this->BookingModel->getBookingsInvoice();

        foreach ($bookings as $key => $item) {
            $name = $this->CustomerModel->getNameCustomer($item['id_khachhang']);
            $bookings[$key]['tenkhachhang'] = $name;
        }

        $this->view('admin', 'booking/booking.php', [
            'bookings' => $bookings
        ]);
    }

    public function cancelInvoice()
    {
        if (isset($_POST['cancelInvoice'])) {
            $iddondat = $_POST['cancelInvoice'];
            $cancel = $this->BookingModel->cancelInvoice($iddondat);
            if ($cancel) {
                echo '<script>alert("Hủy thành công đơn đặt " + ' . $iddondat . ')</script>';
                $this->index();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function paymentBooking()
    {
        if (isset($_POST['paymentBooking'])) {
            $iddondat = $_POST['paymentBooking'];
            $update = $this->BookingModel->paymentBooking($iddondat);
            if ($update) {
                echo '<script>alert("cập nhật thành công đơn đặt " + ' . $iddondat . ')</script>';
                $this->index();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function completedInvoice()
    {
        if (isset($_POST['completedInvoice'])) {
            $iddondat = $_POST['completedInvoice'];
            $update = $this->BookingModel->completedInvoice($iddondat);
            if ($update) {
                echo '<script>alert("Cập nhật thành công đơn đặt " + ' . $iddondat . ')</script>';
                $this->index();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function detailInvoice($iddondat)
    {
        if (!empty($iddondat) && filter_var($iddondat, FILTER_VALIDATE_INT)) {
            $bookings = $this->BookingModel->getBookingsById($iddondat);

            foreach ($bookings as $key => $room) {
                $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                $bookings[$key]['tengiuong'] = $nameBed;
            }

            $this->view('admin', 'booking/detail.php', [
                'bookings' => $bookings
            ]);
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }
}
