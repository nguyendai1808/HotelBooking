<?php
class Service extends Controller
{
    private $ServiceModel;
    private $pagination;
    private $per_page = 6;

    public function __construct()
    {
        $this->ServiceModel = $this->model('ServiceModel');

        if (!empty(Session::get('services'))) {
            $totalItems = count(Session::get('services'));
            $this->pagination = new Pagination($totalItems, $this->per_page);
        } else {
            $services = $this->ServiceModel->getServices();
            if ($services) {
                $totalItems = count($services);
                $this->pagination = new Pagination($totalItems, $this->per_page);
                Session::set('services', $services, 1800);
            }
        }
    }

    public function index()
    {
        $services = Session::get('services');

        $Services = $this->pagination->getItemsbyCurrentPage($services, 1);
        $pag = [
            'total_pages' => $this->pagination->getTotalPages(),
            'current_page' => $this->pagination->getcurrentPage()
        ];

        $this->view('user', 'service.php', [
            'services' => $Services,
            'pagination' => $pag
        ]);
    }

    public function page($current_page = 1)
    {
        $services = Session::get('services');

        if ($this->isAjaxRequest()) {

            $Services = $this->pagination->getItemsbyCurrentPage($services, $current_page);
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

                $Services = $this->pagination->getItemsbyCurrentPage($services, $current_page);
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
