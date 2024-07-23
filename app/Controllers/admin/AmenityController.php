<?php
class Amenity extends Controller
{
    private $AmenityModel;

    public function __construct()
    {
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

            $timestamp = time();
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $new_image_name = 'amenity_img_' . $timestamp . '.' . $image_extension;
            $dir_img = PUBLIC_PATH . '/user/images/amenities/';
            move_uploaded_file($tmp_img, $dir_img . $new_image_name);

            $result = $this->AmenityModel->createAmenity($name, $new_image_name);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                    window.location.href = '" . URLROOT . "/admin/amenity';
                </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
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

                if (!empty($_FILES['image']['name'])) {
                    $dir_img = PUBLIC_PATH . '/user/images/amenities/';

                    $old_image = $this->AmenityModel->getAmenityImageById($idtiennghi);
                    if ($old_image && file_exists($dir_img . $old_image)) {
                        unlink($dir_img . $old_image);
                    }

                    $image = $_FILES['image']['name'];
                    $tmp_img = $_FILES['image']['tmp_name'];

                    $timestamp = time();
                    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
                    $new_image_name = 'amenity_img_' . $timestamp . '.' . $image_extension;
                    move_uploaded_file($tmp_img, $dir_img . $new_image_name);
                } else {
                    $new_image_name = null;
                }

                $update = $this->AmenityModel->updateAmenity($idtiennghi, $name, $new_image_name);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/amenity';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
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

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $idtiennghi = $_POST['delete'];
            $dir_img = PUBLIC_PATH . '/user/images/amenities/';
            $old_image = $this->AmenityModel->getAmenityImageById($idtiennghi);

            $delete = $this->AmenityModel->deleteAmenity($idtiennghi);
            if ($delete) {
                if ($old_image && file_exists($dir_img . $old_image)) {
                    unlink($dir_img . $old_image);
                }
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/amenity';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }

    //bed-------------------------------

    public function createBed()
    {
        if (isset($_POST['createBed'])) {
            $name = $_POST["nameBed"];
            $result = $this->AmenityModel->createBed($name);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/amenity';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'amenity/create_bed.php');
    }


    public function updateBed($idgiuong = null)
    {
        if (!empty($idgiuong) && filter_var($idgiuong, FILTER_VALIDATE_INT)) {

            if (isset($_POST['updateBed'])) {
                $name = $_POST["nameBed"];

                $update = $this->AmenityModel->updateBed($idgiuong, $name);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/amenity';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $bed = $this->AmenityModel->findBedById($idgiuong);
            $this->view('admin', 'amenity/update_bed.php', [
                'bed' => $bed
            ]);
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }

    public function deleteBed()
    {
        if (isset($_POST['deleteBed'])) {
            $delete = $this->AmenityModel->deleteBed($_POST['deleteBed']);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/amenity';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/amenity');
        }
    }
}
