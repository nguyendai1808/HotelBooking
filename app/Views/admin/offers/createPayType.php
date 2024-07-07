<section class="main-section">
    <div class="form-layout">
        <h3>Thêm loại hình thanh toán</h3>
        <form action="<?= URLROOT ?>/admin/offers/createPayType" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn thêm');">
            <div class="input-box">
                <label>Loại hình thanh toán:</label>
                <input type="text" name="namePayType" placeholder="Nhập tên loại hình thanh toán" required />
            </div>
            <button class="btn-add" name="createPayType" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/offers' ?>">Hủy</a>
        </form>
    </div>
</section>