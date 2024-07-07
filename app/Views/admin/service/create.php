<section class="main-section">
    <div class="form-layout">
        <h3>Thêm Dịch Vụ</h3>
        <form action="<?= URLROOT ?>/admin/service/create" method="POST" class="form" enctype="multipart/form-data" onsubmit="return confirm('Bạn có chắc chắn muốn thêm');">
            <div class="input-box">
                <label>Tên Dịch Vụ:</label>
                <input type="text" name="name" placeholder="Nhập tên dịch vụ" required />
            </div>
            <div class="input-box">
                <label>Mô Tả:</label>
                <input type="text" name="desc" placeholder="Nhập mô tả" required />
            </div>
            <div class="input-box">
                <label>Ảnh Dịch Vụ:</label>
                <img src="<?= USER_PATH ?>/images/services/notImage.jpg" alt="img">
                <input type="file" name="image" accept="image/*" onchange="previewImage(this)" required />
            </div>
            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/service' ?>">Hủy</a>
        </form>
    </div>
</section>