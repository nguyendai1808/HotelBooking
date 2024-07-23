<?php
class LoadPage extends Controller
{
    private $AccountModel;
    private $HotelModel;
    private $BookingModel;
    private $RatingModel;

    private $view;

    public function __construct($view)
    {
        $this->view = $view;
        $this->AccountModel = $this->model('AccountModel');
        $this->HotelModel = $this->model('HotelModel');

        if ($view == 'user') {
            $this->BookingModel = $this->model('BookingModel');
            $this->RatingModel = $this->model('RatingModel');
        }
    }

    public function LoadPage()
    {
        $loadpage['header'] = $this->header();
        $loadpage['footer'] = $this->footer();

        if ($this->view == 'user') {
            $loadpage['bookingForm'] = $this->bookingForm();
            $loadpage['comments'] = $this->comments();
        }

        return $loadpage ?? null;
    }

    public function header()
    {
        $User = $this->AccountModel->findAccountById(Session::get('user_id'));
        if ($this->view == 'user' && !empty($User)) {
            foreach ($User as $key => $item) {
                $User[$key]['sogiohang'] = $this->BookingModel->checkCartNumber($item['idtaikhoan']);
            }
        }
        $header = $User;
        return $header ?? null;
    }

    public function footer()
    {
        if ($this->view == 'user') {
            $footer =  $this->HotelModel->getHotel();
        } else {
            $footer = null;
        }
        return $footer ?? null;
    }

    public function bookingForm()
    {
        $bookingForm = [
            'checkin' => Session::get('checkin'),
            'checkout' => Session::get('checkout'),
            'adult' => Session::get('adult'),
            'child' => Session::get('child')
        ];
        return $bookingForm ?? null;
    }

    public function comments()
    {
        $comments = $this->RatingModel->displayCommentsWebsite();
        if ($comments) {
            foreach ($comments as $key => $item) {
                $account = $this->AccountModel->findAccountById($item['id_taikhoan']);
                foreach ($account as $row) {
                    $comments[$key]['tennguoidung'] = trim($row['ho'] . ' ' . $row['ten']);
                    $comments[$key]['anhdaidien'] = $row['anh'];
                }
            }
        }
        return $comments ?? null;
    }
}
