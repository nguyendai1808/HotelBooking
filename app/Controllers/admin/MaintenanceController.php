<?php
class Maintenance extends Controller
{
    private $MaintenanceModel;
    private $RoomModel;

    public function __construct()
    {
        //gọi model User
        $this->MaintenanceModel = $this->model('MaintenanceModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        $maintenances  = $this->MaintenanceModel->getMaintenances();

        $this->view('admin', 'maintenance/maintenance.php', [
            'maintenances' => $maintenances
        ]);
    }


    public function detail($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {

            $rooms = $this->MaintenanceModel->getRoomMaintenanceById($idbaotri);

            $time = $this->MaintenanceModel->findMaintenanceById($idbaotri);
            $this->view('admin', 'maintenance/detail.php', [
                'rooms' => $this->getRoomMore($rooms),
                'idbaotri' => $idbaotri,
                'time' => $time
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function getRoomMore($Rooms)
    {
        foreach ($Rooms as $key => $room) {

            $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
            $Rooms[$key]['anhphong'] = $mainImg;
            $nameBed = $this->RoomModel->getNameBed($room['idphong']);
            $Rooms[$key]['tengiuong'] = $nameBed;
        }
        return $Rooms;
    }


    public function create()
    {
        if (isset($_POST['create'])) {
            $name = $_POST['name'];
            $start = $_POST['dateStart'];
            $end = $_POST['dateEnd'];
            $desc = $_POST['desc'];
            $result = $this->MaintenanceModel->createMaintenance($name, $start, $end, $desc);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'maintenance/create.php');
    }

    public function update($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $start = $_POST['dateStart'];
                $end = $_POST['dateEnd'];
                $desc = $_POST['desc'];
                $update = $this->MaintenanceModel->updateMaintenance($idbaotri, $name, $start, $end, $desc);
                if ($update) {
                    echo "<script> alert('Lưu thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $maintenance = $this->MaintenanceModel->findMaintenanceById($idbaotri);
            $this->view('admin', 'maintenance/update.php', [
                'maintenance' => $maintenance
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function delete($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            $delete = $this->MaintenanceModel->deleteMaintenance($idbaotri);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function createRoom($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            $rooms = $this->MaintenanceModel->getRoomNoMaintenance($idbaotri);

            if (isset($_POST['createRoom'])) {
                $result = $this->MaintenanceModel->createMaintenanceCT($_POST['idphong'], $_POST['idbaotri'], $_POST['soluong']);
                if ($result) {
                    echo "<script> alert('Thêm thành công');</script>";
                    $this->detail($idbaotri);
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }
            $this->view('admin', 'maintenance/createRoom.php', [
                'rooms' => $rooms,
                'idbaotri' => $idbaotri
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }


    public function updateRoom($idphong, $idbaotri)
    {
        if (!empty($idbaotri) && !empty($idphong) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            $room = $this->MaintenanceModel->getRoomMaintenance($idphong, $idbaotri);

            if (isset($_POST['updateRoom'])) {
                $result = $this->MaintenanceModel->updateMaintenanceROom($_POST['idphong'], $_POST['idbaotri'], $_POST['soluong']);
                if ($result) {
                    echo "<script> alert('lưu thông tin thành công');</script>";
                    $this->detail($idbaotri);
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $this->view('admin', 'maintenance/updateRoom.php', [
                'room' => $room,
                'idbaotri' => $idbaotri
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function deleteRoom($idphong, $idbaotri)
    {
        if (!empty($idbaotri) && !empty($idphong) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            $delete = $this->MaintenanceModel->deleteMaintenanceCT($idphong, $idbaotri);
            if ($delete) {
                echo "<script> alert('Xóa thành công');</script>";
                $this->detail($idbaotri);
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }
}
