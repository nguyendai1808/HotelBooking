<Main class="container-fluid" id="home-page">

    <!-- banner image Start -->
    <section class="banner-image">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg' ?>" alt="banner">
    </section>
    <!-- banner image end -->

    <?php include APPROOT . '/views/user/includes/booking.php'; ?>

    <?php include APPROOT . '/views/user/includes/changedate.php'; ?>


    <!-- About start -->
    <section class="about pb-5">
        <div class="container">
            <div class="row">
                <?php if (!empty($data['hotel'])) :
                    foreach ($data['hotel'] as $item) : ?>

                        <div class="col-lg-12">
                            <h6 class="section-title text-start text-secondary text-uppercase">Khám phá</h6>
                            <h2 class="mb-2">Những trải nghiệm tuyệt vời cùng với <span class="text-warning text-uppercase"><?= $item['tenkhachsan'] ?></span></h2>
                            <div class="star line-below mb-2">

                                <?php
                                $star = (floatval($item['sodiem']) * 0.5);
                                $fullStars = floor($star); // Số sao đầy đủ
                                $halfStar = ($star - $fullStars >= 0.5) ? 1 : 0; // Số sao nửa
                                $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống

                                for ($i = 0; $i < $fullStars; $i++) : ?>
                                    <span class="fa fa-star"></span>
                                <?php endfor; ?>

                                <?php if ($halfStar) : ?>
                                    <span class="fa fa-star-half-stroke"></span>
                                <?php endif; ?>

                                <?php for ($i = 0; $i < $emptyStars; $i++) : ?>
                                    <span class="fa-regular fa-star"></span>
                                <?php endfor; ?>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <p class="mb-4 mt-4" style="font-size: 17px;"><?= $item['thongtin'] ?></p>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa fa-door-open fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sophong'] ?></h3>
                                            <p class="mb-0">Phòng</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa-solid fa-cart-flatbed-suitcase fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sodichvu'] ?></h3>
                                            <p class="mb-0">Dịch vụ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa fa-comment fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sodanhgia'] ?></h3>
                                            <p class="mb-0">Đánh giá</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="see-detail mb-2 mt-3">
                                <a class="btn btn-warning text-uppercase fw-bold text-white px-5 py-3" href="<?= URLROOT ?>/about">Xem chi tiết</a>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4 mb-5">
                            <div class="about-img">

                                <?php if (!empty($item['anhks'])) :  $stt = 1;
                                    foreach ($item['anhks'] as $row) :  ?>

                                        <img src="<?= USER_PATH ?>/<?= !empty($row['anh']) ? $row['anh'] : 'images/notImage.jpg'; ?>" alt="Image" class="image-<?= $stt ?>">

                                    <?php $stt++;
                                    endforeach;
                                else : ?>

                                    <img src="<?= USER_PATH ?>/images/notImage.jpg'; ?>" alt="Image" class="image-1">
                                    <img src="<?= USER_PATH ?>/images/notImage.jpg'; ?>" alt="Image" class="image-2">

                                <?php endif; ?>
                            </div>
                        </div>

                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>
    <!-- About End -->

    <!-- Room Start -->
    <section class="room pb-5">
        <div class="container">

            <?php if (!empty($data['roomshot'])) : ?>

                <div class="outstanding-room pb-5">
                    <div class="text-center">
                        <h6 class="section-title text-center text-secondary text-uppercase">Phòng của khách sạn</h6>
                        <h2 class="title-name-below mb-5">Khám phá <span class="text-warning text-uppercase">Phòng nổi bật</span></h2>
                    </div>
                    <div class="room-slider">
                        <div class="slider-wrapper">
                            <i id="left" class="fa-solid fa-angle-left"></i>
                            <ul class="carousel">

                                <?php foreach ($data['roomshot'] as $item) :
                                    $giaphong = !empty($item['khuyenmai']) ? ($item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong'])) :  $item['giaphong']; ?>

                                    <li class="card">
                                        <form class="room" action="<?= URLROOT ?>/payment" method="post">
                                            <div class="room-item rounded overflow-hidden">
                                                <div class="room-img p-3">
                                                    <img class="img-fluid" src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="image" draggable="false">
                                                    <small class="item-price"><?= number_format($giaphong, 0, ',', '.') ?> đ/đêm</small>
                                                    <small class="item-payment"><?= $item['loaihinhtt'] ?? '' ?></small>
                                                    <?php if (!empty($item['khuyenmai'])) : ?>
                                                        <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="room-infor p-3">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <h5 class="item-name mb-0"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></h5>
                                                        <span class="ps-3 fw-bold text-success"><?= !empty($item['danhgia']) ?  round($item['danhgia'], 1) . '/10' : ''; ?></span>
                                                    </div>
                                                    <div class="d-flex mb-2">
                                                        <small class="border-end me-2 pe-2"><i class="fa fa-bed text-warning pe-2"></i><?= $item['sogiuong'] ?> giường</small>
                                                        <small class="border-end me-2 pe-2"><i class="fa fa-chart-area text-warning pe-2"></i><?= $item['kichthuoc'] ?> m²</small>
                                                        <small class=""><i class="fa fa-wifi text-warning pe-2"></i>miễn phí</small>
                                                    </div>
                                                    <p class="item-desc"><?= $item['mota'] ?></p>

                                                    <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                                                    <input type="hidden" name="giaphong" value="<?= $giaphong ?>">
                                                    <input type="hidden" id="sophongtrong" value="<?= $item['soluongphongtrong'] ?>">
                                                    
                                                    <div class="d-flex justify-content-between">
                                                        <a class="btn btn-sm btn-warning rounded fw-bold py-2 px-3" href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>">Xem chi tiết</a>
                                                        <button type="submit" name="booknow" onclick="clickBooknow(event, '<?= $item['idphong'] ?>');" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                            <i id="right" class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php if (!empty($data['roomsSale'])) : ?>

                <div class="room-sale pb-5 pt-5">
                    <div class="text-center">
                        <h6 class="section-title text-center text-secondary text-uppercase">Phòng của khách sạn</h6>
                        <h2 class="title-name-below mb-5">Ưu đãi <span class="text-warning text-uppercase">Phòng giảm giá</span></h2>
                    </div>
                    <div class="room-slider">
                        <div class="slider-wrapper">
                            <i id="left" class="fa-solid fa-angle-left"></i>
                            <ul class="carousel">

                                <?php foreach ($data['roomsSale'] as $item) :
                                    $giaphong = !empty($item['khuyenmai']) ? ($item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong'])) :  $item['giaphong']; ?>

                                    <li class="card">
                                        <form class="room" action="<?= URLROOT ?>/payment" method="post">
                                            <div class="room-item rounded overflow-hidden">
                                                <div class="room-img p-3">
                                                    <img class="img-fluid" src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="image" draggable="false">
                                                    <small class="item-price"><?= number_format($giaphong, 0, ',', '.') ?> đ/đêm</small>
                                                    <small class="item-payment"><?= $item['loaihinhtt'] ?? '' ?></small>
                                                    <?php if (!empty($item['khuyenmai'])) : ?>
                                                        <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="room-infor p-3">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <h5 class="item-name mb-0"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></h5>
                                                        <span class="ps-3 fw-bold text-success"><?= !empty($item['danhgia']) ? round($item['danhgia'], 1) . '/10' : ''; ?></span>
                                                    </div>
                                                    <div class="d-flex mb-2">
                                                        <small class="border-end me-2 pe-2"><i class="fa fa-bed text-warning pe-2"></i><?= $item['sogiuong'] ?> giường</small>
                                                        <small class="border-end me-2 pe-2"><i class="fa fa-chart-area text-warning pe-2"></i><?= $item['kichthuoc'] ?> m²</small>
                                                        <small class=""><i class="fa fa-wifi text-warning pe-2"></i>miễn phí</small>
                                                    </div>
                                                    <p class="item-desc"><?= $item['mota'] ?></p>

                                                    <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                                                    <input type="hidden" name="giaphong" value="<?= $giaphong ?>">
                                                    <input type="hidden" id="sophongtrong" value="<?= $item['soluongphongtrong'] ?>">

                                                    <div class="d-flex justify-content-between">
                                                        <a class="btn btn-sm btn-warning rounded fw-bold py-2 px-3" href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>">Xem chi tiết</a>
                                                        <button type="submit" name="booknow" onclick="clickBooknow(event, '<?= $item['idphong'] ?>');" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                            <i id="right" class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </section>
    <!-- Room End -->

    <!-- Service -->
    <section class="service pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-secondary text-uppercase">Dịch vụ của khách sạn</h6>
                <h2 class="title-name-below mb-5">Khám phá <span class="text-warning text-uppercase">Dịch vụ Nổi bật</span></h2>
            </div>
            <div class="row g-4">

                <?php if (!empty($data['services'])) :
                    foreach ($data['services'] as $item) : ?>

                        <div class="col-lg-4 col-md-6">
                            <a href="<?= URLROOT ?>/contact">
                                <div class="service-item line-bottom">
                                    <div class="service-img">
                                        <img src="<?= USER_PATH ?>/images/services/<?= $item['icon'] ?>" alt="icon">
                                    </div>
                                    <h5 class="mb-3 text-black"><?= $item['tendichvu'] ?></h5>
                                    <p class="text-body"><?= $item['mota'] ?></p>
                                </div>
                            </a>
                        </div>

                <?php endforeach;
                endif; ?>

            </div>
        </div>
    </section>
    <!-- Service End -->

    <?php include APPROOT . '/views/user/includes/comment.php'; ?>

</Main>