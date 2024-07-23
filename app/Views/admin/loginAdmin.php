<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin</title>

    <link rel="stylesheet" href="<?= USER_PATH ?>/css/style.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <main class="container-fluid">
        <div class="wrapper-layout">
            <h2>Đăng Nhập</h2>
            <form action="<?= URLROOT ?>/admin/loginAdmin" method="post" class="form-layout">

                <?php if (!empty($data['error'])) : ?>
                    <p class="text-center text-danger"><?= $data['error'] ?></p>
                <?php endif ?>

                <div class="input-layout">
                    <label>Tài khoản</label>
                    <input type="text" name="account" placeholder="Nhập tài khoản" required />
                </div>

                <div class="input-layout" id="form-pass">
                    <label>Mật khẩu</label>
                    <input name="password" type="password" placeholder="Mật khẩu" required />
                    <img class="eye-toggle" src="<?= ADMIN_PATH ?>/icon/eye-hidden.png" data-visible="false">
                </div>

                <button type="submit" class="btn-layout" name="loginAdmin">Đăng nhập</button>
                <a class="text-decoration-none" href="<?= URLROOT ?>/home">Quay lại website</a>
            </form>
        </div>
    </main>
    <script>
        document.querySelectorAll('#form-pass .eye-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const visible = this.getAttribute('data-visible') === 'true';

                if (visible) {
                    input.type = 'password';
                    this.src = '<?= ADMIN_PATH ?>/icon/eye-hidden.png';
                    this.setAttribute('data-visible', 'false');
                } else {
                    input.type = 'text';
                    this.src = '<?= ADMIN_PATH ?>/icon/eye.png';
                    this.setAttribute('data-visible', 'true');
                }
            });
        });
    </script>

</body>

</html>