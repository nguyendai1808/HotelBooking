<?php
class Hotel extends Controller
{
    protected $AccountModel;
    
    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
    }

    public function index()
    {
        //view - page
        $this->view('admin', 'hotel/hotel.php');
    }
}
