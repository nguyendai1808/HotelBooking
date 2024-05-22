<?php
include "PaymenVnpayClass.php";
$payment = new payment;
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $order_price = $_POST['order_price'];
    $payment->vnpay_payment($order_id, $order_price);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment-Vnpay</title>
</head>

<style>
    body {
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button {
        text-decoration: none;
        display: inline-block;
        padding: 10px 12px;
        background-color: cadetblue;
        color: whitesmoke;
        border: none;
        cursor: pointer;
    }
</style>

<body>
    <form action="" method="post">
        <img src="noimage.jpeg" style="width: 500px" alt="">
        <input type="hidden" name="order_id" value="<?php echo time() ?>"> <br>
        <input type="hidden" name="order_price" value="50000"> <br>
        <p style="color:red">Bạn cần thành toán 50.000<sup>đ</sup> để nhìn thấy em nó</p>
        <button name="redirect" type="submit">Thanh toán</button>
    </form>

</body>

</html>