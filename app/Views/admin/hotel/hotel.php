<section class="main-section">
    <div class="form-layout">
        <h3>Cập nhật thông tin khách sạn</h3>

        <?php if (!empty($data['hotel'])) :
            foreach ($data['hotel'] as $item) : ?>

                <form action="<?= URLROOT ?>/admin/hotel/update" method="post" class="form" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật thông tin');">
                    <div class="column">
                        <div class="input-box">
                            <label>Tên khách sạn</label>
                            <input type="text" name="name" value="<?= $item['tenkhachsan'] ?>" placeholder="Nhập tên khách sạn" required />
                        </div>
                        <div class="input-box">
                            <label>Email liên hệ</label>
                            <input type="text" name="email" value="<?= $item['email'] ?>" placeholder="Nhập email" required />
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Danh sách ảnh</label>
                        <div class="list-img text-center mt-2">

                            <?php if (!empty($data['listImg'])) :
                                foreach ($data['listImg'] as $row) : ?>

                                    <div class="img-wrapper" data-id="<?= $row['idanhks'] ?>">
                                        <img src="<?= USER_PATH ?>/<?= !empty($row['anh']) ? $row['anh'] : 'images/notImage.jpg' ?>" alt="img" class="img-thumbnail">
                                        <button type="button" class="delete-img">x</button>
                                    </div>

                            <?php endforeach;
                            endif; ?>

                        </div>
                    </div>

                    <div class="input-box">
                        <input type="file" id="imageUpload" name="images[]" accept="image/*" multiple>
                        <div class="text-end">
                            <button type="button" id="uploadButton" class="text-primary btn m-0">Thêm ảnh</button>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>video khách sạn</label>
                        <input type="text" name="video" value="<?= $item['video'] ?>" placeholder="link video" required />
                    </div>

                    <div class="column">
                        <div class="input-box">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" value="<?= $item['diachi'] ?>" placeholder="Nhập địa chỉ khách sạn" required />
                        </div>
                        <div class="input-box">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="<?= $item['sdt'] ?>" placeholder="Số điện thoại khách sạn" required />
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Thông tin</label>
                        <textarea name="info" placeholder="Thông tin khách sạn" rows="3"><?= $item['thongtin'] ?></textarea>
                    </div>
                    <div class="input-box">
                        <label>Mô tả</label>
                        <textarea name="desc" placeholder="Mô tả khách sạn" rows="3"><?= $item['mota'] ?></textarea>
                    </div>

                    <button class="btn-save" name="update" type="submit">Lưu lại</button>
                    <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/hotel' ?>">Hủy</a>
                </form>

        <?php endforeach;
        endif; ?>

    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $('.list-img').on('click', '.delete-img', function(e) {
        var imgWrapper = $(this).closest('.img-wrapper');
        var imgId = imgWrapper.data('id');
        $.ajax({
            url: 'http://localhost/HotelBooking/admin/hotel/deleteImg',
            type: 'POST',
            data: {
                id: imgId
            },
            success: function(response) {
                if (response === 'success') {
                    imgWrapper.remove();
                } else {
                    alert('Xóa ảnh thất bại!');
                }
            }
        });
    });

    $('#uploadButton').click(function(e) {
        var files = $('#imageUpload')[0].files;

        if (files.length > 0) {
            var formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            $.ajax({
                url: 'http://localhost/HotelBooking/admin/hotel/uploadImages',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        response.images.forEach(function(image) {
                            var imgHtml = `
                            <div class="img-wrapper" data-id="${image.id}">
                                <img src="${image.url}" alt="img">
                                <button type="button" class="delete-img">x</button>
                            </div>
                            `;
                            $('.list-img').append(imgHtml);
                        });
                    } else {
                        alert('Tải lên ảnh thất bại!');
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi tải lên ảnh.');
                }
            });
        } else {
            alert('Vui lòng chọn ít nhất một ảnh.');
        }
    });
</script>