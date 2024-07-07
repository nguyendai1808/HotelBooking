<section class="main-section">

    <?php foreach ($data['service'] as $item) : ?>

        <div class="form-layout">
            <h3>Cập Nhật Dịch Vụ</h3>
            <form action="<?= URLROOT ?>/admin/service/update/<?= $item['iddichvu'] ?>" method="POST" class="form" enctype="multipart/form-data" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">
                <div class="input-box">
                    <label for="name">Tên Danh Mục:</label>
                    <input type="text" name="name" value="<?= $item['tendichvu'] ?>" placeholder="Nhập tên danh mục" required />
                </div>
                <div class="input-box">
                    <label>Mô Tả:</label>
                    <input type="text" name="desc" value="<?= $item['mota'] ?>" placeholder="Nhập mô tả" required />
                </div>

                <div class="input-box">
                    <label>Ảnh Dịch Vụ:</label>
                    <img src="<?= USER_PATH ?>/images/services/<?= !empty($item['icon']) ? $item['icon'] : 'notImage.jpg' ?>" alt="img">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)" />
                </div>
                <button class="btn-save" name="update" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/service' ?>">Hủy</a>
            </form>
        </div>

    <?php endforeach; ?>

</section>