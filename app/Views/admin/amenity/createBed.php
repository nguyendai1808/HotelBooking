<section class="main-section">
    <div class="form-layout">
        <h3>Thêm giường</h3>
        <form action="<?= URLROOT ?>/admin/amenity/createBed" method="POST" class="form">
            <div class="input-box">
                <label>Tên Tiện Nghi:</label>
                <input type="text" name="nameBed" placeholder="Nhập tên giường" required />
            </div>
            <button class="btn-add" name="createBed" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/amenity' ?>">Hủy</a>
        </form>
    </div>
</section>