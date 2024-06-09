<?php

class Home extends Controller
{
    private $HotelModel;
    private $RoomModel;
    private $ServiceModel;

    public function __construct()
    {
        //gọi model User
        $this->HotelModel = $this->model('HotelModel');
        $this->RoomModel = $this->model('RoomModel');
        $this->ServiceModel = $this->model('ServiceModel');
    }

    public function index()
    {
        //phòng
        $RoomsHot = $this->RoomModel->getRoomsHot(5);

        $RoomsSale = $this->RoomModel->getRoomsBySale(5);

        //khách sạn
        $Hotel = $this->HotelModel->getHotel();


        foreach ($Hotel as $key => $item) {
            $numberRoom = $this->HotelModel->getNumberRoom();
            $Hotel[$key]['sophong'] = $numberRoom;

            $numberService = $this->HotelModel->getNumberService();
            $Hotel[$key]['sodichvu'] = $numberService;

            $numberRating = $this->HotelModel->getNumberRating();
            $Hotel[$key]['sodanhgia'] = $numberRating;

            $scoreRating = $this->HotelModel->getScoreRating();
            $Hotel[$key]['sodiem'] = $scoreRating;

            $imgsHotel = $this->HotelModel->getImagesHotel(2);
            $Hotel[$key]['anhks'] = $imgsHotel;
        }

        //dịch vụ
        $Services = $this->ServiceModel->getServices(6);

        //gọi và show dữ liệu ra view
        $this->view('user', 'home.php', [
            'roomshot' => $this->getRoomMore($RoomsHot),
            'roomsSale' => $this->getRoomMore($RoomsSale),
            'hotel' => $Hotel,
            'services' => $Services
        ]);
    }

    public function getRoomMore($Rooms)
    {
        if (!empty($Rooms)) {
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

                $desc = $this->RoomModel->getDescRoom($room['idphong']);
                $Rooms[$key]['mota'] = $desc;

                $paymentMethod = $this->RoomModel->findPaymentMethod($room['idphong']);
                $Rooms[$key]['loaihinhtt'] = implode(" & ", array_column($paymentMethod, 'loaihinhthanhtoan'));
            }
        }
        return $Rooms ?? null;
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

    public function checkRoom()
    {
        if ($this->isAjaxRequest()) {
            $arrival = isset($_POST['arrival']) ? $_POST['arrival'] : '';
            $departure = isset($_POST['departure']) ? $_POST['departure'] : '';
            $idphong = isset($_POST['idphong']) ? $_POST['idphong'] : '';
            if ($arrival == '' || $departure == '' || $idphong == '') {
                $emptyRoom = 0;
            } else {
                $emptyRoom = $this->RoomModel->emptyRoom($arrival, $departure, $idphong);
            }

            $response = [
                'emptyRoom' => $emptyRoom
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        header('location:' . URLROOT . '/home');
    }
}
