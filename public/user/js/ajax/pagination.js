$(document).ready(function () {

    $(document).on('click', '#pagination-links a', function (e) {
        var mainContent = document.body.querySelector('main');
        e.preventDefault();
        var url = $(this).attr('href');
        if (mainContent.id === 'service-page') {
            loadPageService(url);
            changeUrl(url);
        } else if (mainContent.id === 'room-page') {
            loadPageRoom(url);
            changeUrl(url);
        } else if (mainContent.id === 'history-page' || mainContent.id === 'personal_infor-page') {
            loadPageBooking(url);
        } else if (mainContent.id === 'detailroom-page') {
            loadRating(url);
        }
        loadpaginationLinks(url);
    });

    function loadPageService(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Cập nhật nội dung dịch vụ
                $('#service-items').html('');

                data.services.forEach(function (item) {
                    var serviceItem = '<div class="col-lg-4 col-md-6">' +
                        '<a href="' + URLROOT + '/contact">' +
                        '<div class="service-item line-bottom">' +
                        '<div class="service-img">' +
                        '<img src="' + USER_PATH + '/images/services/' + item.icon + '" alt="icon">' +
                        '</div>' +
                        '<h5 class="mb-3 text-black">' + item.tendichvu + '</h5>' +
                        '<p class="text-body">' + item.mota + '</p>' +
                        '</div>' +
                        '</a>' +
                        '</div>';
                    $('#service-items').append(serviceItem);
                });
                var element = document.getElementById('service-items');
                scrollTop(element);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function loadRating(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#ratingUser').html('');

                data.ratingUser.forEach(function (item) {
                    var hoten = item.ho ? item.ho + ' ' + item.ten : item.ten;
                    var reviewItem = `
                        <div class="review-item">
                            <div class="review-user">
                                <img class="user-avatar" src="${USER_PATH}/images/avatars/${item.anh ? item.anh : 'user.png'}" alt="avatar">
                                <div>
                                    <strong>${hoten.trim()}</strong>
                                    <p class="m-0">${item.thoigian ? formatDate(item.thoigian) : ''}</p>
                                </div>
                                <div class="dropdown">
                                    <button><i class="fa-solid fa-ellipsis-vertical"></i></button>`;
                    if (item.id_taikhoan == data.user_id) {
                        reviewItem += `
                                    <form class="content" method="post" action="`+ URLROOT + `/room/rating">
                                        <button type="submit" name="update">
                                            <i class="fa-solid fa-pen-to-square pe-2"></i>Sửa
                                        </button>

                                        <button type="submit" name="delete" value="<?= $item['iddanhgia'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này');">
                                            <i class="fa-solid fa-delete-left pe-2"></i>Xóa
                                        </button>
                                    </form>`;
                    }
                    reviewItem += `
                                </div>
                            </div>
                            <ul class="rating">
                                <li class="lable">Đánh giá:</li>`;

                    if (item.chitietdanhgia && item.chitietdanhgia.length > 0) {
                        item.chitietdanhgia.forEach(function (row) {
                            reviewItem += `<li class="text-success">${row.tentieuchi ? row.tentieuchi : ''}: ${row.sodiem}đ</li>`;
                        });
                    }
                    reviewItem += `
                            </ul>
                            <p class="cmt">Bình luận: <span>${item.noidung}</span></p>
                        </div>`;

                    $('#ratingUser').append(reviewItem);
                });

                var element = document.getElementById('ratingUser');
                scrollTop(element);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function loadPageBooking(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#booking-items').html('');

                data.bookings.forEach(function (item, index) {
                    var stt = index + 1;
                    var giaphong = item.khuyenmai ? (item.giaphong - ((item.khuyenmai / 100) * item.giaphong)) : item.giaphong;
                    var dathanhtoan;

                    if (item.trangthaidat == 'Đã hủy') {
                        dathanhtoan = item.tonggia * 0.25;
                    } else if (item.trangthaidat == 'Đã cọc tiền') {
                        dathanhtoan = item.tonggia * 0.5;
                    } else {
                        dathanhtoan = item.tonggia;
                    }

                    // Tính toán ngày + 4 tuần
                    var ngaydi = new Date(item.ngaydi);
                    var ngaydiPlus4Weeks = new Date(ngaydi);
                    ngaydiPlus4Weeks.setDate(ngaydiPlus4Weeks.getDate() + 28);

                    // Tính toán ngày hiện tại + 1 tuần
                    var ngayden = new Date(item.ngayden);
                    var oneWeekFromNow = new Date();
                    oneWeekFromNow.setDate(oneWeekFromNow.getDate() + 7);

                    var bookingItem = `
                        <div class="room-item border mb-3" id="form-${stt}">
                            <form class="form-item col-12" action="${URLROOT}/history/cancelRoom" method="post">
                                <div class="item-img">
                                    <a href="${URLROOT}/room/detailroom/${item.id_phong}">
                                        <img src="${USER_PATH}/${item.anhphong ? item.anhphong : 'images/notImage.jpg'}">
                                    </a>
                                    ${item.khuyenmai ? `<small class="item-sale"><i class="fa-solid fa-tags"></i> -${item.khuyenmai}%</small>` : ''}
                                </div>
                                <div class="item-detail">
                                    <div class="d-flex justify-content-between">
                                        <h5><a href="${URLROOT}/room/detailroom/${item.id_phong}">${item.tenphong} - ${item.tengiuong}</a></h5>

                                        ${(item.trangthaidat == 'Hoàn tất' && item.id_taikhoan && ngaydiPlus4Weeks > new Date()) ? `
                                        <button class="btn border-0 p-0" type="button" onclick="openRating('${item.id_phong}','${item.id_taikhoan}','${item.iddatphong}')">
                                            <img class="item-rating" src="${USER_PATH}/icon/rating.png" alt="rating">
                                        </button>`: ''}

                                    </div>

                                    <div class="item-date">
                                        <span id="arrival-date">${item.ngayden ? formatDate(item.ngayden) : ''}</span>
                                        <i class="bi bi-arrow-right-short"></i>
                                        <span id="departure-date">${item.ngaydi ? formatDate(item.ngaydi) : ''}</span>
                                    </div>
                                    <p class="mb-2 fw-bold"><span class="text-success">${item.loaihinhtt}</span></p>
                                    ${item.khuyenmai ? `
                                        <h6 class="item-price"><del>${formatCurrency(item.giaphong)}</del> ${formatCurrency(giaphong)}</h6>
                                    ` : `
                                        <h6 class="item-price">${formatCurrency(giaphong)}</h6>
                                    `}
                                    <p class="mb-2 text-success">Đã thanh toán: <span>${formatCurrency(dathanhtoan)}</span></p>
                                    <input type="hidden" name="iddatphong" value="${item.iddatphong}">
                                    <input type="hidden" name="trangthaidon" value="${item.trangthaidon}">
                                    <input type="hidden" name="iddondat" value="${item.iddondat}">
                                    <input type="hidden" name="soluonghuy" id="soluonghuy">
                
                                   <div class="d-flex justify-content-between align-items-center">
                                   
                                        ${item.trangthaidat == 'Hoàn tất' || item.trangthaidat == 'Đã hủy' || item.trangthaidat == 'Đã đánh giá' ? `
                                            <button class="btn-invoice" type="submit" name="detail" value="${item.iddondat}" formaction="${URLROOT}/invoice">ID: ${item.iddondat}</button>
                                            <a href="${URLROOT}/room/detailroom/${item.id_phong}" class="btn-item-book">Đặt Lại</a>
                                        ` : `
                                            <button class="btn-invoice" type="submit" name="detail" value="${item.iddondat}" formaction="${URLROOT}/invoice">ID: ${item.iddondat}</button>
                                            ${(ngayden > oneWeekFromNow) ? `
                                                <button class="btn-item-cancel" name="cancel" type="submit" onclick="return confirmAction(this, 'Bạn có chắc chắn muốn hủy không?') && inputNumber('form-${stt}')">Hủy</button>
                                            ` : ''}
                                        `}
                                    </div>
                                    
                                </div>
                            </form>
                            <div class="item-total col-12 border-top">
                                <div class="w-25 text-center d-flex flex-column">
                                    <span class="fw-bold text-${item.trangthaidat == 'Đã hủy' ? 'danger' : (item.trangthaidat == 'Đã cọc tiền' ? 'warning' : 'success')}">${item.trangthaidat}</span>
                                    <span>${formatDate(item.thoigiandat)}</span>
                                </div>
                                <div class="w-75 d-flex justify-content-end text-end">
                                    <div class="pe-3">
                                        <span id="soluong">${item.soluongdat}</span> x phòng - 
                                        <span id="songay">${item.songay}</span> ngày
                                    </div>
                                    <h6 class="m-0 fw-bold lh-base">Tổng: <span id="tonggia">${formatCurrency(item.tonggia)}</span></h6>
                                </div>
                            </div>
                        </div>
                    `;

                    $('#booking-items').append(bookingItem);
                });

                var element = document.getElementById('booking-move');
                scrollTop(element);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function loadPageRoom(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Xoá nội dung phòng hiện tại
                $('#room-items').html('');

                // Duyệt qua mỗi phòng và tạo HTML cho từng phòng
                data.rooms.forEach(function (item) {
                    var stt = 1;
                    var giaphong = item.khuyenmai != null ? (item.giaphong - ((item.khuyenmai / 100) * item.giaphong)) : item.giaphong;
                    var roomItem = `
                        <form class="col-12 mb-4 shadow rounded overflow-hidden" action="` + URLROOT + `/payment" method="post" id="form-` + stt + `">
                            <div class="row">
                                <div class="room-img col-lg-5 p-3">
                                    <img class="img-fluid" src="`+ USER_PATH + `/${item.anhphong != null ? item.anhphong : 'images/notImage.jpg'}" alt="img">
    
                                    ${item.khuyenmai ? `<small class="item-sale"><i class="fa-solid fa-tags"></i> -${item.khuyenmai}%</small>` : ''}
                                    <small class="item-price">${formatCurrency(giaphong)}/đêm</small>
                                    <small class="item-payment">${item.loaihinhtt}</small>
                                </div>
                                <div class="room-infor col-lg-7 p-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">${item.tenphong} - ${item.tengiuong}</h5>
                                        <div class="ps-3">
                                            <span class="fw-bold text-success">${item.danhgia != null ? (parseFloat(item.danhgia).toFixed(1) + '/10') : ''}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p>${item.mota}</p>
                                        <div class="d-flex mb-3">
                                            <small class="border-end me-2 pe-2"><i class="fa fa-bed text-warning pe-2"></i>${item.sogiuong} giường</small>
                                            <small class="border-end me-2 pe-2"><i class="fa fa-chart-area text-warning pe-2"></i>40 m²</small>
                                            <small><i class="fa fa-wifi text-warning pe-2"></i>miễn phí</small>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        ${item.trenho ? `<p class="text-body">Người lớn: ${item.nguoilon} - Trẻ nhỏ: ${item.trenho}</p>` : `<p class="text-body">Người lớn: ${item.nguoilon}</p>`}

                                        <p class="text-${Number(item.soluongphongtrong) < 5 ? 'danger' : 'secondary'}">Phòng trống: ${item.soluongphongtrong}</p>

                                    </div>
                                    <input type="hidden" name="idphong" value="${item.idphong}">
                                    <input type="hidden" name="giaphong" value="${giaphong}">
                                    <input type="hidden" id="sophongtrong" value="${item.soluongphongtrong}">

                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-sm btn-warning rounded py-2 px-4 fw-bold" href="`+ URLROOT + `/room/detailroom/${item.idphong}">Xem chi tiết</a>
                                        <button type="submit" name="booknow" onclick="clickBooknow(event,'${item.idphong}');" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    `;
                    // Thêm HTML của phòng vào danh sách phòng
                    $('#room-items').append(roomItem);
                });
                var element = document.getElementById('list-room');
                scrollTop(element);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Hàm định dạng ngày tháng
    function formatDate(date) {
        var d = new Date(date);
        var day = ('0' + d.getDate()).slice(-2);
        var month = ('0' + (d.getMonth() + 1)).slice(-2);
        var year = d.getFullYear();
        return day + '-' + month + '-' + year;
    }

    // Hàm định dạng tiền tệ
    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + 'đ';
    }

    function scrollTop(element) {
        if (element) {
            var offsetPosition = element.offsetTop;
            window.scrollTo({
                top: offsetPosition - 100,
                behavior: "smooth"
            });
        }
    }

    function loadpaginationLinks(url) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (data) {

                // Cập nhật thanh phân trang
                $('#pagination-links').html('');

                if (data.pagination) {
                    var start = Math.max(data.pagination.current_page - 1, 1);
                    var end = Math.min(start + 2, data.pagination.total_pages);

                    if (data.pagination.current_page == data.pagination.total_pages && start > 1) {
                        start--;
                    }

                    var paginationLinks = '<ul>';

                    if (data.pagination.current_page > 1) {
                        paginationLinks += '<li><a href="' + URLROOT + '/' + data.view + '/1"><i class="fa-solid fa-angles-left"></i></a></li>';
                    }

                    for (var i = start; i <= end; i++) {
                        paginationLinks += '<li><a ' + (i == data.pagination.current_page ? 'class="active"' : '') + ' href="' + URLROOT + '/' + data.view + '/' + i + '">' + i + '</a></li>';
                    }

                    if (data.pagination.current_page < data.pagination.total_pages) {
                        paginationLinks += '<li><a href="' + URLROOT + '/' + data.view + '/' + data.pagination.total_pages + '"><i class="fa-solid fa-angles-right"></i></a></li>';
                    }

                    paginationLinks += '</ul>';
                } else {
                    paginationLinks = '';
                }

                $('#pagination-links').html(paginationLinks);

            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    function changeUrl(url) {
        window.history.pushState({ path: url }, '', url);
    }

});