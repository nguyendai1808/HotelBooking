<?php
class Home extends Controller
{
    protected $AccountModel;
    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('Accounts');
    }

    public function index()
    {
        //view - page
        $this->view('admin', 'dashboard/home.php');
    }
}
