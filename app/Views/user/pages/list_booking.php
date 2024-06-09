<h3 class="title">Danh sách các phòng</h3>
<div class="myinfor-history m-0">
    <div class="col-12 mb-3">

        <?php
        if (isset($data['list_booking'])) {
            $list_booking = $data['list_booking'];
        }

        if (!empty($list_booking)) :
            $stt = 1;
            $action = !empty($list_booking[0]['invoice']) ? 'invoice' : 'history';
            foreach ($list_booking as $item) : ?>

                <div class="room-item border mb-3" id="form-<?= $stt ?>">
                    <form class="form-item col-12" action="<?= URLROOT ?>/<?= $action ?>/cancelRoom" method="post">
                        <div class="item-img">
                            <a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><img src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>"></a>

                            <?php if (!empty($item['khuyenmai'])) : ?>
                                <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                            <?php endif; ?>

                        </div>
                        <div class="item-detail">
                            <div class="d-flex justify-content-between">
                                <h5><a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h5>

                                <?php if ($item['trangthaidat'] == 'Hoàn tất' && $item['id_taikhoan']) : ?>
                                    <a href="#"><img class="item-rating" src="<?= USER_PATH ?>/icon/rating.png" alt="rating"></a>
                                <?php endif; ?>

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

                            <input type="hidden" name="iddatphong" value="<?= $item['iddatphong'] ?>">
                            <input type="hidden" name="trangthaidon" value="<?= $item['trangthaidon'] ?>">
                            <input type="hidden" name="iddondat" value="<?= $item['iddondat'] ?>">
                            <input type="hidden" name="soluonghuy" id="soluonghuy">

                            <div class="d-flex justify-content-between align-items-center">

                                <?php if ($item['trangthaidat'] == 'Hoàn tất' || $item['trangthaidat'] == 'Đã hủy') : ?>

                                    <button class="btn-invoice" type="submit" name="detail" value="<?= $item['iddondat'] ?>" formaction="<?= URLROOT ?>/invoice">ID đơn: <?= $item['iddondat'] ?></button>

                                    <a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>" class="btn-item-book">Đặt Lại</a>

                                <?php else : ?>

                                    <button class="btn-invoice" type="submit" name="detail" value="<?= $item['iddondat'] ?>" formaction="<?= URLROOT ?>/invoice">ID đơn: <?= $item['iddondat'] ?></button>

                                    <?php if (strtotime($item['ngayden']) > time()) : ?>

                                        <button class="btn-item-cancel" name="cancel" type="submit" onclick="return confirmAction(this, 'Bạn có chắc chắn muốn hủy không?') && inputNumber('form-<?= $stt ?>')">Hủy</button>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <div class="item-total col-12 border-top">
                        <div class="w-25 text-center d-flex flex-column">

                            <?php $color = ($item['trangthaidat'] == 'Đã hủy') ? 'danger'  : (($item['trangthaidat'] == 'Hoàn tất' || $item['trangthaidat'] == 'Đã thanh toán') ? 'success' : 'warning'); ?>

                            <span class="fw-bold text-<?= $color ?>"><?= $item['trangthaidat'] ?></span>

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

            <h5>Không có phòng nào cả!</h5>

        <?php endif; ?>

    </div>
</div>
<script>
    function inputNumber(form) {
        var form = document.getElementById(form);
        var number = form.querySelector('#soluong').textContent;
        if (Number(number) == 1) {
            form.querySelector('#soluonghuy').value = 1;
            return true;
        }
        var inputNumber = prompt("Nhập số lượng phòng muốn hủy:");
        if (inputNumber !== null) {
            if (inputNumber <= number) {
                form.querySelector('#soluonghuy').value = inputNumber;
                return true;
            } else {
                alert('Số phòng nhập không quá ' + number + ', vui lòng thử lại.');
                return false;
            }
        }
        return false;
    }
</script>