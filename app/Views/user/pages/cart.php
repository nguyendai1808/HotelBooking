<Main class="container-fluid" id="cart-page">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/bg-img.jpg" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Giỏ hàng</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><span>Giỏ hàng</span></li>
                </ul>
            </div>
        </div>
    </section>

    <?php include APPROOT . '/views/user/includes/changedate.php'; ?>

    <!-- Cart start -->
    <section class="cart pb-5">

        <?php if (!empty($data['cartNumber']) && !empty($data['cartItem'])) : ?>

            <div class="container">
                <div id="cart-his">
                    <a href="<?= URLROOT ?>/history" class="btn-cart-his">Lịch sử đặt phòng</a>
                </div>
            </div>

            <div class="cart-wrapper m-0">
                <div class="container">
                    <div class="row">
                        <!-- room-item start -->
                        <div class="col-lg-8 mb-3">

                            <?php $stt = 1;
                            foreach ($data['cartItem'] as $item) : ?>

                                <div class="room-item border mb-3" id="form-<?= $stt ?>">
                                    <div class="form-item col-12">
                                        <div class="item-img">
                                            <a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><img src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>"></a>

                                            <?php if (!empty($item['khuyenmai'])) : ?>
                                                <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                            <?php endif; ?>

                                        </div>
                                        <div class="item-detail">
                                            <div class="d-flex justify-content-between">
                                                <h5><a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h5>
                                                <a href="<?= URLROOT ?>/cart/deleteCart/<?= $item['iddatphong'] ?>" class="item-delete"><i class="fa fa-trash-can"></i></a>
                                            </div>

                                            <div class="item-date">
                                                <span id="arrival-date"><?= $item['ngayden'] ? date('d-m-Y', strtotime($item['ngayden'])) : 'Ngày đến' ?></span>
                                                <i class="bi bi-arrow-right-short"></i>
                                                <span id="departure-date"><?= $item['ngaydi'] ? date('d-m-Y', strtotime($item['ngaydi'])) : 'Ngày đi' ?></span>
                                                <a href="javascript:void(0);" onclick="openChangeCartDate('form-<?= $stt ?>')">
                                                    <i class="fa fa-pen-to-square ps-1"></i>
                                                </a>
                                            </div>

                                            <p class="mb-2 fw-bold"><span class="text-success"><?= $item['loaihinhtt'] ?></span></p>

                                            <?php $giaphong = $item['giaphong'];
                                            if (!empty($item['khuyenmai'])) :
                                                $giaphong = $item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong']); ?>

                                                <h6 class="item-price"><del><?= number_format($item['giaphong'], 0, ',', '.') ?></del> <?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                                            <?php else : ?>

                                                <h6 class="item-price"><?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                                            <?php endif; ?>

                                            <div class="quantity-cd">
                                                <span class="me-2">Số lượng: </span>
                                                <div class="quantity">
                                                    <span class="minus">-</span>
                                                    <input type="number" class="num item-quantity" id="soluongdat" value="<?= $item['soluongdat'] ?>" min="1" max="100">
                                                    <span class="plus">+</span>
                                                </div>
                                            </div>

                                            <input type="hidden" id="ngayden" value="<?= $item['ngayden'] ?>">
                                            <input type="hidden" id="ngaydi" value="<?= $item['ngaydi'] ?>">
                                            <input type="hidden" id="giaphong" value="<?= $giaphong ?>">
                                            <input type="hidden" id="iddatphong" value="<?= $item['iddatphong'] ?>">
                                            <button class="btn-item-update" onclick="updateCart('form-<?= $stt ?>')">Cập nhật</button>
                                        </div>
                                    </div>

                                    <div class="item-total col-12 border-top">
                                        <div class="w-25">
                                            <input class="form-check-input m-0" type="checkbox" id="checkbox-item-<?= $stt ?>" onchange="checkboxChange(this,'form-<?= $stt ?>')">
                                            <label for="checkbox-item-<?= $stt ?>"> Chọn</label>
                                        </div>
                                        <div class="w-75 d-flex justify-content-end text-end">
                                            <div class="pe-3">
                                                <span id="soluong"><?= $item['soluongdat'] ?></span> x phòng -
                                                <span id="songay"><?= $item['songay'] ?></span> ngày
                                            </div>
                                            <h6 class="m-0 fw-bold lh-base">Tổng: <span id="tonggia"><?= number_format($item['tonggia'], 0, ',', '.')  ?></span>đ</h6>
                                        </div>
                                    </div>
                                </div>

                            <?php $stt++;
                            endforeach; ?>

                        </div>
                        <!-- room-item end -->

                        <!-- cart-total start-->
                        <div class="col-lg-4">
                            <div class="cart-total">
                                <h5>Tổng giỏ hàng</h5>
                                <div class="cart-total-item mt-3">
                                    <div class="col-lg-12">
                                        <p>Số phòng: <span id="total-rooms" class="bold">0</span></p>
                                    </div>
                                    <div class="col-lg-12">
                                        <p>Tổng số tiền: <span id="total-payment" class="bold">0đ</span></p>
                                    </div>
                                    <div class="col-lg-12 mt-3 text-end">
                                        <button class="btn-booking" onclick="bookingRoom()">Đặt phòng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- cart-total end -->
                    </div>
                </div>
            </div>

        <?php else : ?>

            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-12 mb-4">
                        <h2>Giỏ hàng của bạn đang trống</h2>
                        <a href="<?= URLROOT ?>/room"><i class="fa-solid fa-arrow-right pe-2"></i>Đặt phòng ngay</a>
                    </div>
                    <div id="cart-his" class="col-md-4 col-sm-12 mb-3">
                        <a href="<?= URLROOT ?>/history" class="btn-cart-his">Lịch sử đặt phòng</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </section>
    <!-- Cart end -->

</Main>