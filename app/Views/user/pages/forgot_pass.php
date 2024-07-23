<main class="container-fluid">
    <div class="wrapper-layout">
        <h2>Quên mật khẩu</h2>

        <?php if (!empty($data['error'])) : ?>
            <p class="text-center text-danger"><?= $data['error'] ?></p>
        <?php endif ?>

        <?php if (!empty($data['inputOTP'])) : ?>

            <form action="<?= URLROOT ?>/login/inputOTP" method="post" class="form-layout">
                <div class="input-layout">
                    <label class="text-primary"><?= $data['inputOTP'] ?></label>
                    <input type="text" name="otp" placeholder="Nhập mã OTP" />
                    <div class="d-flex flex-column-reverse">
                        <button type="submit" class="btn-layout m-0" name="confirm">Xác nhận</button>
                        <div class="d-flex justify-content-between mt-2 mb-3">
                            <label id="timerLabel" class="text-danger"></label>
                            <button class="btn m-0 p-0 text-danger" type="submit" formaction="<?= URLROOT ?>/login/sendTo" name="sendTo" id="resetButton">gửi lại</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                    <a href="<?= URLROOT ?>/login">Đăng nhập</a>
                </div>
            </form>

        <?php elseif (!empty($data['saveNewPass'])) : ?>

            <form action="<?= URLROOT ?>/login/saveNewPass" method="post" class="form-layout" id="changePasswordForm">
                <div class="input-layout">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= $data['email'] ?? '' ?>" placeholder="Nhập email" readonly />
                </div>
                <div class="input-layout" id="form-pass">
                    <label class="text-success"><?= $data['saveNewPass'] ?></label>
                    <input name="newPass" id="newPass" type="password" placeholder="Mật khẩu mới" required />
                    <img class="eye-toggle" src="<?= USER_PATH ?>/icon/eye-hidden.png" data-visible="false">
                </div>
                <button class="btn-layout" type="submit" name="savePass">Lưu lại</button>
                <div class="d-flex justify-content-between">
                    <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                    <a href="<?= URLROOT ?>/login">Đăng nhập</a>
                </div>
            </form>

        <?php else : ?>

            <form action="<?= URLROOT ?>/login/forgotPass" method="post" class="form-layout">
                <div class="input-layout">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= $data['email'] ?? '' ?>" placeholder="Nhập email" required />
                </div>
                <button type="submit" class="btn-layout" name="forgot">Lấy mật khẩu</button>
                <div class="d-flex justify-content-between">
                    <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                    <a href="<?= URLROOT ?>/login">Đăng nhập</a>
                </div>
            </form>

        <?php endif ?>
    </div>
</main>

<script>
    (function() {
        const initialCountdownTime = <?= intval(empty($data['time']) ? 0 : $data['time']) * 60; ?>;
        let countdownTime;
        const timerLabel = document.getElementById('timerLabel');
        const resetButton = document.getElementById('resetButton');
        let countdownInterval;

        function startCountdown() {
            clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                let minutes = Math.floor(countdownTime / 60);
                let seconds = countdownTime % 60;

                if (timerLabel) {
                    timerLabel.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }

                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                } else {
                    countdownTime--;
                    localStorage.setItem('countdownTime', countdownTime);
                }
            }, 1000);
        }

        function resetCountdown() {
            countdownTime = initialCountdownTime;
            localStorage.setItem('countdownTime', countdownTime);
            startCountdown();
        }

        function initCountdown() {
            if (initialCountdownTime > 0) {
                countdownTime = initialCountdownTime;
            } else {
                countdownTime = parseInt(localStorage.getItem('countdownTime')) || initialCountdownTime;
            }
            startCountdown();
        }

        if (resetButton) {
            resetButton.addEventListener('click', (event) => {
                resetCountdown();
            });
        }

        initCountdown();

        changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(event) {
                var newPassword = document.getElementById('newPass').value;
                if (newPassword.length < 6) {
                    event.preventDefault();
                    alert("Mật khẩu phải có ít nhất 6 ký tự.");
                }
            });
        }
    })();
</script>