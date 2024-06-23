<section class="main-section">
    <div class="form-layout">
        <h3>Thêm Danh Mục Phòng</h3>
        <form action="<?= URLROOT ?>/admin/category/create" method="POST" class="form">
            <div class="input-box">
                <label>Tên Danh Mục:</label>
                <input type="text" name="name" placeholder="Nhập tên danh mục" required />
            </div>
            <div class="input-box">
                <label>Mô tả</label>
                <textarea name="desc" placeholder="Nhập mô tả" rows="3"></textarea>
            </div>
            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/category' ?>">Hủy</a>
        </form>
    </div>
</section>