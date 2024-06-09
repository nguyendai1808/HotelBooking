<?php
class Amenity extends Controller
{
    private $AmenityModel;

    public function __construct()
    {
        //gọi model User
        $this->AmenityModel = $this->model('AmenityModel');
    }

    public function index()
    {
        $amenities  = $this->AmenityModel->getAmenities();
        $beds  = $this->AmenityModel->getBeds();

        $this->view('admin', 'amenity/amenity.php', [
            'amenities' => $amenities,
            'beds' => $beds
        ]);
    }

    public function create()
    {
        if (isset($_POST['create'])) {
            $name = $_POST["name"];

            $image = $_FILES['image']['name'];
            $tmp_img = $_FILES['image']['tmp_name'];
            $dir_img =  PUBLIC_PATH . '/user/images/amenities/';
            move_uploaded_file($tmp_img, $dir_img . $image);

            $result = $this->AmenityModel->createAmenity($name, $image);

            if ($result) {
                header('location:' . URLROOT . '/admin/amenity');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'amenity/create.php');
    }


    public function update($idtiennghi = null)
    {
        if (!empty($idtiennghi) && filter_var($idtiennghi, FILTER_VALIDATE_INT)) {

            if (isset($_POST['update'])) {
                $name = $_POST["name"];

                $image = $_FILES['image']['name'];
                $tmp_img = $_FILES['image']['tmp_name'];
                $dir_img =  PUBLIC_PATH . '/user/images/amenities/';
                move_uploaded_file($tmp_img, $dir_img . $image);

                $update = $this->AmenityModel->updateAmenity($idtiennghi, $name, $image);
                if ($update) {
                    header('location:' . URLROOT . '/admin/amenity');
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $amenity = $this->AmenityModel->findAmenityById($idtiennghi);
            $this->view('admin', 'amenity/update.php', [
                'amenity' => $amenity
            ]);
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }

    public function delete($idtiennghi = null)
    {
        if (!empty($idtiennghi) && filter_var($idtiennghi, FILTER_VALIDATE_INT)) {
            $delete = $this->AmenityModel->deleteAmenity($idtiennghi);
            if ($delete) {
                header('location:' . URLROOT . '/admin/amenity');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }
    
    public function createBed()
    {
        if (isset($_POST['createBed'])) {
            $name = $_POST["nameBed"];
            $result = $this->AmenityModel->createBed($name);
            if ($result) {
                header('location:' . URLROOT . '/admin/amenity');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'amenity/createBed.php');
    }


    public function updateBed($idgiuong = null)
    {
        if (!empty($idgiuong) && filter_var($idgiuong, FILTER_VALIDATE_INT)) {

            if (isset($_POST['updateBed'])) {
                $name = $_POST["nameBed"];

                $update = $this->AmenityModel->updateBed($idgiuong, $name);
                if ($update) {
                    header('location:' . URLROOT . '/admin/amenity');
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $bed = $this->AmenityModel->findBedById($idgiuong);
            $this->view('admin', 'amenity/updateBed.php', [
                'bed' => $bed
            ]);
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }

    public function deleteBed($idgiuong = null)
    {
        if (!empty($idgiuong) && filter_var($idgiuong, FILTER_VALIDATE_INT)) {
            $delete = $this->AmenityModel->deleteBed($idgiuong);
            if ($delete) {
                header('location:' . URLROOT . '/admin/amenity');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }
}
