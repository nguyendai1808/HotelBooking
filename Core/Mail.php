<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        //Server settings
        try {
            $this->mail->CharSet = "UTF-8";
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = MAILER_SMTP_USER;                     //SMTP username
            $this->mail->Password   = MAILER_SMTP_PASS;                     //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $this->mail->setFrom(MAILER_SMTP_USER, 'HotelBooking.com');
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->SMTPDebug = 0;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$this->mail->ErrorInfo}";
            exit();
        }
    }

    public function sendMail($to, $subject, $content)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $content;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }


    public function sendMailBooking($to, $subject, $customer, $booking, $iddondat, $sotiendathanhtoan)
    {
        if (count($customer) <= 0) {
            return false;
        }
        if (count($booking) > 0) {
            $tongsotien = 0;

            foreach ($booking as $item) {
                $tongsotien += intval($item['tonggia']);
            }

            if (($tongsotien - $sotiendathanhtoan) > 0) {
                $trangthaidon = 'Đã cọc tiền';
                $sotienconthieu = ($tongsotien - $sotiendathanhtoan);
            } else {
                $trangthaidon = 'Đã thanh toán';
                $sotienconthieu = 0;
            }
        } else {
            return false;
        }

        try {
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;

            $content = '
            <head>
                <style>
                    .booking {
                        margin: auto;
                        width: 80%;
                        font-family: Arial, sans-serif;
                    }

                    .room-item {
                        border: 1px solid #3333;
                        margin-bottom: 30px;
                    }

                    .room-item .form-item {
                        padding: 10px;
                        display: flex;
                        flex: 1 1 100%;
                    }

                    .room-item .item-img {
                        width: 25%;
                        position: relative;
                    }

                    .room-item .item-img img {
                        width: 100%;
                        height: 165px;
                        object-fit: cover;
                    }

                    @media screen and (max-width: 1200px) {
                        .room-item .item-img img {
                            height: auto;
                        }
                    }

                    .room-item .item-detail {
                        width: 75%;
                        padding-left: 15px;
                    }

                    .room-item .item-total {
                        height: 25px;
                        line-height: 25px;
                        border-top: 1px solid #3333;
                        padding: 10px;
                        background-color: rgb(251, 242, 228);
                    }

                    .booking h2, .booking h3, .booking p {
                        margin: 0;
                        padding-bottom: 5px;
                    }

                    .booking h2 {
                        color: gray;
                    }

                    .booking h3 {
                        color: darkgoldenrod;
                        margin-top: 10px;
                    }

                    .booking p {
                        color: #333;
                    }

                    .booking .total-info {
                        text-align: right;
                        margin-top: 10px;
                    }

                    .booking .total-info h2 {
                        color: dodgerblue;
                        margin-bottom: 5px;
                    }

                    .booking .total-info p {
                        color: darkgreen;
                        margin: 0;
                    }

                    .booking .total-info p:last-child {
                        color: firebrick;
                    }

                    .btn-bill {
                        background-color: dodgerblue;
                        border: none;
                        border-radius: 5px;
                        color: white;
                        padding: 10px 20px;
                        cursor: pointer;
                    }
                </style>
            </head>
            <form class="booking" action="' . URLROOT . '/invoice" method="post">
                <h2 style="color: gray;">Kính gửi ' . htmlspecialchars($customer['fullname']) . '</h2>
                <p>Cảm ơn vì đã tin chọn HotelBooking</p>
                <h3 style="margin: 0; padding-bottom: 10px;">Thông tin chi tiết đơn đặt phòng của bạn</h3>
                <h3 style="color: darkgoldenrod; margin: 0; padding-bottom: 5px;">ID đơn đặt: ' . htmlspecialchars($iddondat) . '</h3>
                <p style="color: orange; margin: 0; padding-bottom: 5px;">Tình trạng đơn đặt: ' . htmlspecialchars($trangthaidon) . '</p>
                <div class="total-info">
                    <h3 style="color: dodgerblue; margin: 0; padding-bottom: 5px;">Tổng số tiền: ' . number_format($tongsotien, 0, ',', '.') . 'đ</h3>
                    <p style="color: darkgreen; margin: 0; padding-bottom: 5px;">Số tiền đã thanh toán: ' . number_format($sotiendathanhtoan, 0, ',', '.') . 'đ</p>
                    <p style="color: firebrick; margin: 0; padding-bottom: 5px;">Số tiền còn phải thanh toán: ' . number_format($sotienconthieu, 0, ',', '.') . 'đ</p>
                </div>
                <h3 style="margin-bottom: 15px; margin-top: 10px;">Chi tiết phòng đã đặt</h3>';

            $stt = 1;
            foreach ($booking as $item) {
                $this->mail->addEmbeddedImage(PUBLIC_PATH . '/' . 'user/' . (!empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'), 'image-' . $stt);

                $content .= '
                <div class="room-item">
                    <div class="form-item">
                        <div class="item-img">
                            <img src="cid:image-' . $stt . '">
                        </div>
                        <div class="item-detail">
                            <h3 style="margin-top: 0; margin-bottom: 5px;">' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</h3>';

                if (!empty($item['khuyenmai'])) {
                    $content .= '<small style="color: orange;">Khuyến mãi: ' . htmlspecialchars($item['khuyenmai']) . '%</small>';
                }

                $content .= '
                        <div class="item-date" style="margin: 0; padding: 5px 0;">
                            <span>' . date('d-m-Y', strtotime($item['ngayden'])) . '</span> - <span>' . date('d-m-Y', strtotime($item['ngaydi'])) . '</span>
                        </div>
                        <p style="margin: 0; color: green;">' . htmlspecialchars($item['loaihinhtt']) . '</p>';

                $giaphong = $item['giaphong'];
                if (!empty($item['khuyenmai'])) {
                    $giaphong = $giaphong * (1 - $item['khuyenmai'] / 100);
                    $content .= '<h4 style="margin: 0; padding:  5px 0;"><del>' . number_format($item['giaphong'], 0, ',', '.') . '</del> ' . number_format($giaphong, 0, ',', '.') . 'đ</h4>';
                } else {
                    $content .= '<h4 style="margin: 0; padding:  5px 0;">' . number_format($giaphong, 0, ',', '.') . 'đ</h4>';
                }

                $content .= '<p style="margin: 0;">Số lượng: ' . htmlspecialchars($item['soluongdat']) . '</p>
                        </div>
                    </div>
                    <div class="item-total">
                        <span>' . htmlspecialchars($item['soluongdat']) . ' x phòng</span>
                        <span> - ' . htmlspecialchars($item['songay']) . ' ngày</span>
                        <h3 style="float: right; margin: 0;">Tổng: ' . number_format($item['tonggia'], 0, ',', '.') . 'đ</h3>
                    </div>
                </div>';
                $stt++;
            }
            $content .= '
                <input type="hidden" name = "email" value="' . htmlspecialchars($to) . '">
                <button type="submit" class="btn-bill" name="invoice" value="' . htmlspecialchars($iddondat) . '">Quản lý đơn đặt</button>
            </form>';

            $this->mail->Body    = $content;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }

    public function sendMailCancelRoom($to, $subject, $booking)
    {
        if (count($booking) <= 0) {
            return false;
        }
        try {
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;

            $content = '
            <head>
                <style>
                    .booking {
                        margin: auto;
                        width: 80%;
                        font-family: Arial, sans-serif;
                    }

                    .room-item {
                        border: 1px solid #3333;
                        margin-bottom: 30px;
                    }

                    .room-item .form-item {
                        padding: 10px;
                        display: flex;
                        flex: 1 1 100%;
                    }

                    .room-item .item-img {
                        width: 25%;
                        position: relative;
                    }

                    .room-item .item-img img {
                        width: 100%;
                        height: 165px;
                        object-fit: cover;
                    }

                    @media screen and (max-width: 1200px) {
                        .room-item .item-img img {
                            height: auto;
                        }
                    }

                    .room-item .item-detail {
                        width: 75%;
                        padding-left: 15px;
                    }

                    .room-item .item-total {
                        height: 25px;
                        line-height: 25px;
                        border-top: 1px solid #3333;
                        padding: 10px;
                        background-color: rgb(251, 242, 228);
                    }

                    .booking h2, .booking h3, .booking p {
                        margin: 0;
                        padding-bottom: 5px;
                    }

                    .booking h2 {
                        color: gray;
                    }

                    .booking h3 {
                        color: darkgoldenrod;
                        margin-top: 10px;
                    }

                    .booking p {
                        color: #333;
                    }

                    .booking .total-info {
                        text-align: right;
                        margin-top: 10px;
                    }

                    .booking .total-info h2 {
                        color: dodgerblue;
                        margin-bottom: 5px;
                    }

                    .booking .total-info p {
                        color: darkgreen;
                        margin: 0;
                    }

                    .booking .total-info p:last-child {
                        color: firebrick;
                    }

                    .btn-bill {
                        background-color: dodgerblue;
                        border: none;
                        border-radius: 5px;
                        color: white;
                        padding: 10px 20px;
                        cursor: pointer;
                    }
                </style>
            </head>
            <form class="booking" action="' . URLROOT . '/invoice" method="post">
                <h2 style="color: gray;">Bạn đã hủy đặt phòng thành công</h2>
                <h3>Chi tiết phòng đã hủy</h3>
                <ul style="padding-left: 0;">';

            $sotienhoantra = 0;
            $sotienboithuong = 0;
            foreach ($booking as $item) {
                if ($item['trangthaidat'] == 'Đã hủy') {
                    if ($item['sotienconthieu'] == 0 && $item['trangthaidon'] != 'Đã hủy') {
                        $sotienhoantra += intval($item['tonggia']) * 0.75;
                        $sotienboithuong += intval($item['tonggia']) * 0.25;
                    } else {
                        $sotienhoantra += intval($item['tonggia']) * 0.25;
                        $sotienboithuong += intval($item['tonggia']) * 0.25;
                    }
                    $content .= '
                    <li>
                        <p style="margin: 0; padding-bottom: 5px;">' . htmlspecialchars($item['soluongdat']) . ' x ' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</p>
                        <p style="margin: 0; padding-bottom: 5px;">Thời gian: ' . date('d-m-Y', strtotime($item['ngayden'])) . ' đến ' . date('d-m-Y', strtotime($item['ngaydi'])) . '</p>
                        <h4 style="margin: 0; padding-bottom: 5px;">Tổng giá: ' . number_format($item['tonggia'], 0, ',', '.') . 'đ</h4>
                    </li>';
                }
            }

            if ($booking[0]['sotienconthieu'] == 0) {
                $tiendathanhtoan = $booking[0]['tongsotien'] - $sotienboithuong;
                $tienconthieu =  0;
            } else {
                $tiendathanhtoan = $booking[0]['sotiencoc'];
                $tienconthieu =  $booking[0]['sotienconthieu'];
            }

            $content .= '
                </ul>
                <h3>Chi tiết hoàn tiền</h3>
                <p style="color: darkgreen; margin: 0; padding-bottom: 5px;">Số tiền hoàn trả: ' . number_format($sotienhoantra, 0, ',', '.') . 'đ</p>
                <p style="color: firebrick; margin: 0; padding-bottom: 5px;">Số tiền bồi thường khách sạn: ' . number_format($sotienboithuong, 0, ',', '.') . 'đ</p>
                <p style="margin: 0; padding-bottom: 5px;">Khách sạn sẽ hoàn trả lại tiền (trong vòng 10 - 15 ngày) và giữ lại số tiền bồi thường theo đúng chính sách đề ra, xem chi tiết <a href="' . URLROOT . '/information"><span>chính sách hủy và hoàn trả tiền</span></a></p>
                <h3>Thông tin chi tiết đơn đặt phòng của bạn</h3>
                <h3 style="color: darkgoldenrod; margin: 0; padding-bottom: 5px;">ID đơn đặt: ' . htmlspecialchars($booking[0]['iddondat']) . '</h3>
                <p style="color: orange; margin: 0;">Tình trạng đơn đặt: ' . htmlspecialchars($booking[0]['trangthaidon']) . '</p>
                <div class="total-info">
                    <h3 style="color: dodgerblue; margin: 0; padding-bottom: 5px;">Tổng số tiền: ' . number_format($booking[0]['tongsotien'], 0, ',', '.') . 'đ</h3>
                    <p style="color: darkgreen; margin: 0; padding-bottom: 5px;">Số tiền đã thanh toán: ' . number_format($tiendathanhtoan, 0, ',', '.') . 'đ</p>
                    <p style="color: firebrick; margin: 0; padding-bottom: 5px;">Số tiền còn phải thanh toán: ' . number_format($tienconthieu, 0, ',', '.') . 'đ</p>
                </div>
                <h3 style="margin-bottom: 10px; margin-top: 0;">Xem chi tiết đơn đặt</h3>';

            $stt = 1;
            foreach ($booking as $item) {
                if ($item['trangthaidat'] != 'Đã hủy') {
                    $this->mail->addEmbeddedImage(PUBLIC_PATH . '/' . 'user/' . (!empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'), 'image-' . $stt);

                    $content .= '
                    <div class="room-item">
                        <div class="form-item">
                            <div class="item-img">
                                <img src="cid:image-' . $stt . '">
                            </div>
                            <div class="item-detail">
                                <h3 style="margin-top: 0; margin-bottom: 5px;">' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</h3>';

                    if (!empty($item['khuyenmai'])) {
                        $content .= '<small style="color: orange;">Khuyến mãi: ' . htmlspecialchars($item['khuyenmai']) . '%</small>';
                    }

                    $content .= '
                                <div class="item-date" style="margin: 0; padding: 5px 0;">
                                    <span>' . date('d-m-Y', strtotime($item['ngayden'])) . '</span> - <span>' . date('d-m-Y', strtotime($item['ngaydi'])) . '</span>
                                </div>
                                <p style="margin: 0; color: green;">' . htmlspecialchars($item['loaihinhtt']) . '</p>';

                    $giaphong = $item['giaphong'];
                    if (!empty($item['khuyenmai'])) {
                        $giaphong = $giaphong * (1 - $item['khuyenmai'] / 100);
                        $content .= '<h4 style="margin: 0; padding:  5px 0;"><del>' . number_format($item['giaphong'], 0, ',', '.') . '</del> ' . number_format($giaphong, 0, ',', '.') . 'đ</h4>';
                    } else {
                        $content .= '<h4 style="margin: 0; padding:  5px 0;">' . number_format($giaphong, 0, ',', '.') . 'đ</h4>';
                    }

                    $content .= '<p style="margin: 0;">Số lượng: ' . htmlspecialchars($item['soluongdat']) . '</p>
                            </div>
                        </div>
                        <div class="item-total">
                            <span>' . htmlspecialchars($item['soluongdat']) . ' x phòng</span>
                            <span> - ' . htmlspecialchars($item['songay']) . ' ngày</span>
                            <h3 style="float: right; margin: 0;">Tổng: ' . number_format($item['tonggia'], 0, ',', '.') . 'đ</h3>
                        </div>
                    </div>';
                }
                $stt++;
            }
            $content .= '
                <input type="hidden" name = "email" value="' . htmlspecialchars($to) . '">
                <button type="submit" name="invoice" value="' . htmlspecialchars($booking[0]['iddondat']) . '" style="background-color: dodgerblue; border: none; border-radius: 5px; color: white; padding: 10px 20px;">Quản lý đơn đặt</button>
            </form>';

            $this->mail->Body    = $content;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}
