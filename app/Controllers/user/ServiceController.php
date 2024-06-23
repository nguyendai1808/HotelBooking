<?php
class Service extends Controller
{
    private $ServiceModel;
    private $pagination;

    public function __construct()
    {
        //gọi model User
        $this->ServiceModel = $this->model('ServiceModel');

        //phân trang
        $per_page = 6;
        if (!empty(Session::get('services'))) {
            $services = Session::get('services');
            $this->pagination = new Pagination($services, $per_page);
        } else {
            $services = $this->ServiceModel->getServices();
            $this->pagination = new Pagination($services, $per_page);
            Session::set('services', $services, 1800);
        }
    }

    public function index()
    {
        $Services = $this->pagination->getItemsbyCurrentPage(1);

        $pag = [
            'total_pages' => $this->pagination->getTotalPages(),
            'current_page' => $this->pagination->getcurrentPage()
        ];

        //gọi và show dữ liệu ra view
        $this->view('user', 'service.php', [
            'services' => $Services,
            'pagination' => $pag
        ]);
    }

    public function page($current_page = 1)
    {
        if ($this->isAjaxRequest()) {
            // Xử lý yêu cầu AJAX
            $Services = $this->pagination->getItemsbyCurrentPage($current_page);
            $response = [
                'services' => $Services,

                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'service/page'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            if (!empty($current_page) && filter_var($current_page, FILTER_VALIDATE_INT)) {
                $Services = $this->pagination->getItemsbyCurrentPage($current_page);
                $pag = [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ];

                $this->view('user', 'service.php', [
                    'services' => $Services,
                    'pagination' => $pag
                ]);
            } else {
                header('location:' . URLROOT . '/service');
            }
        }
    }
}
