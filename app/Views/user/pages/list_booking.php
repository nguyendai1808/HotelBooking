<?php
if (isset($data['list_booking'])) {
    $list_booking = $data['list_booking'];
}

if (isset($data['rating'])) {
    $rating = $data['rating'];
};
?>

<h3 class="title mb-3">Danh sách các phòng</h3>
<div class="myinfor-history m-0">
    <div class="col-12 mb-3" id="booking-items">

        <?php if (!empty($list_booking)) :
            $stt = 1;
            foreach ($list_booking as $item) : ?>

                <div class="room-item border mb-3" id="form-<?= $stt ?>">
                    <form class="form-item col-12" action="<?= URLROOT ?>/history/cancelRoom" method="post">
                        <div class="item-img">
                            <a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><img src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>"></a>

                            <?php if (!empty($item['khuyenmai'])) : ?>
                                <small class="item-sale"><i class="fa-solid fa-tags"></i> -<?= $item['khuyenmai'] ?>%</small>
                            <?php endif; ?>

                        </div>
                        <div class="item-detail">
                            <div class="d-flex justify-content-between">
                                <h5><a href="<?= URLROOT ?>/room/detailroom/<?= $item['id_phong'] ?>"><?= $item['tenphong'] ?> - <?= $item['tengiuong'] ?></a></h5>

                                <?php if ($item['trangthaidat'] == 'Hoàn tất' && !empty($item['id_taikhoan']) && strtotime('+4 weeks', strtotime($item['ngaydi'])) > time()) : ?>

                                    <button class="btn border-0 p-0" type="button" onclick="openRating('<?= $item['id_phong'] ?>','<?= $item['id_taikhoan'] ?>','<?= $item['iddatphong'] ?>')">
                                        <img class="item-rating" src="<?= USER_PATH ?>/icon/rating.png" alt="rating">
                                    </button>

                                <?php endif; ?>

                            </div>

                            <div class="item-date">
                                <span id="arrival-date"><?= $item['ngayden'] ? date('d-m-Y', strtotime($item['ngayden'])) : '' ?></span>
                                <i class="bi bi-arrow-right-short"></i>
                                <span id="departure-date"><?= $item['ngaydi'] ? date('d-m-Y', strtotime($item['ngaydi'])) : '' ?></span>
                            </div>

                            <p class="mb-2 fw-bold"><span class="text-success"><?= $item['loaihinhtt'] ?></span></p>

                            <?php
                            $giaphong = $item['giaphong'];
                            if (!empty($item['khuyenmai'])) :
                                $giaphong = $item['giaphong'] - (($item['khuyenmai'] / 100) * $item['giaphong']); ?>

                                <h6 class="item-price"><del><?= number_format($item['giaphong'], 0, ',', '.') ?></del> <?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                            <?php else : ?>

                                <h6 class="item-price"><?= number_format($giaphong, 0, ',', '.') ?>đ</h6>

                            <?php endif; ?>

                            <?php
                            if ($item['trangthaidat'] == 'Đã hủy') :
                                $dathanhtoan = $item['tonggia'] * 0.25;
                            elseif ($item['trangthaidat'] == 'Đã cọc tiền') :
                                $dathanhtoan = $item['tonggia'] * 0.5;
                            else :
                                $dathanhtoan = $item['tonggia'];
                            endif;
                            ?>

                            <p class="mb-2 text-success">Đã thanh toán: <span><?= number_format($dathanhtoan, 0, ',', '.') ?>đ</span></p>

                            <input type="hidden" name="iddatphong" value="<?= $item['iddatphong'] ?>">
                            <input type="hidden" name="trangthaidon" value="<?= $item['trangthaidon'] ?>">
                            <input type="hidden" name="iddondat" value="<?= $item['iddondat'] ?>">
                            <input type="hidden" name="soluonghuy" id="soluonghuy">

                            <div class="d-flex justify-content-between align-items-center">

                                <button class="btn-invoice" type="submit" name="detail" value="<?= $item['iddondat'] ?>" formaction="<?= URLROOT ?>/invoice">ID: <?= $item['iddondat'] ?></button>

                                <?php if (strtotime($item['ngayden']) > strtotime('+1 week') && $item['trangthaidat'] != 'Đã hủy') : ?>

                                    <button class="btn-item-cancel" name="cancel" type="submit" onclick="return confirmAction(this, 'Bạn có chắc chắn muốn hủy không?') && inputNumber('form-<?= $stt ?>')">Hủy</button>

                                <?php endif; ?>

                            </div>
                        </div>
                    </form>

                    <div class="item-total col-12 border-top">
                        <div class="w-25 text-center d-flex flex-column">

                            <?php $color = ($item['trangthaidat'] == 'Đã hủy') ? 'danger' : (($item['trangthaidat'] == 'Đã cọc tiền') ? 'warning' : 'success'); ?>

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

    <?php
    if (!empty($rating)) {
        require_once APPROOT . '/views/user/pages/rating.php';
    }
    ?>

    <!-- Start Pagination -->
    <div class="page-pagination mt-5" id="pagination-links">

        <?php if (isset($data['pagination'])) {
            $pagination = $data['pagination'];
        }

        if (!empty($pagination)) : extract($pagination);

            $start = max($current_page - 1, 1);
            $end = min($start + 2, $total_pages);

            if ($current_page == $total_pages && $start > 1) :
                $start--;
            endif;
        ?>

            <ul>
                <?php if ($current_page > 1) : ?>
                    <li><a href="<?= URLROOT ?>/<?= $view ?>/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                <?php endif; ?>

                <?php for ($i = $start; $i <= $end; $i++) : ?>
                    <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/<?= $view ?>/page/<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li><a href="<?= URLROOT ?>/<?= $view ?>/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                <?php endif; ?>
            </ul>

        <?php endif; ?>

    </div>
    <!-- End Pagination -->


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