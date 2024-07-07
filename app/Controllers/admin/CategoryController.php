<?php
class Category extends Controller
{
    private $CategoryModel;
    public function __construct()
    {
        //gọi model
        $this->CategoryModel = $this->model('CategoryModel');
    }

    public function index()
    {
        //gọi method
        $category  = $this->CategoryModel->getCategorys();

        //view - page
        $this->view('admin', 'category/category.php', [
            'category' => $category
        ]);
    }

    public function create()
    {
        if (isset($_POST['create'])) {

            $result = $this->CategoryModel->createCategory($_POST['name'], $_POST['desc']);
            if ($result) {
                echo "<script> alert('Thêm thành công');
                        window.location.href = '" . URLROOT . "/admin/category';
                    </script>";
                exit();
            }
        }
        $this->view('admin', 'category/create.php');
    }


    public function update($iddanhmuc = null)
    {
        if (!empty($iddanhmuc) && filter_var($iddanhmuc, FILTER_VALIDATE_INT)) {

            if (isset($_POST['update'])) {
                $update = $this->CategoryModel->updateCategory($iddanhmuc, $_POST['name'], $_POST['desc']);
                if ($update) {
                    echo "<script> alert('Cập nhật thành công');
                        window.location.href = '" . URLROOT . "/admin/category';
                    </script>";
                    exit();
                } else {
                    echo '<script>alert("lỗi")</script>';
                    exit();
                }
            }

            $findCate = $this->CategoryModel->findCategoryById($iddanhmuc);
            $this->view('admin', 'category/update.php', [
                'findCate' => $findCate
            ]);
        } else {
            header('location:' . URLROOT . '/admin/category');
        }
    }

    public function delete($iddanhmuc = null)
    {
        if (!empty($iddanhmuc) && filter_var($iddanhmuc, FILTER_VALIDATE_INT)) {
            $delete = $this->CategoryModel->deleteCategory($iddanhmuc);
            if ($delete) {
                echo "<script> alert('Xóa thành công');
                        window.location.href = '" . URLROOT . "/admin/category';
                    </script>";
                exit();
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/category');
        }
    }
}
