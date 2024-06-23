$(document).ready(function () {

    $('#category').on('click', 'li', function (e) {
        var categoryId = $(this).data('id');
        $.ajax({
            url: 'http://localhost/HotelBooking/room/category/' + categoryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                updateRoom(data);
                updatePagination(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    //Sự kiện change của select box
    $('#sort-select').on('change', function () {
        var sortBy = $(this).val();
        $.ajax({
            url: 'http://localhost/HotelBooking/room/sortRooms',
            method: 'GET',
            data: { sortBy: sortBy },
            success: function (data) {
                updateRoom(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    function updateRoom(data) {
        // Xoá nội dung phòng hiện tại
        $('#room-items').html('');
        if (data.rooms) {
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
        } else {
            var roomItem = `<p class="fw-bold mt-5 text-center">Không có phòng nào cả!</p>`;
            $('#room-items').append(roomItem);
        }
    }
    
    function updatePagination(data) {
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
    }


    function formatCurrency(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + 'đ';
    }


    const rangeInput = document.querySelectorAll(".range-input input"),
        priceInput = document.querySelectorAll(".price-input input"),
        range = document.querySelector(".slider .progress");

    let priceGap = 100000;
    let debounceTimer;

    priceInput.forEach(input => {
        input.addEventListener("input", updatePrice);
    });

    rangeInput.forEach(input => {
        input.addEventListener("input", updateRange);
    });

    function updatePrice(e) {
        let minPrice = parseInt(priceInput[0].value.replace(/[đ.]/g, '').replace(/,/g, '')),
            maxPrice = parseInt(priceInput[1].value.replace(/[đ.]/g, '').replace(/,/g, ''));

        if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = ((minPrice - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = ((rangeInput[1].max - maxPrice) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
            }
        }
        updatePriceInput();
    }

    function updateRange(e) {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if ((maxVal - minVal) < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            updatePriceInput();
            range.style.left = ((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
            range.style.right = ((rangeInput[1].max - maxVal) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
            debounceUpdate(minVal, maxVal);
        }
    }

    function updatePriceInput() {
        priceInput[0].value = formatCurrency(parseInt(rangeInput[0].value));
        priceInput[1].value = formatCurrency(parseInt(rangeInput[1].value));
    }

    function debounceUpdate(minVal, maxVal) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            updateRoomQuantity(minVal, maxVal);
        }, 500);
    }

    function updateRoomQuantity(minPrice, maxPrice) {
        $.ajax({
            url: "http://localhost/HotelBooking/room/rangePrice",
            type: 'GET',
            dataType: 'json',
            data: {
                minPrice: minPrice,
                maxPrice: maxPrice
            },
            success: function (data) {
                updateRoom(data);

                updatePagination(data);

            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }



    //  checkbox bed-quantity 
    let timeout;

    function updateRoomListWithDelay() {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            updateRoomList();
        }, 500);
    }

    const checkboxes = document.querySelectorAll('.bed-quantity');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const quantity = this.closest('.bed-item').querySelector('.quantity');
            if (this.checked) {
                quantity.style.display = 'block';
            } else {
                quantity.style.display = 'none';
            }
            updateRoomListWithDelay();
        });
    });

    const quantities = document.querySelectorAll('.quantity input');
    quantities.forEach(function (input) {
        input.addEventListener('change', function () {
            updateRoomListWithDelay();
        });
    });

    function updateRoomList() {
        const checkboxes = document.querySelectorAll('.bed-quantity:checked');
        const selectedBeds = Array.from(checkboxes).map(cb => ({
            id: cb.value,
            quantity: cb.closest('.bed-item').querySelector('.num').value
        }));

        $.ajax({
            url: "http://localhost/HotelBooking/room/filterBed",
            type: 'GET',
            dataType: 'json',
            data: { beds: JSON.stringify(selectedBeds) },
            success: function (data) {
                updateRoom(data);
                updatePagination(data);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

});

