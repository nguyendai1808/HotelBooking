<section class="main-section">

    <?php foreach ($data['payType'] as $item) : ?>

        <div class="form-layout">
            <h3>Cập Nhật Tiện Nghi</h3>
            <form action="<?= URLROOT ?>/admin/offers/updatePayType/<?= $item['idloaihinhtt'] ?>" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">
                <div class="input-box">
                    <label for="name">Loại hinh thanh toán:</label>
                    <input type="text" name="namePayType" value="<?= $item['loaihinhthanhtoan'] ?>" placeholder="Nhập tên loại hình thanh toán" required />
                </div>

                <button class="btn-save" name="updatePayType" type="submit" >Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/offers' ?>">Hủy</a>
            </form>
        </div>

    <?php endforeach; ?>

</section>