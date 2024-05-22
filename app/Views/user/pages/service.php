<Main class="container-fluid" id="service-page">
    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/bg-img.jpg" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Dịch vụ</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><span>Dịch vụ</span></li>
                </ul>
            </div>
        </div>
    </section>


    <!-- Service -->
    <section class="service pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-warning text-uppercase">Dịch vụ của HotelStay</h6>
                <h2 class="title-name-below mb-5">Khám phá <span class="text-warning text-uppercase">Dịch vụ Nổi bật</span></h2>
            </div>
            <div class="row g-4" id="service-items">

                <?php if (isset($data['services'])) :
                    foreach ($data['services'] as $item) : ?>

                        <div class="col-lg-4 col-md-6">
                            <div class="service-item line-bottom">
                                <div class="service-img">
                                    <img src="<?= USER_PATH ?>/images/services/<?= $item['icon'] ?>" alt="icon">
                                </div>
                                <h5 class="mb-3 text-black"><?= $item['tendichvu'] ?></h5>
                                <p class="text-body"><?= $item['mota'] ?></p>
                            </div>
                        </div>

                <?php endforeach;
                endif ?>

            </div>
        </div>

        <!-- Start Pagination -->
        <div class="page-pagination mt-5" id="pagination-links">

            <?php if (isset($data['pagination'])) : extract($data['pagination']);
                $start = max($current_page - 1, 1);
                $end = min($start + 2, $total_pages);

                if ($current_page == $total_pages && $start > 1) :
                    $start--;
                endif; ?>

                <ul>
                    <?php if ($current_page > 1) : ?>
                        <li><a href="<?= URLROOT ?>/service/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/service/page/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li><a href="<?= URLROOT ?>/service/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>

        </div>
        <!-- End Pagination -->

    </section>
    <!-- Service End -->

    <!-- Comment Start -->
    <section class="comment pt-5 pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-secondary text-uppercase">Đánh giá của khách hàng</h6>
                <h2 class="title-name-below mb-5">Những đánh giá về <span class="text-warning text-uppercase">HotelStay</span></h2>
            </div>
            <div class="comment-content">
                <div class="slider-wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false">
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- Comment End -->

</Main>