<section class="main-section">
    <div class="form-layout">
        <h3>Thêm phòng phòng</h3>
        <form action="<?= URLROOT ?>/admin/room/create" method="post" class="form" enctype="multipart/form-data" id="uploadForm">
            <div class="column">
                <div class="input-box">
                    <label>Tên phòng</label>
                    <input type="text" name="tenphong" placeholder="Nhập tên phòng" required />
                </div>
                <div class="input-box">
                    <label>Số lượng</label>
                    <input type="number" name="soluong" placeholder="Nhập số lượng" required />
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Kích thước</label>
                    <input type="number" name="kichthuoc" placeholder="Nhập kích thước phòng" required />
                </div>
                <div class="input-box">
                    <label>Giá phòng</label>
                    <input type="number" name="giaphong" placeholder="Nhập giá phòng" required />
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Số lượng người lớn</label>
                    <input type="number" name="nguoilon" placeholder="Số lượng" required />
                </div>
                <div class="input-box">
                    <label>Số lượng trẻ nhỏ</label>
                    <input type="number" name="trenho" placeholder="Số lượng" />
                </div>
            </div>

            <div class="input-box">
                <label>Chọn ảnh</label>
                <div class="list-img text-center mt-2" id="imagePreview"></div>
                <input type="file" id="imageUpload" name="images[]" accept="image/*" multiple>
            </div>

            <div class="column">
                <div class="input-box" id="bedSelection">
                    <div class="d-flex justify-content-between">
                        <label>Chọn giường</label>
                        <button type="button" class="text-primary btn m-0 p-0 add-item-button">Thêm giường</button>
                    </div>
                    <div class="select-box">
                        <select class="item-select">

                            <?php foreach ($data['beds'] as $item) : ?>
                                <option data-id="<?= $item['idgiuong'] ?>"><?= $item['tengiuong'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="list-items mt-3 border p-3">
                        <div class="selected-items" id="selectedBedsList">
                            <p class="mb-3" style="color: #707070;">Danh sách giường</p>
                        </div>
                        <input type="hidden" class="selected-items-input" name="giuong">
                    </div>
                </div>

                <div class="input-box" id="paymentTypeSelection">
                    <div class="d-flex justify-content-between">
                        <label>Loại hình thanh toán</label>
                        <button type="button" class="text-primary btn m-0 p-0 add-item-button">Thêm LHTT</button>
                    </div>
                    <div class="select-box">
                        <select class="item-select">

                            <?php foreach ($data['payTypes'] as $item) : ?>
                                <option data-id="<?= $item['idloaihinhtt'] ?>"><?= $item['loaihinhthanhtoan'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="list-items mt-3 border p-3">
                        <div class="selected-items" id="selectedPaymentTypesList">
                            <p class="mb-3" style="color: #707070;">Danh sách LHTT</p>
                        </div>
                        <input type="hidden" class="selected-items-input" name="loaihinhtt">
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

                        <?php foreach ($data['amenitys'] as $item) : ?>
                            <option data-id="<?= $item['idtiennghi'] ?>"><?= $item['tentiennghi'] ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="list-items mt-3 border p-3">
                    <div class="selected-items" id="selectedPaymentTypesList">
                        <p class="mb-3" style="color: #707070;">Danh sách tiện nghi</p>
                    </div>
                    <input type="hidden" class="selected-items-input" name="tiengnhi">
                </div>
            </div>

            <div class="input-box">
                <label>Danh mục phòng</label>
                <div class="select-box">
                    <select name="id_danhmuc">

                        <?php foreach ($data['categorys'] as $item) : ?>
                            <option value="<?= $item['iddanhmuc'] ?>"><?= $item['tendanhmuc'] ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>

            <button class="btn-add" type="submit">Thêm mới</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/room' ?>">Hủy</a>
        </form>

    </div>
</section>


<script>
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


    document.addEventListener("DOMContentLoaded", function() {
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        const uploadForm = document.getElementById('uploadForm');

        imageUpload.addEventListener('change', function() {
            const files = imageUpload.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageUrl = e.target.result;

                        // Tạo một div wrapper để chứa hình ảnh và nút xóa
                        const imgWrapper = document.createElement('div');
                        imgWrapper.classList.add('img-wrapper');
                        imgWrapper.dataset.id = Date.now(); // Tạo ID duy nhất cho mỗi hình ảnh
                        imgWrapper.innerHTML = `
                        <img src="${imageUrl}" class="img-thumbnail">
                        <button type="button" class="delete-img" data-id="${imgWrapper.dataset.id}">X</button>
                    `;
                        imagePreview.appendChild(imgWrapper);

                        // Bắt sự kiện khi người dùng click nút xóa
                        const deleteButton = imgWrapper.querySelector('.delete-img');
                        deleteButton.addEventListener('click', function() {
                            const idToRemove = deleteButton.getAttribute('data-id');
                            const imgToRemove = imagePreview.querySelector(`.img-wrapper[data-id="${idToRemove}"]`);
                            imgToRemove.remove(); // Xóa div wrapper khi người dùng click vào nút xóa

                            // Cập nhật lại danh sách files trong input type="file"
                            const newFiles = Array.from(imageUpload.files).filter((_, index) => index !== i);
                            const dataTransfer = new DataTransfer();
                            newFiles.forEach(file => dataTransfer.items.add(file));
                            imageUpload.files = dataTransfer.files;
                        });
                    };

                    reader.readAsDataURL(file);
                }
            }
        });

        uploadForm.addEventListener('submit', function(event) {
            if (confirm('Bạn có chắc chắn muốn thêm')) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của form

                // Tạo đối tượng FormData từ form
                const formData = new FormData(uploadForm);

                // Thêm các hình ảnh từ imagePreview vào FormData
                const imgWrappers = document.querySelectorAll('.img-wrapper');
                imgWrappers.forEach(wrapper => {
                    const imgElement = wrapper.querySelector('img');
                    const filename = imgElement.src.split('/').pop(); // Lấy tên file từ URL hình ảnh
                    const file = dataURLtoFile(imgElement.src, filename); // Sử dụng tên thực của file
                    formData.append('images[]', file);
                });

                // Cập nhật input type="file" với các file đã chọn
                const files = imageUpload.files;
                Array.from(files).forEach(file => formData.append('images[]', file));

                // Gửi formData bằng hành động submit của form
                uploadForm.submit();
            } else {
                event.preventDefault();
            }
        });


        // Hàm chuyển đổi DataURL thành File object
        function dataURLtoFile(dataURL, filename) {
            const arr = dataURL.split(',');
            const mime = arr[0].match(/:(.*?);/)[1];
            const bstr = atob(arr[1]);
            let n = bstr.length;
            const u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            // Tạo đối tượng File với tên và loại MIME
            return new File([u8arr], filename, {
                type: mime
            });
        }

    });
</script>