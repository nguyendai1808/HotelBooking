<?php
class Customer extends Controller
{
    protected $CustomerModel;

    public function __construct()
    {
        //gọi model User
        $this->CustomerModel = $this->model('CustomerModel');
    }

    public function index()
    {
        $Customers =  $this->CustomerModel->getCustomerInvoice();

        $this->view('admin', 'customer/customer.php', [
            'customers' => $Customers
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
