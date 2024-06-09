<Main class="container-fluid">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg' ?>" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Chi tiết đơn đặt</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><span>Chi tiết đơn đặt</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- hisory start -->
    <section class="history pb-5">
        <div class="history-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="sidebar pb-5" id="sidebar">
                            <ul class="list-group">
                                <li data-url="<?= URLROOT ?>/invoice/all">
                                    <span><i class="fa-solid fa-caret-right pe-3"></i>Tất cả</span>
                                </li>
                                <li data-url="<?= URLROOT ?>/invoice/checkoutLounge">
                                    <span><i class="fa-solid fa-caret-right pe-3"></i>Chờ thanh toán</span>
                                </li>
                                <li data-url="<?= URLROOT ?>/invoice/paidBooking">
                                    <span><i class="fa-solid fa-caret-right pe-3"></i>Đã thanh toán</span>
                                </li>
                                <li data-url="<?= URLROOT ?>/invoice/booked">
                                    <span><i class="fa-solid fa-caret-right pe-3"></i>Hoàn tất</span>
                                </li>
                                <li data-url="<?= URLROOT ?>/invoice/canceledBooking">
                                    <span><i class="fa-solid fa-caret-right pe-3"></i>Đã hủy</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-9 mb-3">


                        <div id="main-content">

                            <?php require_once APPROOT . '/views/user/pages/' . $data['page']; ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- hisory end -->

</Main>