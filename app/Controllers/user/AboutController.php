<?php
class About extends Controller
{
    private $HotelModel;
    private $ServiceModel;
    private $RatingModel;

    public function __construct()
    {
        $this->HotelModel = $this->model('HotelModel');
        $this->ServiceModel = $this->model('ServiceModel');
        $this->RatingModel = $this->model('RatingModel');
    }

    public function index()
    {
        $Hotel = $this->HotelModel->getHotel();

        if ($Hotel) {
            foreach ($Hotel as $key => $item) {
                $numberRoom = $this->HotelModel->getNumberRoom();
                $Hotel[$key]['sophong'] = $numberRoom;

                $numberService = $this->HotelModel->getNumberService();
                $Hotel[$key]['sodichvu'] = $numberService;

                $numberRating = $this->HotelModel->getNumberRating();
                $Hotel[$key]['sodanhgia'] = $numberRating;

                $scoreRating = $this->HotelModel->getScoreRating();
                $Hotel[$key]['sodiem'] = $scoreRating;

                $imgsHotel = $this->HotelModel->getImagesHotel();
                $Hotel[$key]['anhks'] = $imgsHotel;
            }
        }


        $Services = $this->ServiceModel->getServices(6);

        $imgMainHotel = $this->HotelModel->getMainImageHotel();

        $ratingHotel = $this->RatingModel->getTotalRatingHotel();

        if ($ratingHotel) {
            foreach ($ratingHotel as $key => $item) {
                $ratingHotel[$key]['diemtheotieuchi'] = $this->RatingModel->getRatingHotel();
            }
        }

        $video = $this->HotelModel->getVideoHotel();

        //gọi và show dữ liệu ra view
        $this->view('user', 'about.php', [
            'hotel' => $Hotel,
            'services' => $Services,
            'imgMainHotel' => $imgMainHotel,
            'ratingHotel' => $ratingHotel,
            'video' => $video
        ]);
    }
}
