<?php
class Information extends Controller
{
    public function index()
    {
        $this->view('user', '404.php', []);
    }
}
