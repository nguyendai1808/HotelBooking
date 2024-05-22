<?php
class Room extends Controller
{
    protected $AccountModel;
    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('Accounts');
    }

    public function index()
    {
        $this->view('admin', 'room/room.php');
    }
}
