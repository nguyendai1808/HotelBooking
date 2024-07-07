<?php
class Rating extends Controller
{
    private $RatingModel;
    public function __construct()
    {
        //gọi model User
        $this->RatingModel = $this->model('RatingModel');
    }

    public function index()
    {
        $ratings = $this->RatingModel->getRatings();

        $this->view('admin', 'rating/rating.php', [
            'ratings' => $ratings
        ]);
    }

    public function website($iddanhgia)
    {
        if (!empty($iddanhgia) && filter_var($iddanhgia, FILTER_VALIDATE_INT)) {
            $status = 'Website';
            $update = $this->RatingModel->updateRating($iddanhgia, $status);
            if ($update) {
                echo "<script> alert('Chuyển thành công');
                        window.location.href = '" . URLROOT . "/admin/rating';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/rating');
        }
    }

    public function hidden($iddanhgia)
    {
        if (!empty($iddanhgia) && filter_var($iddanhgia, FILTER_VALIDATE_INT)) {
            $status = 'Ẩn';
            $update = $this->RatingModel->updateRating($iddanhgia, $status);
            if ($update) {
                echo "<script> alert('Chuyển thành công');
                        window.location.href = '" . URLROOT . "/admin/rating';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/rating');
        }
    }

    public function display($iddanhgia)
    {
        if (!empty($iddanhgia) && filter_var($iddanhgia, FILTER_VALIDATE_INT)) {
            $status = 'Hiển thị';
            $update = $this->RatingModel->updateRating($iddanhgia, $status);
            if ($update) {
                echo "<script> alert('Chuyển thành công');
                        window.location.href = '" . URLROOT . "/admin/rating';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/rating');
        }
    }
}
