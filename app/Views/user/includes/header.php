<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" type="image/x-icon" href="<?= USER_PATH ?>/icon/icon.png">
    <title>HotelBooking</title>
    <link rel="stylesheet" href="<?= USER_PATH ?>/css/style.css" />
    <link rel="stylesheet" href="<?= USER_PATH ?>/css/main.css" />
    <link rel="stylesheet" href="<?= USER_PATH ?>/css/responsive.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div id="loader">
        <div class="spinner-grow text-danger mx-1" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-warning mx-1" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-info mx-1" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- Header Start -->
    <header>
        <div class="header">
            <div class="logo">
                <a href="<?= URLROOT ?>/home"><img src="<?= USER_PATH ?>/images/HotelBooking-logo.png" alt="logo"></a>
            </div>

            <input type="checkbox" id="sidebar-active">
            <label for="sidebar-active" class="open-sidebar-button">
                <i class="fa-solid fa-bars"></i>
            </label>
            <label id="overlay" for="sidebar-active"></label>

            <nav class="navbar-content">
                <ul class="navbar-item">
                    <label for="sidebar-active" class="close-sidebar-button">
                        <i class="fa-solid fa-x"></i>
                    </label>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><a href="<?= URLROOT ?>/room">Phòng</a></li>
                    <li><a href="<?= URLROOT ?>/service">Dịch vụ</a></li>
                    <li><a href="<?= URLROOT ?>/contact">Liên hệ</a></li>
                    <li><a href="<?= URLROOT ?>/about">Giới thiệu</a></li>
                </ul>
                <div class="navbar-other">

                    <?php if (!empty($header)) :
                        foreach ($header as $item) : ?>

                            <li class="cart">
                                <a href="<?= URLROOT ?>/cart">
                                    <img src="<?= USER_PATH ?>/icon/cart.png" alt="user" width="25px" height="25px">

                                    <?php if (!empty($item['sogiohang'])) : ?>
                                        <small class="cart-count"><?= $item['sogiohang'] ?></small>
                                    <?php endif ?>

                                    <span>Giỏ hàng</span>
                                </a>
                            </li>

                            <li class="account">
                                <a href="#" class="dropdown-toggle" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img style="object-fit: cover;" src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="user" width="30px" height="30px">
                                    <span><?= $item['ten'] ?></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                    <?php if ($item['loaitk'] == 'admin') : ?>
                                        <li>
                                            <a class="dropdown-item" href="<?= URLROOT ?>/admin">
                                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                                <span>Quản trị viên</span>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= URLROOT ?>/personalInfo">
                                            <i class="bi bi-info-circle"></i>
                                            <span>Thông tin cá nhân</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= URLROOT ?>/history">
                                            <i class="bi bi-list-check"></i>
                                            <span>Lịch sử đặt phòng</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= URLROOT ?>/login/logout">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Đăng xuất</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <?php endforeach;
                    else : ?>

                        <li class="account">
                            <a href="#" class="dropdown-toggle" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= USER_PATH ?>/icon/user.png" alt="user" width="30px" height="30px">
                                <span>Tài khoản</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= URLROOT ?>/register">
                                        <i class="bi bi-person-plus"></i>
                                        <span>Đăng ký</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= URLROOT ?>/login">
                                        <i class="bi bi-box-arrow-in-left"></i>
                                        <span>Đăng nhập</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php endif ?>
                </div>
            </nav>
        </div>
    </header>
    <!-- Header End -->