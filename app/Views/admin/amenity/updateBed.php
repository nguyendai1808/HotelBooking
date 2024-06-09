<section class="main-section">

    <?php foreach ($data['bed'] as $item) : ?>

        <div class="form-layout">
            <h3>Cập Nhật Tiện Nghi</h3>
            <form action="<?= URLROOT ?>/admin/amenity/updateBed/<?= $item['idgiuong'] ?>" method="POST" class="form" >
                <div class="input-box">
                    <label for="name">Tên Giường:</label>
                    <input type="text" name="nameBed" value="<?= $item['tengiuong'] ?>" placeholder="Nhập tên giường" required />
                </div>

                <button class="btn-save" name="updateBed" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/amenity' ?>">Hủy</a>
            </form>
        </div>

    <?php endforeach; ?>

</section>