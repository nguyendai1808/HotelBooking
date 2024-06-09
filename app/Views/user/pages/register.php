<main class="container-fluid">
    <div class="wrapper-layout">
        <h2>Đăng ký</h2>
        <form class="form-layout" action="<?= URLROOT ?>/register" method="post">

            <?php if (!empty($data['error'])) : ?>
                <p class="text-center text-danger"><?= $data['error'] ?></p>
            <?php endif ?>

            <div class="input-layout">
                <div class="row">
                    <div class="col-6">
                        <label>Họ</label>
                        <input type="text" name="surname" placeholder="Họ" required />
                    </div>
                    <div class="col-6">
                        <label>Tên</label>
                        <input type="text" name="name" placeholder="Tên" required />
                    </div>
                </div>
            </div>

            <div class="input-layout">
                <label>Email</label>
                <input type="text" name="email" placeholder="Email" required />
            </div>

            <div class="input-layout" id="form-pass">
                <label>Mật khẩu</label>
                <input id="pass" name="pass" type="password" placeholder="Mật khẩu" required />
                <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
            </div>

            <div class="input-layout" id="form-pass">
                <label>Nhập lại mật khẩu</label>
                <input type="password" id="rtpass" name="rtpass" placeholder="Nhập lại mật khẩu" required />
                <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
            </div>
            <button class="btn-layout" id="register" type="submit" name="register">Đăng ký</button>
            <a href="<?= URLROOT ?>/login">Bạn đã có tài khoản? - Đăng Nhập</a>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let pass = document.getElementById('pass');
        let rtpass = document.getElementById('rtpass');
        let register = document.getElementById('register');
        register.onclick = function() {
            if (pass.value !== rtpass.value) {
                alert("Mật khẩu nhập lại không khớp với mật khẩu đã nhập. Vui lòng nhập lại.");
                return false;
            }
            return true;
        };
    });
</script>