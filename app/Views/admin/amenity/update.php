<section class="main-section">

    <?php foreach ($data['amenity'] as $item) : ?>

        <div class="form-layout">
            <h3>Cập Nhật Tiện Nghi</h3>
            <form action="<?= URLROOT ?>/admin/amenity/update/<?= $item['idtiennghi'] ?>" method="POST" class="form" enctype="multipart/form-data">
                <div class="input-box">
                    <label for="name">Tên Tiện Nghi:</label>
                    <input type="text" name="name" value="<?= $item['tentiennghi'] ?>" placeholder="Nhập tên tiện nghi" required />
                </div>

                <div class="input-box">
                    <label>Ảnh Tiện Nghi:</label>
                    <img src="<?= USER_PATH ?>/images/amenities/<?= !empty($item['icon']) ? $item['icon'] : 'notImage.jpg' ?>" alt="img">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)" />
                </div>
                <button class="btn-save" name="update" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/amenity' ?>">Hủy</a>
            </form>
        </div>

    <?php endforeach; ?>

</section>