
const URLROOT = 'http://localhost/HotelBooking';
const USER_PATH = URLROOT + '/public/user';
const ADMIN_PATH = URLROOT + '/public/admin';

$(document).ready(function () {
    $('#pagination-links').on('click', 'a', function (e) {
        var mainContent = document.body.querySelector('main');
        e.preventDefault();
        var url = $(this).attr('href');
        if (mainContent.id === 'service-page') {
            loadPageService(url);
        } else if (mainContent.id === 'room-page') {
            loadPageRoom(url);
        }
        loadpaginationLinks(url);
        changeUrl(url);
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
                        '<div class="service-item line-bottom">' +
                        '<div class="service-img">' +
                        '<img src="' + USER_PATH + '/images/services/' + item.icon + '" alt="icon">' +
                        '</div>' +
                        '<h5 class="mb-3 text-black">' + item.tendichvu + '</h5>' +
                        '<p class="text-body">' + item.mota + '</p>' +
                        '</div>' +
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
                                    <small class="item-price">${giaphong}đ/đêm</small>
                                    <small class="item-payment">${item.loaihinhtt}</small>
                                </div>
                                <div class="room-infor col-lg-7 p-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">${item.tenphong} - ${item.tengiuong}</h5>
                                        <div class="ps-3">
                                            <span class="fw-bold text-success">${item.danhgia != null ? item.danhgia : ''}</span>
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
                                        <p class="text-body">Phòng trống: 10</p>
                                    </div>
                                    <input type="hidden" name="idphong" value="${item.idphong}">
                                    <input type="hidden" name="giaphong" value="${giaphong}">
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-sm btn-warning rounded py-2 px-4 fw-bold" href="`+ URLROOT + `/room/detailroom/${item.idphong}">Xem chi tiết</a>
                                        <button type="submit" name="booknow" onclick="clickBooknow(event);" class="btn btn-sm btn-dark rounded py-2 px-4 fw-bold">Đặt ngay</button>
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

                var start = Math.max(data.pagination.current_page - 1, 1);
                var end = Math.min(start + 2, data.pagination.total_pages);

                if (data.pagination.current_page == data.pagination.total_pages && start > 1) {
                    start--;
                }

                var paginationLinks = '<ul>';

                if (data.pagination.current_page > 1) {
                    paginationLinks += '<li><a href="' + URLROOT + '/' + data.view + '/page/1"><i class="fa-solid fa-angles-left"></i></a></li>';
                }

                for (var i = start; i <= end; i++) {
                    paginationLinks += '<li><a ' + (i == data.pagination.current_page ? 'class="active"' : '') + ' href="' + URLROOT + '/' + data.view + '/page/' + i + '">' + i + '</a></li>';
                }

                if (data.pagination.current_page < data.pagination.total_pages) {
                    paginationLinks += '<li><a href="' + URLROOT + '/' + data.view + '/page/' + data.pagination.total_pages + '"><i class="fa-solid fa-angles-right"></i></a></li>';
                }

                paginationLinks += '</ul>';

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