<Main class="container-fluid" id="detailroom-page">

    <!-- banner image Start -->
    <section class="banner-image">
        <img src="<?= USER_PATH ?>/images/bg-img-2.jpg" alt="banner">
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
                        <div class="detail-image" id="detail-image">
                            <div class="wrapper-img">
                                <img id="main-img" src="#" alt="img">
                                <div class="list-img">
                                    <i class="left bi bi-chevron-left"></i>
                                    <div class="carousel">

                                        <?php if (!empty($data['roomImgs'])) :
                                            foreach ($data['roomImgs'] as $item) : ?>

                                                <img src="<?= USER_PATH ?>/<?= !empty($item['anh']) ? $item['anh'] : 'images/notImage.jpg'; ?>" alt="img">

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
                                <form class="detail-form" method="post" action="<?= URLROOT ?>/room/addcart" onsubmit="return checkEmptyRoom()">
                                    <div class="detail-desc pb-3">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h4 class="m-0"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></h4>
                                            <span class="fw-bold text-success h5 ps-3"> <?= !empty($item['danhgia']) ?  round($item['danhgia'], 1) . '/10' : ''; ?></span>
                                        </div>

                                        <?php $giaphong = $item['giaphong'];
                                        if (!empty($item['khuyenmai'])) :
                                            $giaphong = $item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong']); ?>

                                            <p class="text-warning">Khuyến mãi: <span><?= $item['khuyenmai'] ?>%</span></p>
                                            <h5><del><?= number_format($item['giaphong'], 0, ',', '.') ?>đ</del> <?= number_format($giaphong, 0, ',', '.') ?>đ/đêm</h5>

                                        <?php else : ?>

                                            <h5><?= number_format($giaphong, 0, ',', '.') ?>đ/đêm</h5>

                                        <?php endif; ?>

                                        <p><?= $item['mota'] ?></p>

                                        <p class="text-body"><i class="fa fa-chart-area text-warning pe-2"></i>Kích thước: <?= $item['kichthuoc'] ?> m²<i class="fa fa-bed text-warning pe-2 ps-2 border-start ms-2"></i>Số giường: <?= $item['sogiuong'] ?></p>

                                        <h6 class="text-primary fw-bold">Loại hình thanh toán: <span class="text-success"><?= $item['loaihinhtt'] ?></span></h6>

                                        <div class="d-flex justify-content-between">
                                            <?php if (empty($item['trenho'])) : ?>
                                                <p class="text-body">Người lớn: <?= $item['nguoilon'] ?></p>
                                            <?php else : ?>
                                                <p class="text-body">Người lớn: <?= $item['nguoilon'] ?> - Trẻ nhỏ: <?= $item['trenho'] ?></p>
                                            <?php endif ?>

                                            <?php $color_r = intval($item['soluongphongtrong']) < 5 ? 'danger' : 'secondary'; ?>

                                            <p class="text-<?= $color_r ?>">Phòng trống: <span><?= $item['soluongphongtrong'] ?></span></p>

                                        </div>

                                        <?php if ($item['soluongphongtrong'] > 0) : ?>
                                            <div class="quantity-cd">
                                                <span class="me-2">Số lượng: </span>
                                                <div class="quantity">
                                                    <span class="minus">-</span>
                                                    <input type="number" class="num" name="soluongdat" value="1" min="1" max="<?= $item['soluongphongtrong'] ?>" readonly>
                                                    <span class="plus">+</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <input type="hidden" id="sophongtrong" value="<?= $item['soluongphongtrong'] ?>">
                                        <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                                        <input type="hidden" name="giaphong" value="<?= $giaphong ?>">

                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" name="addcart" class="btn btn-sm btn-warning rounded py-2 px-4 fw-bold">Thêm vào giỏ hàng</button>
                                        <button type="submit" name="booknow" onclick="clickBooknow(event, '<?= $item['idphong'] ?>');" formaction="<?= URLROOT ?>/payment" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
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
                        else : ?>

                            <p class="h6">Không có tiện nghi nào!</p>

                        <?php endif; ?>

                    </div>
                </div>

                <div id="reviews" class="tab-content">

                    <?php if (!empty($data['detailRating']) && !empty($data['ratingUser'])) :
                        $rating = $data['detailRating']; ?>

                        <div class="room-rating mb-3 border-bottom">
                            <div class="row">
                                <div class="rating-title mb-3 col-12">

                                    <h4 class="m-0 pe-3"><?= round($rating[0]['tongdiem'], 1) ?? '' ?>/10 Tuyệt vời</h4>

                                    <span class="text-secondary">(<?= $rating[0]['sodanhgia'] ?? '' ?> đánh giá)</span>
                                </div>

                                <?php if (!empty($rating[0]['diemtheotieuchi'])) :
                                    foreach ($rating[0]['diemtheotieuchi'] as $item) : ?>

                                        <div class="rating-box col-lg-6">
                                            <div class="rating-text">
                                                <span class="title"><?= $item['tentieuchi'] ?? '' ?></span>
                                                <span class="score"><?= round($item['sodiem'], 1)  ?? '' ?> điểm</span>
                                            </div>
                                            <div class="rating-bar">
                                                <span class="score-bar" style="width: <?= intval($item['sodiem']) * 10 ?? 0 ?>%;"></span>
                                            </div>
                                        </div>

                                <?php endforeach;
                                endif; ?>

                            </div>

                        </div>

                        <div class="review-box mt-4" id="ratingUser">

                            <?php foreach ($data['ratingUser'] as $item) : ?>

                                <div class="review-item">
                                    <div class="review-user">
                                        <img class="user-avatar" src="<?= USER_PATH ?>/images/avatars/<?= empty($item['anh']) ? 'user.png' : $item['anh'] ?>" alt="avatar">
                                        <div>
                                            <strong><?= trim($item['ho'] . ' ' . $item['ten']) ?></strong>
                                            <p class="m-0"><?= $item['thoigian'] ? date('d-m-Y', strtotime($item['thoigian'])) : '' ?></p>
                                        </div>

                                        <div class="dropdown">
                                            <button><i class="fa-solid fa-ellipsis-vertical"></i></button>

                                            <?php if ($item['id_taikhoan'] == $data['user_id']) : ?>

                                                <form class="content" method="post" action="<?= URLROOT ?>/room/rating">
                                                    <button type="submit" name="delete" value="<?= $item['iddanhgia'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này');">
                                                        <i class="fa-solid fa-delete-left pe-2"></i>Xóa
                                                    </button>
                                                </form>

                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <ul class="rating">
                                        <li class="lable">Đánh giá:</li>

                                        <?php foreach ($item['chitietdanhgia'] as $row) : ?>

                                            <li class="text-success"><?= $row['tentieuchi'] ?? '' ?>: <?= round($row['sodiem'], 1)  ?? '' ?>đ</li>

                                        <?php endforeach; ?>

                                    </ul>
                                    <p class="cmt">Bình luận: <span><?= $item['noidung'] ?></span></p>
                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php else : ?>

                        <p class="h6">Chưa có đánh giá nào!</p>

                    <?php endif; ?>


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
                                    <li><a href="<?= URLROOT ?>/room/ratingPage/1"><i class="fa-solid fa-angles-left"></i></a></li>
                                <?php endif; ?>

                                <?php for ($i = $start; $i <= $end; $i++) : ?>
                                    <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/room/ratingPage/<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages) : ?>
                                    <li><a href="<?= URLROOT ?>/room/ratingPage/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                                <?php endif; ?>
                            </ul>

                        <?php endif; ?>

                    </div>
                    <!-- End Pagination -->

                </div>
            </div>
        </div>
    </section>
    <!-- detail room End -->

    <!-- room more Start -->
    <section class="room-suggestion pt-5 pb-5">
        <div class="container">

            <?php if (!empty($data['roomMore'])) : ?>

                <div class="text-center">
                    <h6 class="section-title text-center text-warning text-uppercase">xem thêm phòng</h6>
                    <h2 class="title-name-below mb-5">Gợi ý những <span class="text-warning text-uppercase">Phòng tương tự</span></h2>
                </div>
                <div class="room-slider">
                    <div class="slider-wrapper">
                        <i id="left" class="fa-solid fa-angle-left"></i>
                        <ul class="carousel">

                            <?php foreach ($data['roomMore'] as $item) :
                                $giaphong = !empty($item['khuyenmai']) ? ($item['giaphong'] - ($item['khuyenmai'] * 0.01 * $item['giaphong'])) :  $item['giaphong']; ?>

                                <li class="card">
                                    <div class="room">
                                        <div class="room-item rounded overflow-hidden">
                                            <div class="room-img p-3">
                                                <img class="img-fluid" src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="image" draggable="false">
                                                <small class="item-price"><?= number_format($giaphong, 0, ',', '.') ?> đ/đêm</small>
                                                <small class="item-payment"><?= $item['loaihinhtt'] ?></small>
                                                <?php if (!empty($item['khuyenmai'])) : ?>
                                                    <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                                <?php endif; ?>

                                            </div>
                                            <div class="room-infor p-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h5 class="item-name mb-0"><a href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h5>
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
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            <?php endforeach; ?>

                        </ul>
                        <i id="right" class="fa-solid fa-angle-right"></i>
                    </div>
                </div>

            <?php endif; ?>

        </div>

    </section>
    <!-- room more End -->

</Main>