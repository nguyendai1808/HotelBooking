<main class="container-fluid" id="personal_infor-page">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg' ?>" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Thông tin cá nhân</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><span>Thông tin cá nhân</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="personal-infor pb-5" id="booking-move">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="sidebar" id="sidebar">
                        <ul class="list-group">
                            <li data-url="<?= URLROOT ?>/personalInfo/account">
                                <span><i class="fa-solid fa-user pe-3"></i>Thông Tin Tài Khoản</span>
                            </li>
                            <li data-url="<?= URLROOT ?>/personalInfo/password">
                                <span><i class="fa-solid fa-lock pe-3"></i>Đổi Mật Khẩu</span>
                            </li>
                            <li data-url="<?= URLROOT ?>/personalInfo/booked">
                                <span><i class="fa-solid fa-file-invoice pe-3"></i>Các Phòng Đã Đặt</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div id="main-content">

                        <?php require_once APPROOT . '/views/user/pages/' . $data['page']; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>


</main>