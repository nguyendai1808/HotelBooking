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
                    <div class="d-flex justify-content-between mt-2">
                        <label id="timerLabel" class="text-danger"></label>
                        <button class="btn m-0 p-0 text-danger" type="submit" name="sendTo" id="resetButton">gửi lại</button>
                    </div>
                </div>
                <button type="submit" class="btn-layout" name="confrim">Xác nhận</button>
                <div class="d-flex justify-content-between">
                    <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                    <a href="<?= URLROOT ?>/login">Đăng nhập</a>
                </div>
            </form>

        <?php elseif (!empty($data['saveNewPass'])) : ?>

            <form action="<?= URLROOT ?>/login/saveNewPass" method="post" class="form-layout">
                <div class="input-layout">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= $data['email'] ?? '' ?>" placeholder="Nhập email" readonly />
                </div>
                <div class="input-layout">
                    <label class="text-success"><?= $data['saveNewPass'] ?></label>
                    <input name="newPass" type="password" placeholder="Mật khẩu mới" required />
                </div>
                <button class="btn-layout" type="submit" name="savePass">Lưu lại</button>
                <div class="d-flex justify-content-between">
                    <a href="<?= URLROOT ?>/register">Tạo tài khoản</a>
                    <a href="<?= URLROOT ?>/login">Đăng nhập</a>
                </div>
            </form>

        <?php else : ?>

            <form action="<?= URLROOT ?>/login/forgotpass" method="post" class="form-layout">
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
    let initialCountdownTime = <?php echo intval(empty($data['time']) ? 0 : $data['time']) * 60; ?>;
    let countdownTime;
    let timerLabel = document.getElementById('timerLabel');
    let resetButton = document.getElementById('resetButton');
    let countdownInterval;

    function startCountdown() {
        clearInterval(countdownInterval); // Xóa bất kỳ interval nào đang chạy
        countdownInterval = setInterval(() => {
            let minutes = Math.floor(countdownTime / 60);
            let seconds = countdownTime % 60;

            // Định dạng thời gian MM:SS
            timerLabel.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (countdownTime <= 0) {
                clearInterval(countdownInterval);
            } else {
                countdownTime--;
                localStorage.setItem('countdownTime', countdownTime); // Lưu thời gian còn lại vào localStorage
            }
        }, 1000);
    }

    function resetCountdown() {
        countdownTime = initialCountdownTime; // Đặt lại về thời gian ban đầu
        localStorage.setItem('countdownTime', countdownTime); // Lưu thời gian mới vào localStorage
        startCountdown();
    }

    // Lấy thời gian còn lại từ localStorage nếu có, ngược lại sử dụng thời gian ban đầu từ PHP
    countdownTime = parseInt(localStorage.getItem('countdownTime')) || initialCountdownTime;

    resetButton.addEventListener('click', resetCountdown);

    // Bắt đầu đếm ngược khi trang được tải
    startCountdown();
</script>