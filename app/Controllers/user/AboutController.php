<?php
class About extends Controller
{
    protected $HotelModel;
    protected $ServiceModel;

    public function __construct()
    {

        // $this->HotelModel = $this->model('HotelModel');
        // $this->RoomModel = $this->model('RoomModel');
        // $this->ServiceModel = $this->model('ServiceModel');
    }

    public function index()
    {
        //gọi và show dữ liệu ra view
        $this->view('user', 'about.php', []);
    }
}
