<Main class="container-fluid">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg' ?>" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Thanh toán</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><a href="<?= URLROOT ?>/room">Phòng</a></li>
                    <li><span>Thanh toán</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="pay mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">

                    <?php if (!empty($data['account'])) : $account =  $data['account'];
                    endif; ?>

                    <div class="infor-customer mb-4 border bg-white p-4" id="form-customer">
                        <h5 class="pb-3">Thông tin khách hàng</h5>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Họ và tên <span>*</span></label>
                                <input type="text" class="form-control" id="fullname" value="<?= trim(($account[0]['ho'] ?? '') . ' ' . ($account[0]['ten'] ?? '')) ?>" placeholder="Họ và tên">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Số điện thoại <span>*</span></label>
                                <input type="tel" class="form-control" id="phone" value="<?= $account[0]['sdt'] ?? '' ?>" placeholder="Số điện thoại">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Email <span>*</span></label>
                                <input type="email" class="form-control" id="email" value="<?= $account[0]['email'] ?? '' ?>" placeholder="Email">
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Địa chỉ</label>
                                <textarea id="address" class="form-control" rows="3" placeholder="Địa chỉ"><?= $account[0]['diachi'] ?? '' ?></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <small><span>(*)</span> bắt buộc</small>
                            </div>
                        </div>
                    </div>

                    <div class="pay-infor mb-4 border bg-white p-4">
                        <h5 class="pb-3">Thông tin quan trọng</h5>
                        <ul>
                            <li>
                                <p>Khách sạn sẽ thu <span>50% tiền giữ phòng</span> với những đơn <span>đặt phòng trả sau</span>.</p>
                            </li>
                            <li>
                                <p>Khi khách hàng <span>hủy đặt phòng</span> với những đơn <span>đặt phòng trả sau</span>, khách sạn sẽ <span>thu 50% giá trị tiền đặt phòng trước đó</span>.</p>
                            </li>
                            <li>
                                <p>Khi khách hàng <span>hủy đặt phòng</span> với những đơn <span>đã thanh toán</span>, khách sạn sẽ <span>thu 25% giá trị tiền đã thanh toán</span>, xem chi tiết <a href="<?= URLROOT ?>/information"><span>chính sách hủy và hoàn trả tiền</span></a>.</p>
                            </li>
                            <li>
                                <p><span>Thời gian hủy</span> sẽ là trước <span>ngày nhận phòng 1 tuần</span>.</p>
                            </li>
                            <li>
                                <p>Sẽ không hoàn lại tiền nếu nhận phòng trễ hoặc trả phòng sớm.</p>
                            </li>
                            <li>
                                <p>Tuân theo <a href="<?= URLROOT ?>/information"><span>điều khoản sử dụng</span></a> và <a href="<?= URLROOT ?>/information"><span>chính sách bảo mật</span></a> của khách sạn.</p>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="col-lg-5">
                    <form class="pay-total border p-3 bg-white" action="<?= URLROOT ?>/payment/paynow" method="post" onsubmit="return checkFormCustomer();">
                        <h5 class="mb-3 about about-img about-list-img">Chi tiết đặt phòng</h5>
                        <div class="pay-bill">
                            <div class="col-lg-12">
                                <ul class="ps-3">

                                    <?php $tongsotien = 0;
                                    $sotiendatphong = 0;
                                    if (!empty($data['booking'])) :
                                        foreach ($data['booking'] as $item) :
                                            if (count($data['booking']) > 1) {
                                                if (strpos($item['loaihinhtt'], 'Trả sau')) {
                                                    $sotiendatphong += (intval($item['tonggia']) * 0.5);
                                                } else {
                                                    $sotiendatphong += intval($item['tonggia']);
                                                }
                                            } else {
                                                if (strpos($item['loaihinhtt'], 'Trả sau')) {
                                                    $sotiendatphong += (intval($item['tonggia']) * 0.5);
                                                }
                                            }
                                            $tongsotien += $item['tonggia']; ?>

                                            <li class="mb-2"><?= $item['soluongdat'] ?> x <?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?> x <?= $item['songay'] ?> ngày = <?= number_format($item['tonggia'], 0, ',', '.') ?>đ</li>

                                    <?php endforeach;
                                    endif; ?>

                                </ul>
                            </div>

                            <div class="col-lg-12">
                                <p class="fw-bold m-0">Tổng số tiền:</p>

                                <input type="hidden" name="booking" value="<?= htmlspecialchars(json_encode($data['booking'])) ?>">
                                <input type="hidden" name="tongsotien" value="<?= $tongsotien ?>">
                                <input type="hidden" name="sotiendatphong" value="<?= $sotiendatphong ?>">

                                <ul class="ps-3">
                                    <?php if ($sotiendatphong != 0) : ?>
                                        <li class="mb-2">
                                            Đặt phòng <small class="text-muted me-2">(Thanh toán nốt khi nhận phòng)</small>
                                            <span class="fw-bold"><?= number_format($sotiendatphong, 0, ',', '.') ?>đ</span>
                                        </li>
                                    <?php endif; ?>

                                    <li class="mb-2">
                                        Thanh toán ngay <small class="text-muted me-2">(Hoàn tất đặt phòng)</small>
                                        <span class="fw-bold"><?= number_format($tongsotien, 0, ',', '.') ?>đ</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">

                            <?php if ($sotiendatphong != 0) : ?>

                                <button type="submit" name="bookroom" value="book" formaction="<?= URLROOT ?>/payment/bookroom" class="btn btn-success fw-bold">Đặt phòng</button>

                            <?php endif; ?>

                            <button type="submit" name="paynow" value="pay" class="btn btn-warning fw-bold">Thanh toán ngay</button>
                        </div>
                    </form>

                    <div class="pay-room mt-4">

                        <?php if (!empty($data['booking'])) :
                            foreach ($data['booking'] as $item) : ?>

                                <div class="room-item border mb-3">
                                    <div class="form-item col-12 d-flex">
                                        <div class="item-img">
                                            <a href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>"><img src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>"></a>

                                            <?php if (!empty($item['khuyenmai'])) : ?>
                                                <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                                            <?php endif; ?>

                                        </div>
                                        <div class="item-detail">

                                            <h6><a href="<?= URLROOT ?>/room/detailroom/<?= $item['idphong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h6>

                                            <div class="item-date">
                                                <span id="arrival-date"><?= date('d-m-Y', strtotime($item['ngayden'])) ?></span>
                                                <i class="bi bi-arrow-right-short"></i>
                                                <span id="departure-date"><?= date('d-m-Y', strtotime($item['ngaydi'])) ?></span>
                                            </div>

                                            <p class="mb-2 fw-bold"><span class="text-success"><?= $item['loaihinhtt'] ?></span></p>

                                            <?php $giaphong = $item['giaphong'];
                                            if (!empty($item['khuyenmai'])) :
                                                $giaphong = $item['giaphong'] - ($item['khuyenmai'] * 0.01 * $item['giaphong']); ?>

                                                <h6 class="item-price"><del><?= number_format($item['giaphong'], 0, ',', '.') ?></del> <?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                                            <?php else : ?>

                                                <h6 class="item-price"><?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                                            <?php endif; ?>

                                            <p class="m-0">Số lượng: <?= $item['soluongdat'] ?></p>
                                        </div>
                                    </div>
                                    <div class="item-total col-12 border-top justify-content-between">
                                        <div class="pe-3">
                                            <span><?= $item['soluongdat'] ?> x phòng</span>
                                            <span> - <?= $item['songay'] ?> ngày</span>
                                        </div>
                                        <p class="m-0 fw-bold">Tổng: <span><?= number_format($item['tonggia'], 0, ',', '.') ?></span>đ</p>
                                    </div>
                                </div>

                        <?php endforeach;
                        endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

</Main>