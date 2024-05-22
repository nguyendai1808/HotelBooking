<?php
if (isset($data['account'])) {
    $account = $data['account'];
}

if (!empty($account)) :
    foreach ($account as $item) : ?>

        <div class="change-pass">
            <h2 class="title">Đổi mật khẩu</h2>
            <form action="#" class="form-layout">
                <div class="input-layout">
                    <label>Tài khoản - Email</label>
                    <input type="text" placeholder="Email" value="" required disabled />
                </div>
                <div class="input-layout">
                    <label>Mật khẩu cũ</label>
                    <input type="password" placeholder="Mật khẩu cũ" required />
                </div>
                <div class="input-layout">
                    <label>Mật khẩu mới</label>
                    <input type="password" placeholder="Mật khẩu mới" required />
                </div>
                <div class="input-layout">
                    <label>Nhập lại mật khẩu mới</label>
                    <input type="password" placeholder="Nhập lại mật khẩu mới" required />
                </div>
                <div>
                    <button class="btn-save" type="submit">Cập nhật</button>
                    <button class="btn-cancel">Hủy</button>
                </div>
            </form>
        </div>
        
<?php endforeach;
endif; ?>