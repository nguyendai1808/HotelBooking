<section class="change-date" id="change-date">
    <div class="date-content row">
        <span class="close-date"><i class="fa-solid fa-xmark" onclick="closeChangeDate()"></i></span>
        <div class="col-lg-3 mb-2">
            <div class="date">
                <label for="">Ngày đến</label>
                <input type="date" class="form-control" id="arrival-input" />
            </div>
        </div>
        <div class="col-lg-3 mb-2">
            <div class="date">
                <label for="">Ngày đi</label>
                <input type="date" class="form-control" id="departure-input" />
            </div>
        </div>
        <div class="col-lg-4 mb-2 d-flex align-items-center justify-content-center">
            <div class="cart-more">
                <p>Số phòng trống: <span id="">6</span></p>
                <p>Thời gian đặt: <span id="number-date">7</span> ngày</p>
            </div>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-center">
            <div class="update-date">
                <button class="btn-update-date" onclick="saveChangeDate()">Lưu</button>
            </div>
        </div>
    </div>
</section>