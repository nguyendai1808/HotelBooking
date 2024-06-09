<?php
if (isset($data['account'])) {
    $account = $data['account'];
}

if (!empty($account)) :
    foreach ($account as $item) : ?>

        <div class="change-pass">
            <h2 class="title">Đổi mật khẩu</h2>
            <form action="<?= URLROOT ?>/personalInfo/password" method="post" class="form-layout" id="passwordForm">
                <div class="input-layout">
                    <label>Tài khoản - Email</label>
                    <input type="text" placeholder="Email" name="email" value="<?= $item['email'] ?>" readonly />
                </div>
                <div class="input-layout" id="form-pass">
                    <label>Mật khẩu cũ</label>
                    <input type="password" name="passOld" placeholder="Mật khẩu cũ" required />
                    <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
                </div>
                <div class="input-layout" id="form-pass">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="passNew" placeholder="Mật khẩu mới" required />
                    <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
                </div>
                <div class="input-layout" id="form-pass">
                    <label>Nhập lại mật khẩu mới</label>
                    <input type="password" name="rtpassNew" placeholder="Nhập lại mật khẩu mới" required />
                    <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
                </div>
                <div>
                    <button class="btn-save" name="changPass" type="submit" onclick="return confirmAction(this, 'Bạn có chắc chắn muốn cập nhật mật khẩu mới?')">
                        Cập nhật
                    </button>
                    <a href="<?= URLROOT ?>/personalInfo/password" class="btn-cancel">Hủy</a>
                </div>
            </form>
        </div>

<?php endforeach;
endif; ?>

<script>
    document.getElementById('passwordForm').addEventListener('submit', function(event) {
        const passOld = document.querySelector('input[name="passOld"]').value;
        const passNew = document.querySelector('input[name="passNew"]').value;
        const rtpassNew = document.querySelector('input[name="rtpassNew"]').value;

        if (passOld === passNew) {
            alert('Mật khẩu cũ không được trùng với mật khẩu mới.');
            event.preventDefault();
            return;
        }

        if (passNew !== rtpassNew) {
            alert('Mật khẩu mới và nhập lại mật khẩu mới không khớp.');
            event.preventDefault();
            return;
        }
    });
</script>