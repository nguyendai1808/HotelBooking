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
        $this->BookingModel = $this->model('BookingModel');
        $this->RatingModel = $this->model('RatingModel');
    }

    public function header()
    {
        $header = null;
        if ($this->view == 'user') {
            $User =  $this->AccountModel->findAccountById(Session::get('user_id'));

            if (!empty($User) && count($User) == 1) {
                foreach ($User as $key => $item) {
                    $User[$key]['sogiohang'] = $this->BookingModel->checkCartNumber($item['idtaikhoan']);
                }
            }
            $header = $User;
        } else {
            $User =  $this->AccountModel->findAccountById(Session::get('user_id'));
            $header = $User;
        }
        return $header;
    }

    public function bookingForm()
    {
        $bookingForm = null;
        if ($this->view == 'user') {
            $bookingForm = [
                'checkin' => Session::get('checkin'),
                'checkout' => Session::get('checkout'),
                'adult' => Session::get('adult'),
                'child' => Session::get('child')
            ];
        } else {
            $bookingForm = null;
        }
        return $bookingForm;
    }


    public function comments()
    {
        if ($this->view == 'user') {
            $comments = $this->RatingModel->displayCommentsWebsite(5);
            if ($comments) {
                foreach ($comments as $key => $item) {
                    $account = $this->AccountModel->findAccountById($item['id_taikhoan']);
                    foreach ($account as $row) {
                        $comments[$key]['tennguoidung'] = trim($row['ho'] . ' ' . $row['ten']);
                        $comments[$key]['anhdaidien'] = $row['anh'];
                    }
                }
            }
        }
        return $comments ?? null;
    }


    public function display()
    {
        $display = null;
        if ($this->view == 'user') {
            $display['baner'] = 'bg-img.jpg';
            $display['logo'] = 'HotelBooking-logo.png';
        }

        return $display ?? null;
    }



    public function footer()
    {
        $footer = null;
        if ($this->view == 'user') {
            $footer =  $this->HotelModel->getHotel();
        } else {
            $footer = null;
        }
        return $footer;
    }
}
