<section class="main-section">

    <?php foreach ($data['findCate'] as $item) : ?>

        <div class="form-layout">
            <h3>Cập Nhật Danh Mục Phòng</h3>
            <form action="<?= URLROOT ?>/admin/category/update/<?= $item['iddanhmuc'] ?>" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">
                <div class="input-box">
                    <label for="name">Tên Danh Mục:</label>
                    <input type="text" name="name" value="<?= $item['tendanhmuc'] ?>" placeholder="Nhập tên danh mục" required />
                </div>
                <div class="input-box">
                    <label for="name">Mô tả:</label>
                    <textarea name="desc" placeholder="Mô tả" rows="3"><?= $item['mota'] ?></textarea>
                </div>
                <button class="btn-save" name="update" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/category' ?>">Hủy</a>
            </form>
        </div>

    <?php endforeach; ?>

</section>