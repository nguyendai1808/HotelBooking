<h2 class="title">Danh sách các phòng đã đặt</h2>
<div class="myinfor-history m-0">
    <div class="col-12 mb-3">

        <?php
        if (isset($data['booked'])) {
            $booked = $data['booked'];
        }
        if (!empty($booked)) :
            $stt = 1;
            foreach ($booked as $item) : ?>

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
                                <a href="#"><img class="item-rating" src="<?= USER_PATH ?>/icon/rating.png" alt="rating"></a>
                            </div>

                            <div class="item-date">
                                <span id="arrival-date"><?= $item['ngayden'] ? date('d-m-Y', strtotime($item['ngayden'])) : '' ?></span>
                                <i class="bi bi-arrow-right-short"></i>
                                <span id="departure-date"><?= $item['ngaydi'] ? date('d-m-Y', strtotime($item['ngaydi'])) : '' ?></span>
                            </div>

                            <p class="mb-2 fw-bold"><span class="text-success"><?= $item['loaihinhtt'] ?></span></p>

                            <?php $giaphong = $item['giaphong'];
                            if (!empty($item['khuyenmai'])) :
                                $giaphong = $item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong']); ?>

                                <h6 class="item-price"><del><?= number_format($item['giaphong'], 0, ',', '.') ?></del> <?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                            <?php else : ?>

                                <h6 class="item-price"><?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                            <?php endif; ?>

                            <input type="hidden" id="ngayden" value="<?= $item['ngayden'] ?>">
                            <input type="hidden" id="ngaydi" value="<?= $item['ngaydi'] ?>">
                            <input type="hidden" id="giaphong" value="<?= $giaphong ?>">
                            <input type="hidden" id="iddatphong" value="<?= $item['iddatphong'] ?>">

                            <div class="d-flex justify-content-between">
                                <p class="m-0"></p>
                                <button class="btn-item-review" type="submit">Đặt Lại</button>
                            </div>
                        </div>
                    </div>

                    <div class="item-total col-12 border-top">
                        <div class="w-25 text-center d-flex flex-column">
                            <span class="fw-bold text-success"><?= $item['trangthaidon'] ?></span>
                            <span><?= date('d-m-Y', strtotime($item['thoigiandat'])) ?></span>
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
            endforeach;
        else : ?>

            <h5>Bạn chưa đặt phòng nào cả!</h5>

        <?php endif; ?>

    </div>
</div>