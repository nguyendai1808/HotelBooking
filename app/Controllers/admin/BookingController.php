<?php

require_once './vendor/autoload.php';

class Booking extends Controller
{
    private $HotelModel;
    private $BookingModel;
    private $CustomerModel;
    private $RoomModel;

    private $pagination;
    private $per_page = 20;

    public function __construct()
    {
        $this->HotelModel = $this->model('HotelModel');
        $this->BookingModel = $this->model('BookingModel');
        $this->CustomerModel = $this->model('CustomerModel');
        $this->RoomModel = $this->model('RoomModel');
    }

    public function index()
    {
        $totalItems = $this->BookingModel->countBookingsInvoice();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page);
            $bookings = $this->BookingModel->getBookingsInvoiceByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            foreach ($bookings as $key => $item) {
                $name = $this->CustomerModel->getNameCustomer($item['id_khachhang']);
                $bookings[$key]['tenkhachhang'] = $name;
            }
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $bookings = null;
            $pag = null;
        }

        $this->view('admin', 'booking/booking.php', [
            'bookings' => $bookings,
            'pagination' => $pag
        ]);
    }


    public function page($current_page = 1)
    {
        $totalItems = $this->BookingModel->countBookingsInvoice();
        if ($totalItems) {
            $this->pagination = new Pagination($totalItems, $this->per_page, $current_page);
            $bookings = $this->BookingModel->getBookingsInvoiceByPage($this->pagination->getPerPage(), $this->pagination->getOffset());
            foreach ($bookings as $key => $item) {
                $name = $this->CustomerModel->getNameCustomer($item['id_khachhang']);
                $bookings[$key]['tenkhachhang'] = $name;
            }
            $pag = [
                'total_pages' => $this->pagination->getTotalPages(),
                'current_page' => $this->pagination->getcurrentPage()
            ];
        } else {
            $bookings = null;
            $pag = null;
        }

        $this->view('admin', 'booking/booking.php', [
            'bookings' => $bookings,
            'pagination' => $pag
        ]);
    }

    public function action()
    {
        if (isset($_POST['cancelInvoice'])) {
            $iddondat = $_POST['cancelInvoice'];
            $cancel = $this->BookingModel->cancelInvoice($iddondat);
            if ($cancel) {
                echo "<script> alert('Hủy thành công đơn đặt: $iddondat');
                        window.location.href = '" . URLROOT . "/admin/booking';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['paymentBooking'])) {
            $iddondat = $_POST['paymentBooking'];
            $update = $this->BookingModel->paymentBooking($iddondat);
            if ($update) {
                echo "<script> alert('Thanh toán thành công đơn đặt: $iddondat');
                        window.location.href = '" . URLROOT . "/admin/booking';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        }

        if (isset($_POST['completedInvoice'])) {
            $iddondat = $_POST['completedInvoice'];
            $update = $this->BookingModel->completedInvoice($iddondat);
            if ($update) {
                echo "<script> alert('Hoàn tất thành công đơn đặt: $iddondat');
                        window.location.href = '" . URLROOT . "/admin/booking';
                    </script>";
                exit();
            } else {
                echo '<script>alert("Lỗi")</script>';
                exit();
            }
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function detailInvoice($iddondat)
    {
        if (!empty($iddondat) && filter_var($iddondat, FILTER_VALIDATE_INT)) {
            $bookings = $this->BookingModel->getBookingsById($iddondat);

            if ($bookings) {
                foreach ($bookings as $key => $room) {
                    $nameBed = $this->RoomModel->getNameBed($room['idphong']);
                    $bookings[$key]['tengiuong'] = $nameBed;
                }
            }

            $this->view('admin', 'booking/detail.php', [
                'bookings' => $bookings
            ]);
        } else {
            header('location:' . URLROOT . '/admin/booking');
        }
    }

    public function exportPDF()
    {
        if (isset($_POST['exportPDF'])) {
            $iddondat = $_POST['exportPDF'];
            $hotel = $this->HotelModel->getInfoExport();
            $invoice = $this->BookingModel->getInfoExportInvoice($iddondat);

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // Đặt thông tin tài liệu
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($hotel[0]['tenkhachsan']);
            $pdf->SetTitle('Hóa đơn đặt phòng');
            $pdf->SetSubject('Hóa đơn đặt phòng');
            $pdf->SetKeywords('TCPDF, PDF, invoice, hotel');

            // Thiết lập thông tin mặc định
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

            // Thêm trang
            $pdf->AddPage();

            // Đặt font
            $pdf->SetFont('dejavusans', '', 10);

            // Nội dung hóa đơn
            $html = '
            <table border="0">
                <tr>
                    <td><h1>' . $hotel[0]['tenkhachsan'] . '</h1></td>
                </tr>
                <tr>
                    <td>Địa chỉ: ' . $hotel[0]['diachi'] . '</td>
                </tr>
                <tr>
                    <td>Hotline: ' . $hotel[0]['sdt'] . '</td>
                </tr>
            </table>
            <br>
            <br>
            <table border="0">
                <tr>
                    <td><b>Hóa đơn đặt phòng</b></td>
                    <td align="right">Ngày đặt: ' . date('d-m-Y', strtotime($invoice[0]['thoigiandat'])) . '</td>
                </tr>
                <tr>
                    <td><b>Trạng thái: ' . $invoice[0]['trangthaidon'] . '</b></td>
                    <td align="right">Thời gian in: ' . date('d-m-Y') . '</td>
                </tr>
            </table>
            <br>
            <br>
            <table border="1" cellpadding="5">
                <tr>
                    <th><b>Tên phòng</b></th>
                    <th><b>Thời gian</b></th>
                    <th><b>Số lượng</b></th>
                    <th><b>Giá</b></th>
                </tr>';

            $tonggia = 0;
            // Thêm dữ liệu đặt phòng vào bảng
            foreach ($invoice as $item) {
                $html .= '
                <tr>
                    <td>' . $item['tenphong'] . '</td>
                    <td>' . $item['ngayden'] . ' - ' . $item['ngaydi'] . '</td>
                    <td>' . $item['soluongdat'] . '</td>
                    <td>' . number_format($item['tonggia'], 0, ',', '.') . ' VND</td>
                </tr>';
                $tonggia += $item['tonggia'];
            }

            $html .= '
                <tr>
                    <td colspan="3" align="right"><b>Tổng giá</b></td>
                    <td><b>' . number_format($tonggia, 0, ',', '.') . ' VND</b></td>
                </tr>
            </table>
            <br>
            <h1>Cảm ơn quý khách!</h1>';

            // In nội dung HTML
            $pdf->writeHTML($html, true, false, true, false, '');

            // Xóa bộ đệm đầu ra để tránh lỗi
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Đóng và xuất PDF
            $pdf->Output('invoice.pdf', 'I');
        }
    }
}
