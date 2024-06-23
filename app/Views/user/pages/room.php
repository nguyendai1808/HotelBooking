<Main class="container-fluid" id="room-page">

    <!-- banner image Start -->
    <section class="banner-image">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg' ?>" alt="banner">
    </section>
    <!-- banner image end -->

    <?php include APPROOT . '/views/user/includes/booking.php'; ?>

    <!-- input date start-->
    <?php include APPROOT . '/views/user/includes/changedate.php'; ?>
    <!-- input date end-->


    <!-- Room Start -->
    <section class="room pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-secondary text-uppercase">Phòng của HotelStay</h6>
                <h2 class="title-name-below mb-5">Khám phá <span class="text-warning text-uppercase">Phòng nổi bật</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <!-- Start Sidebar Area -->
                    <div class="sidebar-section">
                        <div class="sidebar-category mb-5">
                            <h5 class="sidebar-title">Danh mục phòng</h5>
                            <div class="sidebar-content pt-3" id="category">
                                <ul class="sidebar-menu">
                                    <li data-id="all">Tất cả các phòng</li>

                                    <?php if (!empty($data['categorys'])) :
                                        foreach ($data['categorys'] as $item) : ?>
                                            <li data-id="<?= $item['iddanhmuc'] ?>">
                                                <?= $item['tendanhmuc'] ?>
                                            </li>
                                    <?php endforeach;
                                    endif; ?>

                                </ul>
                            </div>
                        </div>


                        <!-- Start range price -->
                        <div class="sidebar-rangePrice mb-5">
                            <h5 class="sidebar-title">Lọc theo giá</h5>
                            <div class="sidebar-content pt-3">
                                <div class="rangePrice-item pt-3">
                                    <div class="slider">
                                        <div class="progress"></div>
                                    </div>
                                    <div class="range-input">
                                        <input type="range" id="range-min" class="range-min" min="0" max="<?= $data['rooms'][0]['max'] ?? 0 ?>" value="0" step="100">
                                        <input type="range" id="range-max" class="range-max" min="0" max="<?= $data['rooms'][0]['max'] ?? 0 ?>" value="<?= $data['rooms'][0]['max'] ?? 0 ?>" step="100">
                                    </div>
                                    <div class="price-input">
                                        <div class="field">
                                            <span>Min:</span>
                                            <input type="text" class="input-min" value="0đ" disabled>
                                        </div>
                                        <div class="field">
                                            <span>Max:</span>
                                            <input type="text" class="input-max" value="<?= number_format($data['rooms'][0]['max'], 0, ',', '.') ?? 0 ?>đ" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End range price -->

                        <!-- Start Sidebar bed -->

                        <div class="sidebar-bed mb-5">
                            <h5 class="sidebar-title">Giường</h5>
                            <div class="sidebar-content pt-3">
                                <?php if (!empty($data['beds'])) : ?>
                                    <?php foreach ($data['beds'] as $item) : ?>
                                        <div class="bed-item">
                                            <label class="checkbox-default">
                                                <input type="checkbox" class="bed-quantity" value="<?= $item['idgiuong'] ?>">
                                                <span><?= $item['tengiuong'] ?></span>
                                            </label>
                                            <div class="quantity" style="display: none;">
                                                <span class="minus">-</span>
                                                <input type="number" class="num" name="bed[<?= $item['idgiuong'] ?>]" min="1" max="10" value="1" readonly>
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>


                        <!-- End Sidebar bed -->


                    </div>
                    <!-- End Sidebar Area -->
                </div>

                <div class="col-lg-9">
                    <!-- Start List Room -->
                    <div class="list-room" id="list-room">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Start Room Sorting -->
                                    <div class="room-sort">
                                        <div class="sort-box">
                                            <div class="sort-select-list d-flex">
                                                <label class="pe-2">Sắp xếp theo:</label>
                                                <form action="#">
                                                    <fieldset>
                                                        <select id="sort-select" style="padding-left: 5px;">
                                                            <option>Mặc định</option>
                                                            <option value="rating">Điểm đánh giá</option>
                                                            <option value="low_to_high">Giá: thấp đến cao</option>
                                                            <option value="high_to_low">Giá: cao đến thấp</option>
                                                        </select>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Room Sorting -->

                                </div>
                                <div class="col-12">

                                    <!-- Start List room item -->
                                    <div class="list-room-item">
                                        <div class="row" id="room-items">

                                            <?php if (!empty($data['rooms'])) : $stt = 1;
                                                foreach ($data['rooms'] as $item) :
                                                    $giaphong = !empty($item['khuyenmai']) ? ($item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong'])) :  $item['giaphong']; ?>

                                                    <form class="col-12 mb-4 shadow rounded overflow-hidden" action="<?= URLROOT ?>/payment" method="post" id="form-<?= $stt ?>">
                                                        <div class="row">
                                                            <div class="room-img col-lg-5 p-3">
                                                                <img class="img-fluid" src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="img">

                                                                <?php if (!empty($item['khuyenmai'])) : ?>
                                                                    <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                                                <?php endif; ?>

                                                                <small class="item-price"><?= number_format($giaphong, 0, ',', '.') ?>đ/đêm</small>
                                                                <small class="item-payment"><?= $item['loaihinhtt'] ?? '' ?></small>
                                                            </div>
                                                            <div class="room-infor col-lg-7 p-3">
                                                                <div class="d-flex justify-content-between mb-3">
                                                                    <h5 class="mb-0"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></h5>
                                                                    <div class="ps-3">
                                                                        <span class="fw-bold text-success"><?= !empty($item['danhgia']) ?  round($item['danhgia'], 1) . '/10' : ''; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <p><?= $item['mota'] ?></p>
                                                                    <div class="d-flex mb-3">
                                                                        <small class="border-end me-2 pe-2"><i class="fa fa-bed text-warning pe-2"></i><?= $item['sogiuong'] ?> giường</small>
                                                                        <small class="border-end me-2 pe-2"><i class="fa fa-chart-area text-warning pe-2"></i><?= $item['kichthuoc'] ?> m²</small>
                                                                        <small><i class="fa fa-wifi text-warning pe-2"></i>miễn phí</small>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between">

                                                                    <?php if (empty($item['trenho'])) : ?>
                                                                        <p class="text-body">Người lớn: <?= $item['nguoilon'] ?></p>
                                                                    <?php else : ?>
                                                                        <p class="text-body">Người lớn: <?= $item['nguoilon'] ?> - Trẻ nhỏ: <?= $item['trenho'] ?></p>
                                                                    <?php endif ?>

                                                                    <?php $color_r = intval($item['soluongphongtrong']) < 5 ? 'danger' : 'secondary'; ?>

                                                                    <p class="text-<?= $color_r ?>">Phòng trống: <span><?= $item['soluongphongtrong'] ?></span></p>
                                                                </div>

                                                                <input type="hidden" id="idphong" name="idphong" value="<?= $item['idphong'] ?>">
                                                                <input type="hidden" name="giaphong" value="<?= $giaphong ?>">
                                                                <input type="hidden" id="sophongtrong" value="<?= $item['soluongphongtrong'] ?>">

                                                                <div class="d-flex justify-content-between">
                                                                    <a class="btn btn-sm btn-warning rounded fw-bold py-2 px-3" href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>">Xem chi tiết</a>
                                                                    <button type="submit" name="booknow" onclick="clickBooknow(event, '<?= $item['idphong'] ?>');" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                <?php endforeach;
                                            else : ?>

                                                <p class="fw-bold mt-5 text-center">Không có phòng nào cả!</p>

                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <!-- End List room item-->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End List Room -->

                    <!-- Start Pagination -->
                    <div class="page-pagination mt-5" id="pagination-links">
                        <?php
                        if (isset($data['pagination'])) : extract($data['pagination']);
                            $start = max($current_page - 1, 1);
                            $end = min($start + 2, $total_pages);

                            if ($current_page == $total_pages && $start > 1) :
                                $start--;
                            endif; ?>

                            <ul>
                                <?php if ($current_page > 1) : ?>
                                    <li><a href="<?= URLROOT ?>/room/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                                <?php endif; ?>

                                <?php for ($i = $start; $i <= $end; $i++) : ?>
                                    <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/room/page/<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>

                                <?php if ($current_page < $total_pages) : ?>
                                    <li><a href="<?= URLROOT ?>/room/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                                <?php endif; ?>
                            </ul>

                        <?php
                        endif; ?>

                    </div>
                    <!-- End Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!-- Room End -->


    <!-- Comment Start -->
    <?php include APPROOT . '/views/user/includes/comment.php'; ?>
    <!-- Comment End -->

</Main>