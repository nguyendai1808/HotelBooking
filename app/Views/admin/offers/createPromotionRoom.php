<section class="main-section">
    <div class="form-layout">
        <h3>Thêm phòng khuyến mãi</h3>
        <form action="<?= URLROOT ?>/admin/offers/createPromotionRoom/<?= $data['idkhuyenmai'] ?>" method="post" class="form">
            <div class="input-box">
                <label>Chọn phòng</label>
                <div class="select-box">
                    <input type="hidden" name="idkhuyenmai" value="<?= $data['idkhuyenmai'] ?>">
                    <select name="idphong">

                        <?php foreach ($data['rooms'] as $item) : ?>

                            <option value="<?= $item['idphong'] ?>"><?= $item['tenphong'] ?> - Tổng số phòng: <?= $item['soluong'] ?> - Trạng thái phòng: <?= $item['trangthai'] ?></option>

                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <button class="btn-add" name="createPromotionRoom" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/offers/detailPromotion/' . $data['idkhuyenmai'] ?>">Hủy</a>
        </form>
    </div>
</section>