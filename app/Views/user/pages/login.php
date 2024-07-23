<main class="container-fluid">
    <div class="wrapper-layout">
        <h2>Đăng Nhập</h2>
        <form action="<?= URLROOT ?>/login" method="post" class="form-layout">

            <?php if (!empty($data['error'])) : ?>
                <p class="text-center text-danger"><?= $data['error'] ?></p>
            <?php endif ?>

            <div class="input-layout">
                <label>Email</label>
                <input type="text" name="email" value="<?= $data['email'] ?? '' ?>" placeholder="Email" required />
            </div>

            <div class="input-layout" id="form-pass">
                <label>Mật khẩu</label>
                <input name="password" type="password" placeholder="Mật khẩu" required />
                <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
            </div>

            <button type="submit" class="btn-layout" name="login">Đăng nhập</button>
            <div class="d-flex justify-content-between">
                <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                <a href="<?= URLROOT ?>/login/forgotPass">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</main>