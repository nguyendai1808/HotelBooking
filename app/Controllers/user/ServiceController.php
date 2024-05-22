<?php
class Service extends Controller
{
    private $ServiceModel;

    private $pagination;
    
    private $Services;


    public function __construct()
    {
        //gọi model User
        $this->ServiceModel = $this->model('Services');

        //phân trang
        $per_page = 6;
        $services = $this->ServiceModel->getServices();
        $this->pagination = new Pagination($services, $per_page);

        $this->Services = $this->pagination->getItemsbyCurrentPage(1);
    }

    public function index()
    {
        $pag = [
            'total_pages' => $this->pagination->getTotalPages(),
            'current_page' => $this->pagination->getcurrentPage()
        ];

        //gọi và show dữ liệu ra view
        $this->view('user', 'service.php', [
            'services' => $this->Services,
            'pagination' => $pag
        ]);
    }

    public function page($current_page = 1)
    {
        if ($this->isAjaxRequest()) {
            // Xử lý yêu cầu AJAX
            $this->Services = $this->pagination->getItemsbyCurrentPage($current_page);
            $response = [
                'services' => $this->Services,

                'pagination' => [
                    'total_pages' => $this->pagination->getTotalPages(),
                    'current_page' => $this->pagination->getcurrentPage()
                ],
                'view' => 'service'
            ];

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {

            $this->Services = $this->pagination->getItemsbyCurrentPage($current_page);
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];

            $this->view('user', 'service.php', [
                'services' => $this->Services,
                'pagination' => $pag
            ]);
        }
    }

}
