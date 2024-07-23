<?php
class Controller
{
    public function model($model)
    {
        require_once "./app/Models/" . $model . ".php";
        return new $model;
    }

    public function view($view, $page, $data = [])
    {
        $loadpage = new LoadPage($view);
        $data['loadpage'] = $loadpage->LoadPage();
        require_once "./app/Views/" . $view . "/index.php";
    }

    // Phương thức để kiểm tra yêu cầu có phải là AJAX hay không
    public function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
