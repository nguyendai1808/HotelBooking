<?php
class Information extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        //gọi và show dữ liệu ra view
        $this->view('user', '404.php', []);
    }
}
