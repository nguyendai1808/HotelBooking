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

            $result = $this->CategoryModel->createCategory(null,$_POST['name']);
            if ($result) {
                header('location:' . URLROOT . '/admin/category');
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
                    header('location:' . URLROOT . '/admin/category');
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
        if (!empty($iddanhmuc)) {
            $delete = $this->CategoryModel->deleteCategory($iddanhmuc);
            if ($delete) {
                header('location:' . URLROOT . '/admin/category');
            } else {
                echo '<script>alert("lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/category');
        }
    }
}
