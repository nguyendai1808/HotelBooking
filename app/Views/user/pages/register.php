<main class="container-fluid">
    <div class="wrapper-layout">
        <h2>Đăng ký</h2>
        <form class="form-layout" action="<?= URLROOT ?>/register" method="post" id="registerForm">

            <?php if (!empty($data['error'])) : ?>
                <p class="text-center text-danger"><?= $data['error'] ?></p>
            <?php endif ?>

            <div class="input-layout">
                <div class="row">
                    <div class="col-6">
                        <label>Họ</label>
                        <input type="text" name="surname" id="surname" placeholder="Họ" required />
                    </div>
                    <div class="col-6">
                        <label>Tên</label>
                        <input type="text" name="name" id="name" placeholder="Tên" required />
                    </div>
                </div>
            </div>

            <div class="input-layout">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required />
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
        let form = document.getElementById('registerForm');
        let pass = document.getElementById('pass');
        let rtpass = document.getElementById('rtpass');
        let email = document.getElementById('email');

        form.onsubmit = function(event) {

            // Kiểm tra định dạng email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                alert("Định dạng email không hợp lệ. Vui lòng nhập lại.\nVí dụ: email hợp lệ là 'example@domain.com'.");
                event.preventDefault();
                return false;
            }

            // Kiểm tra độ dài mật khẩu
            if (pass.value.length < 6) {
                alert("Mật khẩu phải có ít nhất 6 ký tự.");
                event.preventDefault();
                return false;
            }

            // Kiểm tra mật khẩu
            if (pass.value !== rtpass.value) {
                alert("Mật khẩu nhập lại không khớp với mật khẩu đã nhập. Vui lòng nhập lại.");
                event.preventDefault();
                return false;
            }

            return true;
        };
    });
</script>