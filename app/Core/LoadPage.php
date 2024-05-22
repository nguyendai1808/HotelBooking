<?php
class LoadPage extends Controller
{
    private $AccountModel;
    private $HotelModel;
    private $BookingModel;

    private $view;

    public function __construct($view)
    {
        $this->view = $view;
        $this->AccountModel = $this->model('Accounts');
        $this->HotelModel = $this->model('Hotel');
        $this->BookingModel = $this->model('Bookings');
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
            $header = null;
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
