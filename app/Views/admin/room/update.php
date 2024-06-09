<section class="main-section">
    <div class="form-layout">
        <h3>Cập nhật phòng</h3>
        <form action="#" class="form">
            <div class="column">
                <div class="input-box">
                    <label>Tên phòng</label>
                    <input type="text" placeholder="Nhập tên phòng" required />
                </div>
                <div class="input-box">
                    <div class="d-flex justify-content-between">
                        <label>Danh mục phòng</label>
                        <a href="#" class="text-primary m-0 p-0">Thêm mới</a>
                    </div>
                    <div class="select-box">
                        <select>
                            <option hidden>Phòng ...</option>
                            <option>Phòng ...</option>
                            <option>Phòng ...</option>
                            <option>Phòng ...</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Kích thước</label>
                    <input type="number" placeholder="Nhập kích thước phòng" required />
                </div>
                <div class="input-box">
                    <label>Giá phòng</label>
                    <input type="number" placeholder="Nhập giá phòng" required />
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Số lượng người lớn</label>
                    <input type="number" placeholder="Người lớn" required />
                </div>
                <div class="input-box">
                    <label>Số lượng trẻ nhỏ</label>
                    <input type="number" placeholder="Trẻ nhỏ" required />
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <div class="d-flex justify-content-between">
                        <label>Chọn giường</label>
                        <a href="#" class="text-primary m-0 p-0">Thêm mới</a>
                    </div>
                    <div class="select-box">
                        <select>
                            <option>Giường ...</option>
                            <option>Giường ...</option>
                            <option>Giường ...</option>
                        </select>
                    </div>
                    <textarea name="address" placeholder="Danh sách giường" rows="3"></textarea>
                </div>
                <div class="input-box">
                    <label>Ảnh Phòng:</label>
                    <input type="file" name="image" accept="image/*" onchange="previewImage(this)" required />
                    <textarea name="address" placeholder="Danh sách ảnh" rows="3"></textarea>
                </div>
            </div>

            <div class="input-box">
                <label>Mô tả</label>
                <textarea name="address" placeholder="Mô tả phòng" rows="3"></textarea>
            </div>

            <div class="input-box">

                <div class="d-flex justify-content-between">
                    <label>Tiện nghi phòng</label>
                    <a href="#" class="text-primary m-0 p-0">Thêm mới</a>
                </div>
                <div class="select-box">

                    <select>
                        <option>Tiện nghi ...</option>
                        <option>Tiện nghi ...</option>
                        <option>Tiện nghi ...</option>
                    </select>
                </div>
                <textarea name="address" placeholder="Danh sách tiện nghi" rows="3"></textarea>
            </div>

            <div class="column">
                <div class="input-box">
                    <div class="d-flex justify-content-between">
                        <label>Khuyến mãi</label>
                        <a href="#" class="text-primary m-0 p-0">Thêm mới</a>
                    </div>
                    <div class="select-box">
                        <select>
                            <option>Phòng ...</option>
                            <option>Phòng ...</option>
                            <option>Phòng ...</option>
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <div class="d-flex justify-content-between">
                        <label>Loại hình thanh toán</label>
                        <a href="#" class="text-primary m-0 p-0">Thêm mới</a>
                    </div>
                    <div class="select-box">
                        <select>
                            <option>Trả ...</option>
                            <option>Trả ...</option>
                        </select>
                    </div>
                </div>
            </div>
            <button class="btn-save" name="create" type="submit">Lưu lại</button>
            <a class="btn-a btn-cancel" href="<?= URLROOT . '/admin/room' ?>">Hủy</a>
        </form>
    </div>
</section>