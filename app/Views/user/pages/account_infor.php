<?php 
if(isset($data['account'])){
    $account = $data['account'];
}

if(!empty($account)) :
    foreach ($account as $item) : ?>

        <div class="account-infor">
            <h2 class="title">Thông tin tài khoản</h2>
            <form action="#" class="form-layout">
                <div class="row">
                    <div class="input-layout col-12">
                        <label>Tài khoản - Email</label>
                        <input type="text" placeholder="Email" value="<?= $item['email'] ?>" required />
                    </div>
                    <div class="input-layout col-md-6">
                        <label>Họ</label>
                        <input type="text" placeholder="Họ" value="<?= $item['ho'] ?>" required />
                    </div>
                    <div class="input-layout col-md-6">
                        <label>Tên</label>
                        <input type="text" placeholder="Tên" value="<?= $item['ten'] ?>" required />
                    </div>
                    <div class="input-layout col-12">
                        <label>Số điện thoại</label>
                        <input type="text" placeholder="Số điện thoại" value="<?= $item['sdt'] ?>" />
                    </div>
                    <div>
                        <button class="btn-save" type="submit">Lưu lại</button>
                        <button class="btn-cancel">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

<?php endforeach;
endif; ?>
