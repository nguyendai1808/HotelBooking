<section class="main-section">
    <div class="form-layout">
        <h3>Thêm khuyến mãi</h3>
        <form action="<?= URLROOT ?>/admin/promotion/create" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn thêm');">
            <div class="input-box">
                <label>Phần trăm khuyến mãi</label>
                <input type="number" name="promotion" placeholder="Nhập phần trăm khuyến mãi. VD: 20" required />
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Ngày bắt đầu</label>
                    <input type="date" name="dateStart" id="dateStart" required />
                </div>
                <div class="input-box">
                    <label>Ngày kết thúc</label>
                    <input type="date" name="dateEnd" id="dateEnd" required />
                </div>
            </div>

            <div class="input-box">
                <label>Mô tả</label>
                <textarea name="desc" placeholder="Nhập mô tả" rows="3"></textarea>
            </div>
            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/promotion' ?>">Hủy</a>
        </form>
    </div>
</section>