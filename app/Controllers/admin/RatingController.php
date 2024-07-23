<?php
class Rating extends Controller
{
    private $RatingModel;

    private $pagination;
    private $per_page = 50;

    public function __construct()
    {
        $this->RatingModel = $this->model('RatingModel');
    }

    public function index()
    {
        $ratings = $this->RatingModel->getRatings();
        $totalItems = count($ratings ?? 0);
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page);
            $ratings = $this->RatingModel->getRatingByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $ratings = null;
            $pag = null;
        }

        $this->view('admin', 'rating/rating.php', [
            'ratings' => $ratings,
            'pagination' => $pag
        ]);
    }

    public function action()
    {
        if (isset($_POST['website'])) {
            $update = $this->RatingModel->updateRating($_POST['website'], 'Website');
            if ($update) {
                echo "<script> alert('Chuyển thành công trạng thái hiển thị website');
                    window.history.back();
                </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['display'])) {
            $update = $this->RatingModel->updateRating($_POST['display'], 'Hiển thị');
            if ($update) {
                echo "<script> alert('Chuyển thành công trạng thái hiển thị');
                    window.history.back();
                </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['delete'])) {
            $delete = $this->RatingModel->deleteRating($_POST['delete']);
            if ($delete) {
                echo "<script> alert('Đã xóa bình luận thành công');
                    window.history.back();
                </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['detail'])) {
            header('location:' . URLROOT . '/room/detailroom/' . $_POST['detail']);
        } else {
            header('location:' . URLROOT . '/admin/rating');
        }
    }

    public function page($current_page = 1)
    {
        $ratings = $this->RatingModel->getRatings();
        $totalItems = count($ratings ?? 0);
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page, $current_page);
            $ratings = $this->RatingModel->getRatingByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $ratings = null;
            $pag = null;
        }

        $this->view('admin', 'rating/rating.php', [
            'ratings' => $ratings,
            'pagination' => $pag
        ]);
    }
}
