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

        $this->view('admin', 'service/service.php', [
            'services' => $services
        ]);
    }

    public function create()
    {
        if (isset($_POST['create'])) {
            $name = $_POST["name"];
            $desc = $_POST["desc"];

            $image = $_FILES['image']['name'];
            $tmp_img = $_FILES['image']['tmp_name'];
            $dir_img =  PUBLIC_PATH . '/user/images/services/';
            move_uploaded_file($tmp_img, $dir_img . $image);

            $result = $this->ServiceModel->createServices($name, $desc, $image);

            if ($result) {
                header('location:' . URLROOT . '/admin/service');
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

                $image = $_FILES['image']['name'];
                $tmp_img = $_FILES['image']['tmp_name'];
                $dir_img =  PUBLIC_PATH . '/user/images/services/';
                move_uploaded_file($tmp_img, $dir_img . $image);

                $update = $this->ServiceModel->updateServices($iddichvu, $name, $desc, $image);
                if ($update) {
                    header('location:' . URLROOT . '/admin/service');
                } else {
                    echo '<script>alert("lỗi")</script>';
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

    public function delete($iddichvu = null)
    {
        if (!empty($iddichvu)) {
            $delete = $this->ServiceModel->deleteService($iddichvu);
            if ($delete) {
                header('location:' . URLROOT . '/admin/service');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/service');
        }
    }
}
