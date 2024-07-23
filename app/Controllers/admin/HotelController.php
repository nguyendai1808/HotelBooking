<?php
class Hotel extends Controller
{
    private $HotelModel;

    public function __construct()
    {
        $this->HotelModel = $this->model('HotelModel');
    }

    public function index()
    {
        $hotel = $this->HotelModel->getHotel();
        $listImg = $this->HotelModel->getImagesHotel();

        $this->view('admin', 'hotel/hotel.php', [
            'hotel' => $hotel,
            'listImg' => $listImg
        ]);
    }


    public function update()
    {
        $update = $this->HotelModel->updateHotel($_POST['name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['info'], $_POST['desc'], $_POST['video']);
        if ($update) {
            echo "<script> alert('Cập nhật thành công');
                window.location.href = '" . URLROOT . "/admin/hotel';
            </script>";
            exit();
        } else {
            echo "<script>alert('Lỗi')</script>";
            exit();
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

                $timestamp = time();
                $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $new_file_name = 'hotel_img_' . $timestamp . '_' . $key . '.' . $file_extension;

                if (move_uploaded_file($file_tmp, $uploadDir . $new_file_name)) {
                    $imageId = intval($this->HotelModel->getMaxIdImageHotel()) + 1;
                    $this->HotelModel->saveImage($imageId, $new_file_name, 'images/hotel');
                    $response['images'][] = ['id' => $imageId, 'url' => USER_PATH . '/images/hotel/' . $new_file_name];
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
            $dir_img = PUBLIC_PATH . '/user/images/hotel/';
            $old_image = $this->HotelModel->getHotelImageById($_POST['id']);

            $delete =  $this->HotelModel->deleteImage($_POST['id']);
            if ($delete) {
                if ($old_image && file_exists($dir_img . $old_image)) {
                    unlink($dir_img . $old_image);
                }
                $response = 'success';
            } else {
                $response = 'error';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            header('location:' . URLROOT . '/admin/hotel');
        }
    }
}
