<section class="main-section">
    <div class="form-layout">
        <h3>Thêm tiện nghi phòng</h3>
        <form action="<?= URLROOT ?>/admin/amenity/create" method="POST" class="form" enctype="multipart/form-data">
            <div class="input-box">
                <label>Tên Tiện Nghi:</label>
                <input type="text" name="name" placeholder="Nhập tên tiện nghi" required />
            </div>
            <div class="input-box">
                <label>Ảnh Tiện Nghi:</label>
                <img src="<?= USER_PATH ?>/images/notImage.jpg" alt="img">
                <input type="file" name="image" accept="image/*" onchange="previewImage(this)" required />
            </div>
            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/amenity' ?>">Hủy</a>
        </form>
    </div>
</section>