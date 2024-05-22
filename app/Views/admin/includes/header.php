<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin</title>

    <link rel="stylesheet" href="<?= ADMIN_PATH ?>/css/style.css" />
    <link rel="stylesheet" href="<?= ADMIN_PATH ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <section class="sidebar">
        <div class="logo-details">
            <img src="<?= ADMIN_PATH ?>/images/logo-white.png" alt="logo">
            <span class="logo_name">HotelBooking</span>
        </div>
        <ul class="sidebar-item m-0 p-0">
            <li>
                <a href="<?= URLROOT ?>/admin" class="active">
                    <i class="fa-solid fa-coins"></i>
                    <span class="item-name">thống kê doanh thu</span>
                </a>
            </li>
            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-solid fa-hotel"></i>
                    <span class="item-name">Khách sạn</span>
                </a>
            </li>
            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                    <span class="item-name">Dịch vụ</span>
                </a>
            </li>

            <li>
                <a href="<?= URLROOT ?>/admin/category">
                    <i class="fa-solid fa-list"></i>
                    <span class="item-name">Danh mục phòng</span>
                </a>
            </li>

            <li>
                <a href="<?= URLROOT ?>/admin/room">
                    <i class="fa-solid fa-list"></i>
                    <span class="item-name">phòng</span>
                </a>
            </li>

            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-solid fa-person-booth"></i>
                    <span class="item-name">Tiện nghi phòng</span>
                </a>
            </li>
            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-regular fa-credit-card"></i>
                    <span class="item-name">Đặt phòng</span>
                </a>
            </li>

            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-solid fa-address-card"></i>
                    <span class="item-name">Tài khoản</span>
                </a>
            </li>
            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-regular fa-comment"></i>
                    <span class="item-name">Đánh giá</span>
                </a>
            </li>
            <li>
                <a href="<?= URLROOT ?>/admin">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="item-name">Liên hệ</span>
                </a>
            </li>
        </ul>
    </section>

    <nav>
        <div class="sidebar-button">
            <i class="fa-solid fa-bars sidebarBtn"></i>
        </div>
        <div class="search-box">
            <input type="search" placeholder="Tìm..." />
        </div>
        <div class="profile-details">
            <a href="#" class="dropdown-toggle" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= ADMIN_PATH ?>/images/user.png" alt="img" />
                <span class="admin_name">Admin</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                <li>
                    <a class="dropdown-item" href="<?= URLROOT ?>/home">
                        <i class="fa-solid fa-house"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="?logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>