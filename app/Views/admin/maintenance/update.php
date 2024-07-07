<section class="main-section">
    <div class="form-layout">
        <h3>Cập nhật khuyến mãi</h3>

        <?php foreach ($data['maintenance'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/maintenance/update/<?= $item['idbaotri'] ?>" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">

                <div class="input-box">
                    <label>Tên bảo trì</label>
                    <input type="text" name="name" value="<?= $item['tenbaotri'] ?>" placeholder="Nhập tên bảo trì" required />
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Thời gian bắt đầu</label>
                        <input type="date" name="dateStart" value="<?= $item['thoigianbatdau'] ?>" required />
                    </div>
                    <div class="input-box">
                        <label>Thời gian kết thúc</label>
                        <input type="date" name="dateEnd" value="<?= $item['thoigianketthuc'] ?>" required />
                    </div>
                </div>
                <div class="input-box">
                    <label>Mô tả hoạt động bảo trì</label>
                    <input type="text" name="desc" value="<?= $item['mota'] ?>" placeholder="Nhập mô tả" required />
                </div>
                <button class="btn-save" name="update" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/maintenance' ?>">Hủy</a>
            </form>

        <?php endforeach; ?>

    </div>
</section>