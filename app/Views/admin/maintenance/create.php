<section class="main-section">
    <div class="form-layout">
        <h3>Thêm lịch bảo trì</h3>
        <form action="<?= URLROOT ?>/admin/maintenance/create" method="POST" class="form">
            <div class="input-box">
                <label>Tên bảo trì</label>
                <input type="text" name="name" placeholder="Nhập tên bảo trì" required />
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Thời gian bắt đầu</label>
                    <input type="date" name="dateStart" required />
                </div>
                <div class="input-box">
                    <label>Thời gian kết thúc</label>
                    <input type="date" name="dateEnd" required />
                </div>
            </div>
            <div class="input-box">
                <label>Mô tả hoạt động bảo trì</label>
                <input type="text" name="desc" placeholder="Nhập mô tả" required />
            </div>
            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/maintenance' ?>">Hủy</a>
        </form>
    </div>
</section>