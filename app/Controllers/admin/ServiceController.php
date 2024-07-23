<?php
class Service extends Controller
{
    private $ServiceModel;

    public function __construct()
    {
        $this->ServiceModel = $this->model('ServiceModel');
    }

    public function index()
    {
        $services  = $this->ServiceModel->getServices();
        $paytypes  = $this->ServiceModel->getPayTypes();

        $this->view('admin', 'service/service.php', [
            'services' => $services,
            'paytypes' => $paytypes
        ]);
    }

    public function create()
    {
        if (isset($_POST['create'])) {
            $name = $_POST["name"];
            $desc = $_POST["desc"];

            $image = $_FILES['image']['name'];
            $tmp_img = $_FILES['image']['tmp_name'];

            $timestamp = time();
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $new_image_name = 'service_img_' . $timestamp . '.' . $image_extension;
            $dir_img = PUBLIC_PATH . '/user/images/services/';
            move_uploaded_file($tmp_img, $dir_img . $new_image_name);

            $result = $this->ServiceModel->createServices($name, $desc, $new_image_name);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                exit();
            } else {
                echo "<script> alert('Lỗi'); </script>";
                exit();
            }
        }
        $this->view('admin', 'service/create.php');
    }


    public function update($iddichvu = null)
    {
        if (!empty($iddichvu) && filter_var($iddichvu, FILTER_VALIDATE_INT)) {

            if (isset($_POST['update'])) {
                $name = $_POST["name"];
                $desc = $_POST["desc"];

                if (!empty($_FILES['image']['name'])) {
                    $dir_img = PUBLIC_PATH . '/user/images/services/';

                    $old_image = $this->ServiceModel->getServiceImageById($iddichvu);
                    if ($old_image && file_exists($dir_img . $old_image)) {
                        unlink($dir_img . $old_image);
                    }

                    $image = $_FILES['image']['name'];
                    $tmp_img = $_FILES['image']['tmp_name'];

                    $timestamp = time();
                    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
                    $new_image_name = 'service_img_' . $timestamp . '.' . $image_extension;
                    move_uploaded_file($tmp_img, $dir_img . $new_image_name);
                } else {
                    $new_image_name = null;
                }

                $update = $this->ServiceModel->updateServices($iddichvu, $name, $desc, $new_image_name);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }

            $service = $this->ServiceModel->findServiceById($iddichvu);
            $this->view('admin', 'service/update.php', [
                'service' => $service
            ]);
        } else {
            header('location:' . URLROOT . '/admin/service');
        }
    }

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $iddichvu = $_POST['delete'];
            $dir_img = PUBLIC_PATH . '/user/images/services/';
            $old_image = $this->ServiceModel->getServiceImageById($iddichvu);

            $delete = $this->ServiceModel->deleteService($iddichvu);
            if ($delete) {
                if ($old_image && file_exists($dir_img . $old_image)) {
                    unlink($dir_img . $old_image);
                }
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        } else {
            header('Location: ' . URLROOT . '/admin/service');
            exit();
        }
    }

    //loại hình thanh toán
    public function createPayType()
    {
        if (isset($_POST['createPayType'])) {
            $result = $this->ServiceModel->createPaytype($_POST["namePayType"]);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'service/create_pay_type.php');
    }

    public function updatePayType($idloaihinhtt = null)
    {
        if (!empty($idloaihinhtt) && filter_var($idloaihinhtt, FILTER_VALIDATE_INT)) {

            if (isset($_POST['updatePayType'])) {
                $update = $this->ServiceModel->updatePayType($idloaihinhtt, $_POST["namePayType"]);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }

            $payType = $this->ServiceModel->findPayTypeById($idloaihinhtt);
            $this->view('admin', 'service/update_pay_type.php', [
                'payType' => $payType
            ]);
        } else {
            header('location:' . URLROOT . '/admin/service');
        }
    }

    public function deletePayType()
    {
        if (isset($_POST['deletePayType'])) {
            $delete = $this->ServiceModel->deletePayType($_POST['deletePayType']);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/service';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/service');
        }
    }
}
