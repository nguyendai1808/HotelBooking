<section class="main-section">
    <div class="form-layout">
        <h3>cập nhật phòng bảo trì</h3>

        <?php foreach ($data['room'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/maintenance/updateRoom/<?= $item['idphong'] . '/' . $data['idbaotri'] ?>" method="post" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">
                <div class="input-box">
                    <label>Thông tin phòng</label>
                    <input type="hidden" name="idbaotri" value="<?= $data['idbaotri'] ?>">
                    <input type="hidden" name="idphong" value="<?= $item['idphong'] ?>">
                    <input type="text" value="<?= $item['tenphong'] ?> - Tổng số phòng: <?= $item['soluong'] ?> - Trạng thái phòng: <?= $item['trangthai'] ?>" readonly />
                </div>

                <div class="input-box">
                    <label>Số lượng</label>
                    <input type="number" name="soluong" value="<?= $item['soluongbaotri'] ?>" placeholder="Nhập số lượng" max="<?= $item['soluong'] ?>" required />
                </div>

                <button class="btn-add" name="updateRoom" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/maintenance/detail/' . $data['idbaotri'] ?>">Hủy</a>
            </form>
        <?php endforeach; ?>
    </div>
</section>