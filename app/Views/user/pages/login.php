<main class="container-fluid">
    <div class="wrapper-layout">
        <h2>Đăng Nhập</h2>
        <form action="<?= URLROOT ?>/login" method="post" class="form-layout">

            <?php if (!empty($data['error'])) : ?>
                <p class="text-center text-danger"><?= $data['error'] ?></p>
            <?php endif ?>

            <div class="input-layout">
                <label>Email</label>
                <input type="text" name="email" placeholder="Email" required />
            </div>

            <div class="input-layout" id="form-pass">
                <label>Mật khẩu</label>
                <input id="eye-pass" name="password" type="password" placeholder="Mật khẩu" required />
                <img id="eye-open" src="<?= USER_PATH ?>/icon/eye.png" onclick="hiddenpass()">
                <img id="eye-close" src="<?= USER_PATH ?>/icon/eye-hidden.png" onclick="showpass()">
            </div>

            <button type="submit" class="btn-layout" name="login">Đăng nhập</button>
            <div class="d-flex justify-content-between">
                <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                <a href="forgetpass.php">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</main>