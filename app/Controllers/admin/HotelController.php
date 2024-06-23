<?php
class Hotel extends Controller
{
    protected $HotelModel;

    public function __construct()
    {
        //gọi model User
        $this->HotelModel = $this->model('HotelModel');
    }

    public function index()
    {
        $hotel = $this->HotelModel->getHotel();
        $listImg = $this->HotelModel->getImagesHotel();
        //view - page
        $this->view('admin', 'hotel/hotel.php', [
            'hotel' => $hotel,
            'listImg' => $listImg
        ]);
    }


    public function update()
    {
        $update = $this->HotelModel->updateHotel($_POST['name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['info'], $_POST['desc'], $_POST['video']);
        if ($update) {
            header('location:' . URLROOT . '/admin/hotel');
        } else {
            echo "<script>alert('lỗi')</script>";
        }
        header('location:' . URLROOT . '/admin/hotel');
    }

    public function uploadImages()
    {
        if (!empty($_FILES['images'])) {
            $response = ['status' => 'error', 'images' => []];
            $uploadDir = PUBLIC_PATH . '/user/images/hotel/';
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {

                $file_name = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];

                if (move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                    $imageId = $this->HotelModel->saveImage($file_name, 'images/hotel');
                    $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/hotel/' . $file_name];
                }
            }

            if (!empty($response['images'])) {
                $response['status'] = 'success';
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            header('location:' . URLROOT . '/admin/hotel');
        }
    }


    public function deleteImg()
    {
        if (isset($_POST['id'])) {
            $delete =  $this->HotelModel->deleteImage($_POST['id']);
            if ($delete) {
                echo 'success';
            } else {
                echo 'error';
            }
            return;
        } else {
            header('location:' . URLROOT . '/admin/hotel');
        }
    }
}
