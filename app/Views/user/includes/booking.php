<!-- booking Start -->
<section class="booking pb-5">
    <div class="container">
        <form class="booking-item" action="<?= URLROOT ?>/room/search" method="post" id="bookingForm">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                        <div class="col-md-3 pt-2">
                            <div class="date">
                                <label>Ngày đến</label>
                                <input type="date" class="form-control" name="checkin" id="checkinDate" value="<?= $bookingForm['checkin'] ?? '' ?>" />
                            </div>
                        </div>
                        <div class="col-md-3 pt-2">
                            <div class="date">
                                <label>Ngày đi</label>
                                <input type="date" class="form-control" name="checkout" id="checkoutDate" value="<?= $bookingForm['checkout'] ?? '' ?>" />
                            </div>
                        </div>

                        <div class="col-md-3 pt-2">
                            <label>Người lớn (18+)</label>
                            <div class="quantity form-control">
                                <input type="number" class="num" min="1" max="100" name="adult" id="adult" value="<?= $bookingForm['adult'] ?? ''; ?>" placeholder="Số người">
                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3 pt-2">
                            <label>Trẻ nhỏ (1-15)</label>
                            <div class="quantity form-control">
                                <input type="number" class="num" min="1" max="100" name="child" id="child" value="<?= $bookingForm['child'] ?? ''; ?>" placeholder="Số người">
                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-booking col-lg-2 col-md-12 pt-3">
                    <button type="submit" name="search" id="search" class="btn btn-warning">Tìm</button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- booking end -->