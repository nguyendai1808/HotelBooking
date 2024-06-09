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

            $checkout = $this->BookingModel->getCheckoutMaxBooking($item['id_dondat']);
            $bookings[$key]['ngaydi'] = $checkout;
        }

        $this->view('admin', 'booking/booking.php', [
            'bookings' => $bookings
        ]);
    }

    public function cancel($iddondat)
    {
        if (!empty($iddondat) && filter_var($iddondat, FILTER_VALIDATE_INT)) {

            $cancel = $this->BookingModel->updateCategory();
            if ($cancel) {
                header('location:' . URLROOT . '/admin/booking');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function detail($iddondat)
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
