<?php

require_once './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class Home extends Controller
{
    private $BookingModel;

    public function __construct()
    {
        $this->BookingModel = $this->model('BookingModel');
    }

    public function index()
    {
        $actual = $this->BookingModel->actualTotalRevenue();
        $estimated = $this->BookingModel->estimatedTotalRevenue();
        $deductible = $this->BookingModel->deductibleRevenue();

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
            'dataPoints1' => $dataPoints1,
            'dataPoints2' => $dataPoints2,
            'dataPoints3' => $dataPoints3
        ]);
    }

    public function exportExcel()
    {
        if (isset($_POST['export'])) {
            $start = $_POST['start'];
            $end = $_POST['end'];
            $statusList = ['Đã cọc tiền', 'Đã thanh toán', 'Hoàn tất', 'Đã hủy'];

            $spreadsheet = new Spreadsheet();

            // Định nghĩa các cột
            $columns = [
                'Id đơn', 'Người đặt', 'Email', 'SĐT', 'Thời gian',
                'Tổng giá', 'Đã trả', 'Còn thiếu', 'Trạng thái'
            ];

            foreach ($statusList as $status) {
                $data = $this->BookingModel->getBookingExport($start, $end, $status);
                if ($data) {
                    // Tạo sheet mới cho mỗi trạng thái
                    $sheet = $spreadsheet->createSheet();
                    $sheet->setTitle($status);

                    // Thiết lập tiêu đề cột
                    $sheet->setCellValue('A1', 'stt');
                    $sheet->getStyle('A1')->getFont()->setBold(true);
                    $sheet->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    $columnIndex = 'B';
                    foreach ($columns as $column) {
                        $sheet->setCellValue($columnIndex . '1', $column);
                        $sheet->getStyle($columnIndex . '1')->getFont()->setBold(true);
                        $sheet->getStyle($columnIndex . '1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                        $columnIndex++;
                    }

                    // Điền dữ liệu
                    $rowIndex = 2;
                    $count = 1;
                    foreach ($data as $row) {
                        $sheet->setCellValue('A' . $rowIndex, $count);
                        $sheet->getStyle('A' . $rowIndex)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                        $columnIndex = 'B';
                        foreach ($row as $cell) {
                            $sheet->setCellValue($columnIndex . $rowIndex, $cell);
                            $sheet->getStyle($columnIndex . $rowIndex)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                            $columnIndex++;
                        }
                        $rowIndex++;
                        $count++;
                    }

                    // Tính tổng cho các cột 'Tổng giá', 'Đã trả', 'Còn thiếu'
                    $totalRow = $rowIndex;
                    $sheet->setCellValue('A' . $totalRow, 'Tổng cộng:');
                    $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);
                    $sheet->getStyle('A' . $totalRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                    // Các cột khác để trống, tính tổng cho cột 'Tổng giá', 'Đã trả', 'Còn thiếu'
                    $columnIndex = 'B';
                    foreach ($columns as $column) {
                        if (in_array($column, ['Tổng giá', 'Đã trả', 'Còn thiếu'])) {
                            $sheet->setCellValue($columnIndex . $totalRow, '=SUM(' . $columnIndex . '2:' . $columnIndex . ($rowIndex - 1) . ')');
                        } else {
                            $sheet->setCellValue($columnIndex . $totalRow, '');
                        }
                        $sheet->getStyle($columnIndex . $totalRow)->getFont()->setBold(true);
                        $sheet->getStyle($columnIndex . $totalRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                        $columnIndex++;
                    }

                    // Điều chỉnh độ rộng cột
                    foreach (range('A', $columnIndex) as $columnID) {
                        $sheet->getColumnDimension($columnID)->setAutoSize(true);
                    }
                }
            }

            // Xóa sheet mặc định (sheet đầu tiên không tên)
            if ($spreadsheet->getSheetCount() > 1) {
                $spreadsheet->removeSheetByIndex(0);
            }

            // Thiết lập sheet đầu tiên là sheet hoạt động
            $spreadsheet->setActiveSheetIndex(0);

            // Thiết lập tiêu đề để tải về tệp
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="booking_export_' . $start . '_' . $end . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        } else {
            header('location:' . URLROOT . '/admin/home');
        }
    }
}
