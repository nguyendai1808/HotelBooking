<?php
class Home extends Controller
{
    private $AccountModel;
    private $BookingModel;
    public function __construct()
    {
        //gọi model User
        $this->AccountModel = $this->model('AccountModel');
        $this->BookingModel = $this->model('BookingModel');
    }

    public function index()
    {
        $actual = $this->BookingModel->actualTotalRevenue();
        $estimated = $this->BookingModel->estimatedTotalRevenue();
        $deductible = $this->BookingModel->deductibleRevenue();

        $actualLM = $this->BookingModel->actualTotalRevenueLastMonth();
        $estimatedLM = $this->BookingModel->estimatedTotalRevenueLastMonth();
        $deductibleLM = $this->BookingModel->deductibleRevenueLastMonth();


        $dataPoints2 = array(
            array("label" => "Đã cọc tiền", "y" => $this->BookingModel->countNumberBookingByStatus('Đã cọc tiền')),
            array("label" => "Đã hủy", "y" => $this->BookingModel->countNumberBookingByStatus('Đã hủy')),
            array("label" => "Đã thanh toán", "y" => $this->BookingModel->countNumberBookingByStatus('Đã thanh toán')),
            array("label" => "Hoàn tất", "y" => $this->BookingModel->countNumberBookingByStatus('Hoàn tất'))
        );

        $months = array(
            "Th 1", "Th 2", "Th 3", "Th 4",
            "Th 5", "Th 6", "Th 7", "Th 8",
            "Th 9", "Th 10", "Th 11", "Th 12"
        );

        // Thêm dữ liệu vào $dataPoints1 và $dataPoints3
        for ($i = 0; $i < count($months); $i++) {
            $tmp = $this->BookingModel->countNumberBooking($i + 1);
            $tmp2 = $this->BookingModel->countTotalAmountBooking($i + 1);
            $dataPoints1[] = array("y" => $tmp, "label" => $months[$i]);
            $dataPoints3[] = array("y" => $tmp2, "label" => $months[$i]);
        }

        //view - page
        $this->view('admin', 'dashboard/home.php', [
            'actual' => $actual,
            'estimated' => $estimated,
            'deductible' => $deductible,
            'updownActual' => ($actual <= $actualLM) ? 'down' : 'up',
            'updownEstimated' => ($estimated <= $estimatedLM) ? 'down' : 'up',
            'updownDeductible' => ($deductible <= $deductibleLM) ? 'down' : 'up',

            'dataPoints1' => $dataPoints1,
            'dataPoints2' => $dataPoints2,
            'dataPoints3' => $dataPoints3
        ]);
    }
}
