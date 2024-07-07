<section class="main-section">
    <div class="form-layout">
        <h3>Thêm phòng bảo trì</h3>
        <form action="<?= URLROOT ?>/admin/maintenance/createRoom/<?= $data['idbaotri'] ?>" method="post" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn thêm');">
            <div class="input-box">
                <label>Chọn phòng</label>
                <div class="select-box">
                    <input type="hidden" name="idbaotri" value="<?= $data['idbaotri'] ?>">
                    <select name="idphong" id="roomSelect">

                        <?php foreach ($data['rooms'] as $item) : ?>

                            <option value="<?= $item['idphong'] ?>" data-soluong="<?= $item['soluong'] ?>">
                                <?= $item['tenphong'] ?> - Tổng số phòng: <?= $item['soluong'] ?> - Trạng thái phòng: <?= $item['trangthai'] ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <div class="input-box">
                <label>Số lượng</label>
                <input type="number" name="soluong" id="quantityInput" placeholder="Nhập số lượng" min="1" required />
            </div>
            <button class="btn-add" name="createRoom" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/maintenance/detail/' . $data['idbaotri'] ?>">Hủy</a>
        </form>
    </div>
</section>