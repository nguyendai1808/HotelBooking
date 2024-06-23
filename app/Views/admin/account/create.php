<section class="main-section">
    <div class="form-layout">
        <h3>Thêm mới tài khoản</h3>

        <form action="<?= URLROOT ?>/admin/account/create" method="POST" class="form">
            <div class="column">
                <div class="input-box">
                    <label>Họ</label>
                    <input type="text" placeholder="Nhập họ" name="surname" required />
                </div>
                <div class="input-box">
                    <label>Tên</label>
                    <input type="text" placeholder="Nhập tên" name="name" required />
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Nhập email" required />
                </div>
                <div class="input-box">
                    <label>Số điện thoại</label>
                    <input type="number" name="phone" placeholder="Nhập Số điện thoại" required />
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Mật khẩu</label>
                    <input type="password" name="pass" placeholder="Nhập mật khẩu" required />
                </div>
                <div class="input-box">
                    <label>Loại tài khoản</label>
                    <div class="select-box">
                        <select name="loaitk">
                            <option value="admin">Admin</option>
                            <option value="user">Người dùng</option>
                        </select>
                    </div>
                </div>
            </div>

            <button class="btn-add" name="create" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/account' ?>">Hủy</a>
        </form>
    </div>
</section>