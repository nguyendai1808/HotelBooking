<section class="main-section">
    <div class="form-layout">
        <h3>Cập nhật phòng</h3>

        <?php foreach ($data['room'] as $item) : ?>

            <form action="<?= URLROOT ?>/admin/room/update/<?= $item['idphong'] ?>" method="post" class="form" enctype="multipart/form-data" id="uploadForm" onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật');">

                <div class="column">
                    <div class="input-box">
                        <label>Tên phòng</label>
                        <input type="text" name="tenphong" value="<?= $item['tenphong'] ?>" placeholder="Nhập tên phòng" required />
                    </div>
                    <div class="input-box">
                        <label>Số lượng</label>
                        <input type="number" name="soluong" value="<?= $item['soluong'] ?>" placeholder="Nhập số lượng" required />
                    </div>
                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Kích thước</label>
                        <input type="number" name="kichthuoc" value="<?= $item['kichthuoc'] ?>" placeholder="Nhập kích thước phòng" required />
                    </div>
                    <div class="input-box">
                        <label>Giá phòng</label>
                        <input type="number" name="giaphong" value="<?= $item['giaphong'] ?>" placeholder="Nhập giá phòng" required />
                    </div>
                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Số lượng người lớn</label>
                        <input type="number" name="nguoilon" value="<?= $item['nguoilon'] ?>" placeholder="Số lượng" required />
                    </div>
                    <div class="input-box">
                        <label>Số lượng trẻ nhỏ</label>
                        <input type="number" name="trenho" value="<?= $item['trenho'] ?>" placeholder="Số lượng" />
                    </div>
                </div>

                <div class="input-box">
                    <label>Danh sách ảnh</label>
                    <div class="list-img text-center mt-2">

                        <?php if (!empty($item['anhphong'])) :

                            foreach ($item['anhphong'] as $row) : ?>

                                <div class="img-wrapper" data-id="<?= $row['idanhphong'] ?>">
                                    <img src="<?= USER_PATH ?>/<?= !empty($row['anh']) ? $row['anh'] : 'images/notImage.jpg' ?>" alt="img" class="img-thumbnail">
                                    <button type="button" class="delete-img">x</button>
                                </div>

                        <?php endforeach;
                        endif; ?>

                    </div>
                </div>
                <div class="input-box">
                    <input type="hidden" id="idphong" value="<?= $item['idphong'] ?>">
                    <input type="file" id="imageUpload" name="images[]" accept="image/*" multiple>
                    <div class="text-end">
                        <button type="button" id="uploadButton" class="text-primary btn m-0">Thêm ảnh</button>
                    </div>
                </div>

                <div class="column">
                    <div class="input-box" id="bedSelection">
                        <div class="d-flex justify-content-between">
                            <label>Chọn giường</label>
                            <button type="button" class="text-primary btn m-0 p-0 add-item-button">Thêm giường</button>
                        </div>
                        <div class="select-box">
                            <select class="item-select">

                                <?php foreach ($data['beds'] as $row) : ?>
                                    <option data-id="<?= $row['idgiuong'] ?>"><?= $row['tengiuong'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="list-items mt-3 border p-3">
                            <div class="selected-items" id="selectedBedsList">
                                <p class="mb-3" style="color: #707070;">Danh sách giường</p>
                                <?php $beds = null;
                                if (!empty($item['giuong'])) :
                                    foreach ($item['giuong'] as $row) :
                                        $beds[] = $row['idgiuong'] . ':' . $row['soluong']; ?>

                                        <div class="selected-item d-flex justify-content-between mb-2" data-id="<?= $row['idgiuong'] ?>">
                                            <span><?= $row['tengiuong'] ?></span>
                                            <div>
                                                <input type="number" min="1" value="1" style="width: 50px; margin: 0 15px 0 0; height: auto; width: 50px; padding: 0; padding-left: 10px;">
                                                <button style="background: none;" class="remove-item-button m-0 p-0 text-danger">Xóa</button>
                                            </div>
                                        </div>

                                <?php endforeach;
                                endif; ?>
                            </div>
                            <input type="hidden" class="selected-items-input" name="giuong" value="<?= !empty($beds) ? implode(',', $beds) : 0 ?>">
                        </div>
                    </div>

                    <div class="input-box" id="paymentTypeSelection">
                        <div class="d-flex justify-content-between">
                            <label>Loại hình thanh toán</label>
                            <button type="button" class="text-primary btn m-0 p-0 add-item-button">Thêm LHTT</button>
                        </div>
                        <div class="select-box">
                            <select class="item-select">

                                <?php foreach ($data['payTypes'] as $row) : ?>
                                    <option data-id="<?= $row['idloaihinhtt'] ?>"><?= $row['loaihinhthanhtoan'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="list-items mt-3 border p-3">
                            <div class="selected-items" id="selectedPaymentTypesList">
                                <p class="mb-3" style="color: #707070;">Danh sách LHTT</p>
                                <?php $payType = null;
                                if (!empty($item['loaihinhtt'])) :
                                    foreach ($item['loaihinhtt'] as $row) :
                                        $payType[] = $row['idloaihinhtt'] ?>

                                        <div class="selected-item d-flex justify-content-between mb-2" data-id="<?= $row['idloaihinhtt'] ?>">
                                            <span><?= $row['loaihinhthanhtoan'] ?></span>
                                            <button style="background: none;" class="remove-item-button m-0 p-0 text-danger">Xóa</button>
                                        </div>

                                <?php endforeach;
                                endif; ?>
                            </div>
                            <input type="hidden" class="selected-items-input" name="loaihinhtt" value="<?= !empty($payType) ? implode(',', $payType) : 0 ?>">
                        </div>
                    </div>
                </div>

                <div class="input-box" id="paymentTypeSelection">
                    <div class="d-flex justify-content-between">
                        <label>Tiện nghi</label>
                        <button type="button" class="text-primary btn m-0 p-0 add-item-button">Thêm tiện nghi</button>
                    </div>
                    <div class="select-box">
                        <select class="item-select">

                            <?php foreach ($data['amenitys'] as $row) : ?>
                                <option data-id="<?= $row['idtiennghi'] ?>"><?= $row['tentiennghi'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="list-items mt-3 border p-3">
                        <div class="selected-items" id="selectedPaymentTypesList">
                            <p class="mb-3" style="color: #707070;">Danh sách tiện nghi</p>
                            <?php $amenity = null;
                            if (!empty($item['tiennghi'])) :
                                foreach ($item['tiennghi'] as $row) :
                                    $amenity[] = $row['idtiennghi']; ?>

                                    <div class="selected-item d-flex justify-content-between mb-2" data-id="<?= $row['idtiennghi'] ?>">
                                        <span><?= $row['tentiennghi'] ?></span>
                                        <button style="background: none;" class="remove-item-button m-0 p-0 text-danger">Xóa</button>
                                    </div>

                            <?php endforeach;
                            endif; ?>
                        </div>
                        <input type="hidden" class="selected-items-input" name="tiengnhi" value="<?= !empty($amenity) ? implode(',', $amenity) : 0 ?>">
                    </div>
                </div>

                <div class="input-box">
                    <label>Danh mục phòng</label>
                    <div class="select-box">
                        <select name="id_danhmuc">

                            <?php foreach ($data['categorys'] as $row) : ?>
                                <option value="<?= $row['iddanhmuc'] ?>" <?= ($row['iddanhmuc'] == $item['id_danhmuc']) ? 'selected' : '' ?>>
                                    <?= $row['tendanhmuc'] ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <button class="btn-save" name="update" type="submit">Lưu lại</button>
                <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/room' ?>">Hủy</a>
            </form>

        <?php endforeach; ?>

    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $('.list-img').on('click', '.delete-img', function(e) {
        var imgWrapper = $(this).closest('.img-wrapper');
        var imgId = imgWrapper.data('id');
        $.ajax({
            url: 'http://localhost/HotelBooking/admin/room/deleteImg',
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
        e.preventDefault(); // Ngăn chặn hành động mặc định của button nếu có

        var idphong = $('#idphong').val();
        var files = $('#imageUpload')[0].files;

        if (files.length > 0) {
            var formData = new FormData();
            formData.append('idphong', idphong); // Đính kèm idphong

            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            $.ajax({
                url: 'http://localhost/HotelBooking/admin/room/uploadImages',
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


    document.addEventListener("DOMContentLoaded", function() {
        const addButtons = document.querySelectorAll('.add-item-button');

        addButtons.forEach(button => {
            button.addEventListener('click', function() {
                const parentBox = button.closest('.input-box');
                const itemSelect = parentBox.querySelector('.item-select');
                const selectedItemList = parentBox.querySelector('.selected-items');
                const selectedItemsInput = parentBox.querySelector('.selected-items-input');

                const selectedIndex = itemSelect.selectedIndex;

                if (selectedIndex < 0) {
                    alert('Vui lòng chọn một mục.');
                    return;
                }

                const selectedOption = itemSelect.options[selectedIndex];
                const itemId = selectedOption.getAttribute('data-id');
                const itemName = selectedOption.textContent;

                // Check if item is already selected
                if (!selectedItemList.querySelector(`[data-id="${itemId}"]`)) {
                    const selectedItem = document.createElement('div');
                    selectedItem.classList.add('selected-item', 'd-flex', 'justify-content-between', 'mb-2');
                    selectedItem.dataset.id = itemId;

                    // Add input field only for bedSelection
                    if (parentBox.id === 'bedSelection') {
                        selectedItem.innerHTML = `
                        <span>${itemName}</span>
                        <div>
                            <input type="number" min="1" value="1" style="width: 50px; margin: 0 15px 0 0; height: auto; width: 50px; padding: 0; padding-left: 10px;">
                            <button style="background: none;" class="remove-item-button m-0 p-0 text-danger">Xóa</button>
                        </div>
                    `;
                    } else {
                        selectedItem.innerHTML = `
                        <span>${itemName}</span>
                        <button style="background: none;" class="remove-item-button m-0 p-0 text-danger">Xóa</button>
                    `;
                    }

                    selectedItemList.appendChild(selectedItem);

                    // Update hidden input value
                    updateHiddenInput(selectedItemList, selectedItemsInput);
                } else {
                    alert('Mục đã được chọn.');
                }

            });
        });

        // Handle remove item button click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item-button')) {
                const selectedItem = event.target.closest('.selected-item');
                const parentList = selectedItem.parentNode;
                selectedItem.remove();

                // Update hidden input value after removal
                updateHiddenInput(parentList, parentList.nextElementSibling);
            }
        });

        // Function to update hidden input value
        function updateHiddenInput(selectedItemList, selectedItemsInput) {
            const hiddenInputValues = Array.from(selectedItemList.querySelectorAll('.selected-item'))
                .map(item => {
                    const itemId = item.dataset.id;
                    if (selectedItemList.closest('.input-box').id === 'bedSelection') {
                        const quantity = item.querySelector('input[type="number"]').value;
                        return `${itemId}:${quantity}`;
                    }
                    return itemId;
                })
                .join(',');
            selectedItemsInput.value = hiddenInputValues;
        }

        // Handle quantity change
        document.addEventListener('input', function(event) {
            if (event.target.type === 'number' && event.target.closest('.input-box').id === 'bedSelection') {
                const selectedItemList = event.target.closest('.selected-items');
                const selectedItemsInput = selectedItemList.nextElementSibling;
                updateHiddenInput(selectedItemList, selectedItemsInput);
            }
        });
    });
</script>