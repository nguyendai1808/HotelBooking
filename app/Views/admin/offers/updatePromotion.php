<section class="main-section">
    <div class="form-layout">
        <h3>Cập nhật khuyến mãi</h3>

        <?php foreach ($data['promotion'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/offers/updatePromotion/<?= $item['idkhuyenmai'] ?>" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">
                <div class="input-box">
                    <label>Phần trăm khuyến mãi</label>
                    <input type="number" name="promotion" value="<?= $item['khuyenmai'] ?>" placeholder="Nhập phần trăm khuyến mãi. VD: 20" required />
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Ngày bắt đầu</label>
                        <input type="date" name="dateStart" value="<?= $item['ngaybatdau'] ?>" id="dateStart"  required />
                    </div>
                    <div class="input-box">
                        <label>Ngày kết thúc</label>
                        <input type="date" name="dateEnd" value="<?= $item['ngayketthuc'] ?>" id="dateEnd" required />
                    </div>
                </div>

                <div class="input-box">
                    <label>Mô tả</label>
                    <textarea name="desc" placeholder="Nhập mô tả" rows="3"><?= $item['mota'] ?></textarea>
                </div>
                <button class="btn-save" name="updatePromotion" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/offers' ?>">Hủy</a>
            </form>

        <?php endforeach; ?>

    </div>
</section>