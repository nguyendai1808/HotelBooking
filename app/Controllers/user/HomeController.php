<?php

class Home extends Controller
{
    protected $HotelModel;
    protected $RoomModel;
    protected $ServiceModel;

    public function __construct()
    {
        //gọi model User
        $this->HotelModel = $this->model('Hotel');
        $this->RoomModel = $this->model('Rooms');
        $this->ServiceModel = $this->model('Services');
    }

    public function index()
    {
        //phòng
        $Rooms = $this->RoomModel->getRooms(5);

        //khách sạn
        $Hotel = $this->HotelModel->getHotel();

        //dịch vụ
        $Services = $this->ServiceModel->getServices(6);


        //gọi và show dữ liệu ra view
        $this->view('user', 'home.php', [
            'rooms' => $this->getRoomMore($Rooms),
            'hotel' => $Hotel,
            'services' => $Services
        ]);
    }

    public function getRoomMore($Rooms)
    {
        foreach ($Rooms as $key => $room) {
            $promotion = $this->RoomModel->getPromotionRoom($room['idphong']);
            $Rooms[$key]['khuyenmai'] = $promotion;

            $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
            $Rooms[$key]['anhphong'] = $mainImg;

            $nameBed = $this->RoomModel->getNameBed($room['idphong']);
            $Rooms[$key]['tengiuong'] = $nameBed;

            $quantityBed = $this->RoomModel->getquantityBed($room['idphong']);
            $Rooms[$key]['sogiuong'] = $quantityBed;

            $rating = $this->RoomModel->getRatingRoom($room['idphong']);
            $Rooms[$key]['danhgia'] = $rating;

            $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
            $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
        }
        return $Rooms;
    }

    public function bookingForm()
    {
        if ($this->isAjaxRequest()) {
            $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : '';
            $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : '';
            $adult = isset($_POST['adult']) ? $_POST['adult'] : '';
            $child = isset($_POST['child']) ? $_POST['child'] : '';

            Session::set('checkin', $checkin);
            Session::set('checkout', $checkout);
            Session::set('adult', $adult);
            Session::set('child', $child);
        }
    }

    public function changedate()
    {
        if ($this->isAjaxRequest()) {
            $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : '';
            $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : '';

            Session::set('checkin', $checkin);
            Session::set('checkout', $checkout);
        }
    }
}
