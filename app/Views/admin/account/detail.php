<section class="main-section">
    <div class="form-layout">
        <h3>Chi tiết tài khoản</h3>

        <?php foreach ($data['account'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/account" method="POST" class="form">

                <div class="column">
                    <div class="input-box">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="avatar" src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="avatar">
                            <p class="m-0 ps-3">Điểm tích lũy: <span class="text-danger"><?= !empty($item['diemtichluy']) ? $item['diemtichluy']  : 0 ?>đ</span></p>
                        </div>
                    </div>
                    <div class="input-box">
                        <label>Họ tên</label>
                        <input type="text" placeholder="Nhập họ tên" value="<?= trim($item['ho'] . ' ' . $item['ten']) ?>" name="fullname" readonly />
                    </div>

                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Email</label>
                        <input type="text" name="email" value="<?= $item['email'] ?>" placeholder="Nhập email" readonly />
                    </div>
                    <div class="input-box">
                        <label>Số điện thoại</label>
                        <input type="number" name="phone" value="<?= $item['sdt'] ?>" placeholder="Nhập Số điện thoại" readonly />
                    </div>
                </div>

                <div class="input-box">
                    <label>Địa chỉ</label>
                    <textarea name="address" placeholder="Địa chỉ" rows="2" readonly><?= $item['diachi'] ?></textarea>
                </div>
                <!-- <button class="btn-add" name="create" type="submit">Lấy </button> -->
            </form>

        <?php endforeach; ?>

    </div>
</section>