<?php
if (isset($data['account'])) {
    $account = $data['account'];
}

if (!empty($account)) :
    foreach ($account as $item) : ?>

        <div class="account-infor">
            <h2 class="title">Thông tin tài khoản</h2>
            <form action="<?= URLROOT ?>/personalInfo/account" method="post" class="form-layout" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-layout col-12">
                        <div class="d-flex justify-content-between">
                            <label>Tài khoản - Email</label>
                            <p class="m-0" style="font-style: italic;">Điểm tích lũy: <span class="text-danger"><?= $item['diemtichluy'] ?? 0 ?></span> điểm</p>
                        </div>
                        <input type="text" name="email" placeholder="Email" value="<?= $item['email'] ?>" readonly />
                    </div>
                    <div class="input-layout col-md-6">
                        <label>Họ</label>
                        <input type="text" name="surname" placeholder="Họ" value="<?= $item['ho'] ?>" required />
                    </div>
                    <div class="input-layout col-md-6">
                        <label>Tên</label>
                        <input type="text" name="name" placeholder="Tên" value="<?= $item['ten'] ?>" required />
                    </div>

                    <div class="input-layout col-12">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" placeholder="Số điện thoại" value="<?= $item['sdt'] ?>" required />
                    </div>

                    <div class="input-layout col-12">
                        <label>Ảnh đại diện</label>
                        <img src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="img">
                        <input type="file" name="image" accept="image/*" onchange="previewImage(this)" />
                    </div>

                    <div class="input-layout col-12">
                        <label>Địa chỉ</label>
                        <textarea class="mt-2" name="address" rows="2" placeholder="Địa chỉ"><?= $item['diachi'] ?></textarea>
                    </div>
                    <div>
                        <button class="btn-save" name="save" type="submit" value="<?= $item['idtaikhoan'] ?>" onclick="return confirmAction(this, 'Bạn có chắc chắn muốn lưu không?')">
                            Lưu lại
                        </button>
                        <a href="<?= URLROOT ?>/personalInfo/account" class="btn-cancel">Hủy</a>
                    </div>
                </div>
            </form>
        </div>

<?php endforeach;
endif; ?>