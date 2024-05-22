<Main class="container-fluid" id="detailroom-page">

    <!-- banner image Start -->
    <section class="banner-image">
        <img src="<?= USER_PATH ?>/images/bg-img.jpg" alt="banner">
    </section>
    <!-- banner image end -->

    <?php include APPROOT . '/views/user/includes/booking.php'; ?>


    <?php include APPROOT . '/views/user/includes/changedate.php'; ?>


    <!-- detail room start -->
    <section class="detailroom">
        <div class="container">
            <div class="detailroom-content">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="detail-image">
                            <div class="wrapper-img">
                                <img id="main-img" src="#" alt="img">
                                <div class="list-img">
                                    <i class="left bi bi-chevron-left"></i>
                                    <div class="carousel">

                                        <?php if (!empty($data['roomImgs'])) :
                                            foreach ($data['roomImgs'] as $item) : ?>

                                                <img src="<?= USER_PATH ?>/<?= $item['duongdan'] ?>/<?= $item['tenanh'] ?>" alt="img">

                                            <?php endforeach; ?>
                                        <?php else : ?>

                                            <img src="<?= USER_PATH ?>/images/notImage.jpg" alt="img">

                                        <?php endif; ?>

                                    </div>
                                    <i class="right bi bi-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <?php if (!empty($data['room'])) :
                            foreach ($data['room'] as $item) : ?>
                                <form class="detail-form" method="post" action="<?= URLROOT ?>/room/addcart">
                                    <div class="detail-desc pb-3">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4 class="m-0"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></h4>
                                            <span class="fw-bold text-success"> <?= !empty($item['danhgia']) ? $item['danhgia'] : ''; ?></span>
                                        </div>

                                        <?php $giaphong = $item['giaphong'];
                                        if (!empty($item['khuyenmai'])) :
                                            $giaphong = $item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong']); ?>

                                            <p class="text-warning">Khuyến mãi: <span><?= $item['khuyenmai'] ?>%</span></p>
                                            <h5><del><?= number_format($item['giaphong'], 0, ',', '.') ?>đ</del> <?= number_format($giaphong, 0, ',', '.') ?>đ</h5>

                                        <?php else : ?>

                                            <h5><?= number_format($giaphong, 0, ',', '.') ?>đ</h5>

                                        <?php endif; ?>

                                        <p><?= $item['mota'] ?></p>

                                        <p class="text-body"><i class="fa fa-chart-area text-warning pe-2"></i>Kích thước: <?= $item['kichthuoc'] ?> m² - <i class="fa fa-bed text-warning pe-2"></i>Số giường: <?= $item['sogiuong'] ?></p>

                                        <h6 class="text-primary fw-bold">Loại hình thanh toán: <span class="text-success"><?= $item['loaihinhtt'] ?></span></h6>

                                        <div class="d-flex justify-content-between">
                                            <?php if (empty($item['trenho'])) : ?>
                                                <p class="text-body">Người lớn: <?= $item['nguoilon'] ?></p>
                                            <?php else : ?>
                                                <p class="text-body">Người lớn: <?= $item['nguoilon'] ?> - Trẻ nhỏ: <?= $item['trenho'] ?></p>
                                            <?php endif ?>

                                            <p>Phòng trống: 12</p>
                                        </div>

                                        <div class="quantity-cd">
                                            <span class="me-2">Số lượng: </span>
                                            <div class="quantity">
                                                <span class="minus">-</span>
                                                <input type="number" class="num" name="soluongdat" value="1" min="1" max="100">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>

                                        <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                                        <input type="hidden" name="giaphong" value="<?= $giaphong ?>">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" name="addcart" class="btn btn-sm btn-warning rounded py-2 px-4 fw-bold">Thêm vào giỏ hàng</button>
                                        <button type="submit" name="booknow" onclick="clickBooknow(event);" formaction="<?= URLROOT ?>/payment" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
                                    </div>
                                </form>
                        <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>

            <div class="review-amenities mb-5">
                <div class="tab-buttons">
                    <div class="tab-button me-3" onclick="openTab('amenities')" id="tabAmenities">Tiện nghi</div>
                    <div class="tab-button" onclick="openTab('reviews')" id="tabReviews">Đánh giá</div>
                </div>

                <div id="amenities" class="tab-content">
                    <div class="amenities-content">
                        <?php if (!empty($data['amenities'])) :
                            $amenities = $data['amenities'];
                            $total_items = count($amenities);

                            // Tính toán số lượng item cho mỗi cột
                            $items_per_column = ceil($total_items / 2);

                            $count = 0;
                            echo '<div class="row">';
                            for ($i = 0; $i < 2; $i++) {
                                echo '<div class="col-md-6">';
                                echo '<ul class="list-amenities">';
                                for ($j = 0; $j < $items_per_column; $j++) {
                                    if ($count < $total_items) {
                                        echo '<li><img src="' . USER_PATH . '/images/amenities/' . $amenities[$count]['icon'] . '" alt="icon">' . $amenities[$count]['tentiennghi'] . '</li>';
                                        $count++;
                                    } else {
                                        break;
                                    }
                                }
                                echo '</ul>';
                                echo '</div>';
                            }
                            echo '</div>';
                        endif;
                        ?>
                    </div>
                </div>

                <div id="reviews" class="tab-content">
                    <div class="room-rating mb-3 border-bottom">
                        <div class="row">
                            <div class="rating-title mb-3 col-12">
                                <h4 class="m-0 pe-3">9,5/10 Tuyệt vời</h4>
                                <a href="#"><span>(232 đánh giá)</span></a>
                            </div>
                            <div class="rating-box col-lg-6">
                                <div class="rating-text">
                                    <span class="title">Sạch sẽ</span>
                                    <span class="score">9,5 điểm</span>
                                </div>
                                <div class="rating-bar">
                                    <span class="score-bar" style="width: 90%;"></span>
                                </div>
                            </div>
                            <div class="rating-box col-lg-6">
                                <div class="rating-text">
                                    <span class="title">Thoải mãi & chất lượng</span>
                                    <span class="score">9,5 điểm</span>
                                </div>
                                <div class="rating-bar">
                                    <span class="score-bar" style="width: 40%;"></span>
                                </div>
                            </div>
                            <div class="rating-box col-lg-6">
                                <div class="rating-text">
                                    <span class="title">Tiện nghi</span>
                                    <span class="score">9,5 điểm</span>
                                </div>
                                <div class="rating-bar">
                                    <span class="score-bar" style="width: 80%;"></span>
                                </div>
                            </div>
                            <div class="rating-box col-lg-6">
                                <div class="rating-text">
                                    <span class="title">Dịch vụ</span>
                                    <span class="score">9,5 điểm</span>
                                </div>
                                <div class="rating-bar">
                                    <span class="score-bar" style="width: 70%;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-box mt-4">
                        <div class="review-item">
                            <div class="review-user">
                                <img class="user-avatar" src="images/hotel/hotel-1.jpg" alt="Avatar">
                                <div>
                                    <strong>Người dùng 1</strong>
                                    <p class="m-0">12-09-2024</p>
                                </div>
                                <small><i class="fa-solid fa-quote-right fa-2x"></i></small>
                            </div>
                            <ul class="rating">
                                <li class="lable">Đánh giá:</li>
                                <li class="text-success">Sạch sẽ: 9đ</li>
                                <li class="text-success">Tiện nghi phòng: 9đ</li>
                                <li class="text-success">Thoái mái: 8đ</li>
                                <li class="text-success">Dịch vụ: 8đ</li>
                            </ul>
                            <p class="cmt">Bình luận: <span>tốt</span></p>
                        </div>

                        <div class="review-item">
                            <div class="review-user">
                                <img class="user-avatar" src="images/hotel/hotel-1.jpg" alt="Avatar">
                                <strong>Người dùng 1</strong>
                                <small><i class="fa-solid fa-quote-right fa-2x"></i></small>
                            </div>
                            <ul class="rating">
                                <li class="lable">Đánh giá:</li>
                                <li class="text-success">Sạch sẽ: 9đ</li>
                                <li class="text-success">Tiện nghi phòng: 9đ</li>
                                <li class="text-success">Thoái mái: 8đ</li>
                                <li class="text-success">Dịch vụ: 8đ</li>
                            </ul>
                            <p class="cmt">Bình luận: <span>tốt</span></p>
                        </div>

                    </div>


                </div>
            </div>



        </div>
    </section>
    <!-- detail room End -->

    <!-- room more Start -->
    <section class="room-suggestion pt-5 pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-warning text-uppercase">xem thêm phòng</h6>
                <h2 class="title-name-below mb-5">Gợi ý những <span class="text-warning text-uppercase">Phòng tương tự</span></h2>
            </div>

            <div class="room-slider">
                <div class="slider-wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">

                        <?php if (!empty($data['roomMore'])) :
                            foreach ($data['roomMore'] as $item) :
                                $giaphong = !empty($item['khuyenmai']) ? ($item['giaphong'] - ($item['khuyenmai'] * 0.01 * $item['giaphong'])) :  $item['giaphong']; ?>

                                <li class="card">
                                    <div class="room">
                                        <div class="room-item rounded overflow-hidden">
                                            <div class="room-img p-3">
                                                <img class="img-fluid" src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="image" draggable="false">
                                                <small class="item-price"><?= number_format($giaphong) ?> đ/đêm</small>
                                                <small class="item-payment"><?= $item['loaihinhtt'] ?></small>
                                                <?php if (!empty($item['khuyenmai'])) : ?>
                                                    <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                                <?php endif; ?>

                                            </div>
                                            <div class="room-infor p-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h5 class="item-name mb-0"><a href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h5>
                                                    <span class="ps-3 fw-bold text-success"><?= !empty($item['danhgia']) ? $item['danhgia'] : ''; ?></span>
                                                </div>
                                                <div class="d-flex mb-2">
                                                    <small class="border-end me-2 pe-2"><i class="fa fa-bed text-warning pe-2"></i><?= $item['sogiuong'] ?> giường</small>
                                                    <small class="border-end me-2 pe-2"><i class="fa fa-chart-area text-warning pe-2"></i><?= $item['kichthuoc'] ?> m²</small>
                                                    <small class=""><i class="fa fa-wifi text-warning pe-2"></i>miễn phí</small>
                                                </div>
                                                <p class="item-desc"><?= $item['mota'] ?></p>

                                                <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                                                <input type="hidden" name="giaphong" value="<?= $giaphong ?>">
                                            </div>
                                        </div>
                                    </div>
                                </li>

                        <?php endforeach;
                        endif; ?>

                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>

    </section>
    <!-- room more End -->

</Main>