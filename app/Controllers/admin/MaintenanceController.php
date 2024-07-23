<?php
class Maintenance extends Controller
{
    private $MaintenanceModel;
    private $RoomModel;

    public function __construct()
    {
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


    public function getInfoRoomMore($Rooms)
    {
        if ($Rooms) {
            foreach ($Rooms as $key => $room) {
                $mainImg = $this->RoomModel->getMainImageRoom($room['idphong']);
                $Rooms[$key]['anhphong'] = $mainImg;
                $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                $Rooms[$key]['tengiuong'] = $nameBed;
            }
        }
        return $Rooms;
    }

    public function detail($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {

            $rooms = $this->MaintenanceModel->getRoomMaintenanceById($idbaotri);

            $time = $this->MaintenanceModel->findMaintenanceById($idbaotri);
            $this->view('admin', 'maintenance/detail.php', [
                'rooms' => $this->getInfoRoomMore($rooms),
                'idbaotri' => $idbaotri,
                'time' => $time
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function create()
    {
        if (isset($_POST['create'])) {
            $result = $this->MaintenanceModel->createMaintenance($_POST['name'], $_POST['dateStart'], $_POST['dateEnd'], $_POST['desc']);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }
        $this->view('admin', 'maintenance/create.php');
    }

    public function update($idbaotri = null)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            if (isset($_POST['update'])) {
                $update = $this->MaintenanceModel->updateMaintenance($idbaotri,  $_POST['name'], $_POST['dateStart'], $_POST['dateEnd'], $_POST['desc']);
                if ($update) {
                    echo "<script> alert('Lưu thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
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

    public function delete()
    {
        if (isset($_POST['delete'])) {
            $delete = $this->MaintenanceModel->deleteMaintenance($_POST['delete']);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
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
                    echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance/detail/$idbaotri';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }
            $this->view('admin', 'maintenance/create_room.php', [
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
                    echo "<script> alert('Lưu thông tin thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance/detail/$idbaotri';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }

            $this->view('admin', 'maintenance/update_room.php', [
                'room' => $room,
                'idbaotri' => $idbaotri
            ]);
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }

    public function deleteRoom($idbaotri)
    {
        if (!empty($idbaotri) && filter_var($idbaotri, FILTER_VALIDATE_INT)) {
            if (isset($_POST['deleteRoom'])) {
                $idphong = $_POST['deleteRoom'];
                $delete = $this->MaintenanceModel->deleteMaintenanceCT($idphong, $idbaotri);
                if ($delete) {
                    echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/maintenance/detail/$idbaotri';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("Lỗi")</script>';
                    exit();
                }
            }
        } else {
            header('location:' . URLROOT . '/admin/maintenance');
        }
    }
}
