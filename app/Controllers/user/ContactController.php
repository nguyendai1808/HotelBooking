<?php
class Contact extends Controller
{
    protected $HotelModel;
    protected $ServiceModel;

    public function __construct()
    {
        //gọi model User
        // $this->AccountModel = $this->model('AccountModel');
        // $this->HotelModel = $this->model('HotelModel');
        // $this->RoomModel = $this->model('RoomModel');
        // $this->ServiceModel = $this->model('ServiceModel');
    }

    public function index()
    {
        //gọi method
        // $Account  = $this->AccountModel->findAccountById();

        //gọi và show dữ liệu ra view
        $this->view('user', 'contact.php', []);
    }

    // public function create()
    // {
    //     if (isset($_POST['submit'])) {
    //         $result = $this->AccountModel->createUser($_POST['Name'], $_POST['Email'], $_POST['Address']);
    //         if ($result) {
    //             header('location:' . URLROOT . '/views/index');
    //         }
    //     }
    //     $this->view('create');
    // }

    // public function update($id)
    // {

    //     $findUser = $this->AccountModel->findUserById($id);

    //     if (isset($_POST['submit'])) {
    //         $update = $this->AccountModel->updateUser($id, $_POST['Name'], $_POST['Email'], $_POST['Address']);
    //         if ($update) {
    //             header('location:' . URLROOT . '/views/index');
    //         }
    //     }

    //     $this->view('update', [
    //         'findUser' => $findUser
    //     ]);
    // }

    // public function delete($id)
    // {
    //     $delete = $this->AccountModel->deleteUser($id);
    //     if ($delete) {
    //         header('location:' . URLROOT . '/views/index');
    //     }
    //     $this->view('index');
    // }
}
