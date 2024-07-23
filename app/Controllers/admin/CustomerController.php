<?php
class Customer extends Controller
{
    private $CustomerModel;

    private $pagination;
    private $per_page = 50;

    public function __construct()
    {
        $this->CustomerModel = $this->model('CustomerModel');
    }

    public function index()
    {
        $totalItems = $this->CustomerModel->countCustomerInvoice();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page);
            $Customers = $this->CustomerModel->getCustomerInvoiceByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $Customers = null;
            $pag = null;
        }

        $this->view('admin', 'customer/customer.php', [
            'customers' => $Customers,
            'pagination' => $pag
        ]);
    }

    public function page($current_page = 1)
    {
        $totalItems = $this->CustomerModel->countCustomerInvoice();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page, $current_page);
            $Customers = $this->CustomerModel->getCustomerInvoiceByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $Customers = null;
            $pag = null;
        }

        $this->view('admin', 'customer/customer.php', [
            'customers' => $Customers,
            'pagination' => $pag
        ]);
    }


    public function detail($idkhachhang)
    {
        if (!empty($idkhachhang) && filter_var($idkhachhang, FILTER_VALIDATE_INT)) {
            $bookings =  $this->CustomerModel->getInvoiceCustomerById($idkhachhang);

            $this->view('admin', 'customer/detail.php', [
                'bookings' => $bookings
            ]);
        } else {
            header('location:' . URLROOT . '/admin/customer');
        }
    }
}
