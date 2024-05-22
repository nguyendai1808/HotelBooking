<?php
class History extends Controller
{
    protected $HistoryModel;
    public function __construct()
    {
        //gọi model
        $this->HistoryModel = $this->model('Bookings');
    }

    public function index()
    {
        //gọi method
        // $History  = $this->HistoryModel->getHistory();

        //gọi và show dữ liệu ra view
        $this->view('user', 'history.php');
    }
}
