<section class="main-section">
    <div class="form-layout">
        <h3>Phản hồi người dùng</h3>

        <?php foreach ($data['contact'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/contact/feedback/<?= $item['idlienhe'] ?>" method="POST" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn gửi');">

                <div class="column">
                    <div class="input-box">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $item['email'] ?>" readonly />
                    </div>
                    <div class="input-box">
                        <label>Trạng thái</label>
                        <input type="text" name="status" value="<?= $item['trangthai'] ?>" readonly />
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Họ tên</label>
                        <input type="text" name="fullname" value="<?= $item['hoten'] ?>" readonly />
                    </div>
                    <div class="input-box">
                        <label>Chủ đề</label>
                        <input type="text" name="subject" value="<?= $item['chude'] ?>" readonly />
                    </div>
                </div>
                <div class="input-box">
                    <label>Nội dung liên hệ</label>
                    <textarea name="message" rows="3" readonly><?= $item['noidung'] ?></textarea>
                </div>

                <div class="input-box">
                    <label>Phản hồi người dùng</label>
                    <textarea name="content" rows="3" placeholder="Nhập nội dung phản hồi" required></textarea>
                </div>

                <button class="btn-save" name="feedback" type="submit">Phản hồi</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/contact' ?>">Hủy</a>
            </form>

        <?php endforeach; ?>

    </div>
</section>