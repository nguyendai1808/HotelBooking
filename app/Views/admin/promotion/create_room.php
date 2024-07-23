<section class="main-section">
    <div class="form-layout">
        <h3>Thêm phòng khuyến mãi</h3>
        <form action="<?= URLROOT ?>/admin/promotion/createRoom/<?= $data['idkhuyenmai'] ?>" method="post" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn thêm');">
            <div class="input-box">
                <label>Chọn phòng</label>
                <div class="select-box">
                    <input type="hidden" name="idkhuyenmai" value="<?= $data['idkhuyenmai'] ?>">
                    <select name="idphong">

                        <?php foreach ($data['rooms'] as $item) : ?>

                            <option value="<?= $item['idphong'] ?>"><?= $item['tenphong'] ?> - Tổng số phòng: <?= $item['soluong'] ?> - Trạng thái phòng: <?= $item['trangthai'] ?></option>

                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <button class="btn-add" name="createRoom" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/promotion/detail/' . $data['idkhuyenmai'] ?>">Hủy</a>
        </form>
    </div>
</section>