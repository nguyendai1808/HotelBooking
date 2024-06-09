<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function sendMail($to, $subject, $content)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings

            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nguyendai180802@gmail.com';                     //SMTP username
            $mail->Password   = 'pbypdconpklchihv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('nguyendai180802@gmail.com', 'HotelBooking.com');
            $mail->addAddress($to);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $mail->SMTPDebug = 0;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }


    public function sendMailBooking($to, $subject, $customer, $booking, $iddondat, $sotien)
    {
        $mail = new PHPMailer(true);
        try {
            if (count($customer) <= 0) {
                return false;
            }
            if (count($booking) > 0) {
                $tongsotien = 0;

                foreach ($booking as $item) {
                    $tongsotien += intval($item['tonggia']);
                }

                if (($tongsotien - $sotien) > 0) {
                    $trangthaidon = 'Đã cọc tiền';
                    $sotienconthieu = ($tongsotien - $sotien);
                } else {
                    $trangthaidon = 'Đã thanh toán';
                    $sotienconthieu = 0;
                }
            } else {
                return null;
            }

            //Server settings
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nguyendai180802@gmail.com';                     //SMTP username
            $mail->Password   = 'pbypdconpklchihv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('nguyendai180802@gmail.com', 'HotelBooking.com');
            $mail->addAddress($to);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;


            $content = '
            <!DOCTYPE HTML>
            <html>
            <head>
            <style>
                .booking {
                    margin: auto;
                    width: 70%;
                }

                .room-item {
                    border: 1px solid #3333;
                    margin-bottom: 30px;
                }

                .room-item .form-item {
                    padding: 10px;
                    display: flex;
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
                        height: 100%;
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
            </style>
            </head>
            <body>

            <form class="booking" action="' . URLROOT . '/invoice" method="post">
                <h2 style="color: gray;">Kính gửi ' . htmlspecialchars($customer['fullname']) . '</h2>
                <p>Cảm ơn vì đã tin chọn HotelBooking</p>
                <h3 style="margin: 0; padding-bottom: 10px;">Thông tin chi tiết đơn đặt phòng của bạn</h3>
                <h3 style="color: darkgoldenrod; margin: 0; padding-bottom: 5px;">ID đơn đặt: ' . htmlspecialchars($iddondat) . '</h3>
                <p style="color: orange; margin: 0; padding-bottom: 5px;">Tình trạng đơn đặt: ' . htmlspecialchars($trangthaidon) . '</p>
                <div style="text-align: right;">
                    <h2 style="color: dodgerblue;margin: 0; padding-bottom: 5px;">Tổng số tiền: ' . number_format($tongsotien, 0, ',', '.') . 'đ</h2>
                    <p style="color: darkgreen;margin: 0;padding-bottom: 5px">Số tiền đã thanh toán: ' . number_format($sotien, 0, ',', '.') . 'đ</p>
                    <p style="color: firebrick;margin: 0; padding-bottom: 5px;">Số tiền còn phải thanh toán: ' . number_format($sotienconthieu, 0, ',', '.') . 'đ</p>
                </div>
                <h3 style="margin-bottom: 15px; margin-top: 0;">Chi tiết phòng đã đặt</h3>';
            $stt = 1;
            foreach ($booking as $item) {

                $mail->addEmbeddedImage(PUBLIC_PATH . '/' . 'user/' . (!empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'), 'image-' . $stt);

                $content .= '<div class="room-item">
                <div class="form-item col-12 d-flex">
                    <div class="item-img">
                        <img src="cid:image-' . $stt . '">
                    </div>
                    <div class="item-detail">
                        <h3 style="margin-top: 0; margin-bottom: 5px;">' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</h3>';

                if (!empty($item['khuyenmai'])) {
                    $content .= '<small style="color: orange;">Khuyến mãi: ' . htmlspecialchars($item['khuyenmai']) . '%</small>';
                }

                $content .= '<div class="item-date" style="margin: 0; padding: 5px 0;">
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
            <button type="submit" name="invoice" value="' . htmlspecialchars($iddondat) . '" style="background-color: dodgerblue; border: none; border-radius: 5px; color: white; padding: 10px 20px;">Quản lý đơn đặt</button>
            </form>
            </body>
            </html>';

            $mail->Body    = $content;

            $mail->SMTPDebug = 0;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function sendMailCancelRoom($to, $subject, $booking)
    {
        if (count($booking) <= 0) {
            return false;
        }
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nguyendai180802@gmail.com';                     //SMTP username
            $mail->Password   = 'pbypdconpklchihv';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('nguyendai180802@gmail.com', 'HotelBooking.com');
            $mail->addAddress($to);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;


            $content = '
            <!DOCTYPE HTML>
            <html>
            <head>
            <style>
                .booking {
                    margin: auto;
                    width: 70%;
                }

                .room-item {
                    border: 1px solid #3333;
                    margin-bottom: 30px;
                }

                .room-item .form-item {
                    padding: 10px;
                    display: flex;
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
                        height: 100%;
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
            </style>
            </head>
            <body>

            <form class="booking" action="' . URLROOT . '/invoice" method="post">
                <h2 style="color: gray;">Bạn đã hủy đặt phòng thành công</h2>
                <h3>Chi tiết phòng đã hủy</h3>
                <ul style="padding-left: 0;">';
            $sotientra = 0;
            $sotiengiu = 0;
            foreach ($booking as $item) {
                if ($item['trangthaidat'] == 'Đã hủy') {
                    $sotientra += intval($item['tonggia']) * 0.75;
                    $sotiengiu += intval($item['tonggia']) * 0.25;
                    $content .= '<li>
                        <p style="margin: 0; padding-bottom: 5px;">' . htmlspecialchars($item['soluongdat']) . ' x ' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</p>
                        <p style="margin: 0; padding-bottom: 5px;">Thời gian: ' . date('d-m-Y', strtotime($item['ngayden'])) . ' đến ' . date('d-m-Y', strtotime($item['ngaydi'])) . '</p>
                        <h4 style="margin: 0; padding-bottom: 5px;">Tổng giá: ' . number_format($item['tonggia'], 0, ',', '.') . 'đ</h4>
                        </li>';
                }
            }

            if (!empty($booking[0]['sotiencoc'])) {
                $tiendathanhtoan = $booking[0]['sotiencoc'];
                $tienconthieu =  $booking[0]['sotienconthieu'];
            } else {
                $tiendathanhtoan = $booking[0]['tongsotien'];
                $tienconthieu =  0;
            }

            $content .= '</ul>
                <p>Khách sạn sẽ hoàn trả lại tiền (trong vòng 10 - 15 ngày) và giữ lại số tiền bồi thường theo đúng chính sách đề ra, xem chi tiết <a href="' . URLROOT . '/information"><span>chính sách hủy và hoàn trả tiền</span></a></p>
                <h3>Chi tiết hoàn tiền</h3>
                <p style="color: darkgreen; margin: 0;padding-bottom: 5px;">Số tiền hoàn trả: ' . number_format($sotientra, 0, ',', '.') . 'đ</p>
                <p style="color: firebrick; margin: 0;padding-bottom: 5px;">Số tiền bồi thường khách sạn: ' . number_format($sotiengiu, 0, ',', '.') . 'đ</p>
                <h3>Thông tin chi tiết đơn đặt phòng của bạn</h3>
                <h3 style="color: darkgoldenrod; margin: 0; padding-bottom: 5px;">ID đơn đặt: ' . htmlspecialchars($booking[0]['iddondat']) . '</h3>
                <p style="color: orange; margin: 0;">Tình trạng đơn đặt: ' . htmlspecialchars($booking[0]['trangthaidon']) . '</p>
                <div style="text-align: right;">
                    <h2 style="color: dodgerblue;margin: 0; padding-bottom: 5px;">Tổng số tiền: ' . number_format($booking[0]['tongsotien'], 0, ',', '.') . 'đ</h2>
                    <p style="color: darkgreen;margin: 0;padding-bottom: 5px">Số tiền đã thanh toán: ' . number_format($tiendathanhtoan, 0, ',', '.') . 'đ</p>
                    <p style="color: firebrick;margin: 0;">Số tiền còn phải thanh toán: ' . number_format($tienconthieu, 0, ',', '.') . 'đ</p>
                </div>';

            $content .= '<h3 style="margin-bottom: 10px; margin-top: 0;">Xem chi tiết đơn đặt</h3>';
            $stt = 1;
            foreach ($booking as $item) {
                if ($item['trangthaidat'] != 'Đã hủy') {
                    $mail->addEmbeddedImage(PUBLIC_PATH . '/' . 'user/' . (!empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'), 'image-' . $stt);

                    $content .= '<div class="room-item">
                        <div class="form-item col-12 d-flex">
                        <div class="item-img">
                            <img src="cid:image-' . $stt . '">
                        </div>
                        <div class="item-detail">
                            <h3 style="margin-top: 0; margin-bottom: 5px;">' . htmlspecialchars($item['tenphong']) . ' - ' . htmlspecialchars($item['tengiuong']) . '</h3>';

                    if (!empty($item['khuyenmai'])) {
                        $content .= '<small style="color: orange;">Khuyến mãi: ' . htmlspecialchars($item['khuyenmai']) . '%</small>';
                    }

                    $content .= '<div class="item-date" style="margin: 0; padding: 5px 0;">
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
            <button type="submit" name="invoice" value="' . htmlspecialchars($booking[0]['iddondat']) . '" style="background-color: dodgerblue; border: none; border-radius: 5px; color: white; padding: 10px 20px;">Quản lý đơn đặt</button>
            </form>
            </body>
            </html>';

            $mail->Body    = $content;

            $mail->SMTPDebug = 0;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Gửi email thất bại. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
