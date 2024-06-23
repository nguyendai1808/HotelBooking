//------------------------------------------open change-date--------------------------------------------/
function openChangDate(idphong) {
    var changedate = document.getElementById("change-date");
    changedate.style.display = "block";
    changedate.querySelector('#idphong').value = idphong;

    var numberDate = changedate.querySelector('#number-date');
    var arrivalDate = changedate.querySelector('#arrival-input').value;
    var departureDate = changedate.querySelector('#departure-input').value;

    if (arrivalDate != '' && departureDate != '') {
        $.ajax({
            url: 'http://localhost/HotelBooking/home/checkRoom',
            type: 'POST',
            dataType: 'json',
            data: {
                arrival: arrivalDate,
                departure: departureDate,
                idphong: idphong
            },
            success: function (data) {
                changedate.querySelector('#emptyRoom').textContent = data.emptyRoom;
                changedate.querySelector("#arrival-input").value = arrivalDate;
                changedate.querySelector("#departure-input").value = departureDate;
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    } else {
        changedate.querySelector("#arrival-input").value = null;
        changedate.querySelector("#departure-input").value = null;
    }
    numberDate.innerText = gapBetweenDate(departureDate, arrivalDate);
}
//------------------------------------------open change-date in page cart--------------------------------------------/
function openChangeCartDate(idform, idphong) {
    var changedate = document.getElementById("change-date");
    changedate.querySelector('#idphong').value = idphong;
    changedate.style.display = "block";
    changedate.setAttribute("idform", idform);

    var numberDate = changedate.querySelector('#number-date');

    var form = document.getElementById(idform);
    var arrivalDate = form.querySelector('#arrival-date').textContent;
    var departureDate = form.querySelector('#departure-date').textContent;
    changedate.querySelector('#emptyRoom').textContent = 0;

    if (arrivalDate != 'Ngày đến' && departureDate != 'Ngày đi') {
        $.ajax({
            url: 'http://localhost/HotelBooking/home/checkRoom',
            type: 'POST',
            dataType: 'json',
            data: {
                arrival: formatDateYMD(arrivalDate),
                departure: formatDateYMD(departureDate),
                idphong: idphong
            },
            success: function (data) {
                changedate.querySelector('#emptyRoom').textContent = data.emptyRoom;
                changedate.querySelector("#arrival-input").value = formatDateYMD(arrivalDate);
                changedate.querySelector("#departure-input").value = formatDateYMD(departureDate);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    } else {
        changedate.querySelector("#arrival-input").value = null;
        changedate.querySelector("#departure-input").value = null;
    }

    numberDate.innerText = gapBetweenDate(formatDateYMD(departureDate), formatDateYMD(arrivalDate));
}

//------------------------------------------save change-date--------------------------------------------/
function saveChangeDate() {

    var ngayden = document.getElementById("arrival-input").value;
    var ngaydi = document.getElementById("departure-input").value;

    if (ngayden == '' || ngaydi == '') {
        alert("Hãy nhập đầy đủ ngày đến và ngày đi");
        return false;
    } else {
        var mainContent = document.body.querySelector('main');
        if (mainContent.id == 'cart-page') {
            updateChangeCartDate();
            return false;
        } else {
            var form = document.getElementById('change-date-form');
            var phongtrong = form.querySelector('#emptyRoom').textContent;

            if (Number(phongtrong) <= 0) {
                if (confirm("Với lịch hiện tại số phòng trống đã hết, Bạn vẫn muốn chọn lịch với những phòng khác chứ!")) {

                    form.action = 'http://localhost/HotelBooking/room/search';
                    closeChangeDate();
                } else {
                    return false;
                }
            } else {
                form.action = 'http://localhost/HotelBooking/payment';
                closeChangeDate();
            }

            return true;
        }
    }
}
//------------------------------------------save change-date in cart--------------------------------------------/
function updateChangeCartDate() {

    var idform = document.getElementById("change-date").getAttribute("idform");
    var ngayden = document.getElementById("arrival-input").value;
    var ngaydi = document.getElementById("departure-input").value;
    var phongtrong = document.getElementById("emptyRoom").textContent;

    var homnay = new Date();
    var date1 = new Date(ngayden);
    var date2 = new Date(ngaydi);
    if (date1 <= homnay || date1 >= date2 || date2 <= homnay) {
        alert("Lịch đặt không hợp lệ, vui lòng chỉnh lại lịch đặt !");

    } else {
        if (Number(phongtrong) <= 0) {
            alert("Với lịch hiện tại số phòng trống đã hết, vui lòng chọn lại lịch hoặc đặt phòng khác!");

        } else {
            var form = document.getElementById(idform);
            form.querySelector('#arrival-date').innerText = formatDateDMY(ngayden);
            form.querySelector('#departure-date').innerText = formatDateDMY(ngaydi);

            //input hidden
            form.querySelector('#ngayden').value = ngayden;
            form.querySelector('#ngaydi').value = ngaydi;

            updateCart(idform);
            closeChangeDate();
        }

    }
}
//------------------------------------------update cart--------------------------------------------/
function updateCart(idform) {

    var form = document.getElementById(idform);

    var iddatphong = form.querySelector('#iddatphong').value;
    var ngayden = form.querySelector('#ngayden').value;
    var ngaydi = form.querySelector('#ngaydi').value;
    var giaphong = form.querySelector('#giaphong').value;
    var soluongdat = form.querySelector('#soluongdat').value;

    var songay = gapBetweenDate(ngaydi, ngayden);
    var tonggia = parseInt(songay) * parseInt(soluongdat) * parseInt(giaphong);

    $.ajax({
        url: 'http://localhost/HotelBooking/cart/updateCart',
        type: 'POST',
        dataType: 'json',
        data: {
            iddatphong: iddatphong,
            ngayden: ngayden,
            ngaydi: ngaydi,
            soluongdat: soluongdat,
            tonggia: tonggia
        },
        success: function (data) {
            form.querySelector('#arrival-date').innerText = data.ngayden == '' ? 'Ngày đến' : formatDateDMY(data.ngayden);
            form.querySelector('#departure-date').innerText = data.ngaydi == '' ? 'Ngày đi' : formatDateDMY(data.ngaydi);

            form.querySelector('#soluong').innerText = data.soluongdat;
            form.querySelector('#songay').innerText = gapBetweenDate(data.ngaydi, data.ngayden);
            form.querySelector('#tonggia').innerText = data.tonggia.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            updateTotal();
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

//------------------------------------------close change-date--------------------------------------------/
function closeChangeDate() {
    document.getElementById("change-date").style.display = "none";
}

// ----------------------------------check change date ------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    var arrivalInput = document.getElementById("arrival-input");
    var departureInput = document.getElementById("departure-input");
    var numberDate = document.getElementById("number-date");
    if (arrivalInput && departureInput && numberDate) {
        // Thêm lắng nghe sự kiện cho input ngày đến
        arrivalInput.addEventListener("input", function () {
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate());

            if (new Date(arrivalInput.value) < currentDate) {
                alert("Ngày đến phải lớn hơn ngày hôm nay ít nhất 1 ngày.");
                arrivalInput.value = null;
                numberDate.innerText = 0;
                return;
            }

            if (arrivalInput.value >= departureInput.value || !departureInput.value) {
                if (arrivalInput.value) {
                    var newDepartureDate = new Date(arrivalInput.value);
                    newDepartureDate.setDate(newDepartureDate.getDate() + 1);
                    departureInput.value = newDepartureDate.toISOString().split("T")[0];
                }

            }

            numberDate.innerText = gapBetweenDate(departureInput.value, arrivalInput.value);

        });

        // Thêm lắng nghe sự kiện cho input ngày đi
        departureInput.addEventListener("input", function () {

            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 1);

            if (new Date(departureInput.value) < currentDate) {
                alert("Ngày đi phải lớn hơn ngày hôm nay ít nhất 2 ngày.");
                departureInput.value = null;
                numberDate.innerText = 0;
                return;
            }

            if (departureInput.value <= arrivalInput.value || !arrivalInput.value) {
                if (departureInput.value) {
                    var newArrivalDate = new Date(departureInput.value);
                    newArrivalDate.setDate(newArrivalDate.getDate() - 1);
                    arrivalInput.value = newArrivalDate.toISOString().split("T")[0];
                }

            }
        });

        numberDate.innerText = gapBetweenDate(departureInput.value, arrivalInput.value);
    }

});

// -------------------------------Hàm chuyển định dạng ngày --------------------------------//
function formatDateDMY(date) {
    var options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    var formattedDate = new Date(date).toLocaleDateString('en-GB', options);
    var parts = formattedDate.split('/');
    return parts[0] + '-' + parts[1] + '-' + parts[2];
}

function formatDateYMD(dateString) {
    var delimiter = dateString.includes('-') ? '-' : '/';

    // Chia chuỗi thành mảng [ngày, tháng, năm]
    var parts = dateString.split(delimiter);
    return parts[2] + '-' + parts[1] + '-' + parts[0];
}

function gapBetweenDate(date2, date1) {
    var gap = new Date(date2) - new Date(date1);
    return isNaN(gap) ? 0 : gap / (1000 * 60 * 60 * 24);
}


// ------------------------------------- checkbox CheckboxChange in cart---------------------------------------//
function checkboxChange(checkbox, idform) {
    var form = document.getElementById(idform);
    var ngayden = form.querySelector('#ngayden').value;
    var ngaydi = form.querySelector('#ngaydi').value;
    var idphong = form.querySelector('#idphong').value;
    var soluongdat = form.querySelector('#soluongdat').value;

    if (ngayden == "" || ngaydi == "") {
        alert("Bạn chưa chọn ngày !");
        checkbox.checked = false;
        return;
    } else {
        var homnay = new Date();
        var date1 = new Date(ngayden);
        var date2 = new Date(ngaydi);
        if (date1 <= homnay || date1 >= date2 || date2 <= homnay) {
            alert("Lịch đặt không hợp lệ, vui lòng chỉnh lại lịch đặt !");
            checkbox.checked = false;
            return;
        } else {
            $.ajax({
                url: 'http://localhost/HotelBooking/home/checkRoom',
                type: 'POST',
                dataType: 'json',
                data: {
                    arrival: ngayden,
                    departure: ngaydi,
                    idphong: idphong
                },
                success: function (data) {
                    if (Number(data.emptyRoom) > 0 && soluongdat <= Number(data.emptyRoom)) {
                        updateTotal();
                    } else {
                        alert("Số phòng trống hiện tại không đủ, vui lòng chọn lại lịch hoặc đặt phòng khác!");
                        checkbox.checked = false;
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }
}
// ------------------------------------- update total in cart---------------------------------------//
function updateTotal() {
    var checkboxes = document.querySelectorAll('.form-check-input');

    var totalRooms = document.getElementById('total-rooms');
    var totalPayment = document.getElementById('total-payment');

    var currentTotalRooms = 0;
    var currentTotalPayment = 0;

    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            var itemTotal = checkbox.closest('.item-total');
            var soluong = itemTotal.querySelector('#soluong');
            var tonggia = itemTotal.querySelector('#tonggia');

            currentTotalRooms += parseInt(soluong.textContent);
            currentTotalPayment += parseInt(tonggia.textContent.replace("đ", "").replace(/\./g, ""));
        }
    });

    totalRooms.textContent = currentTotalRooms >= 0 ? currentTotalRooms : 0;
    totalPayment.textContent = currentTotalPayment >= 0 ? new Intl.NumberFormat('vi-VN').format(currentTotalPayment) + 'đ' : '0đ';
}


// ------------------------------------- bookingRoom---------------------------------------//
function bookingRoom() {
    checkedItems = [];
    var checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(function (checkbox) {
        var roomItem = checkbox.closest('.room-item');
        var iddatphong = roomItem.querySelector('#iddatphong').value;
        if (checkbox.checked) {
            checkedItems.push(iddatphong);
        }
    });

    if (checkedItems.length > 0) {
        // Tạo một form mới
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = 'http://localhost/HotelBooking/payment'; // Thiết lập action của form

        // Tạo input hidden và gắn giá trị
        checkedItems.forEach(function (itemId) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'iddatphong[]';
            hiddenInput.value = itemId;
            // Thêm input hidden vào form
            form.appendChild(hiddenInput);
        });

        // Thêm form vào body của trang
        document.body.appendChild(form);

        // Submit form
        form.submit();
    } else {
        alert("Bạn chưa chọn phòng");
    }
}

//------------------------------------BookingForm - checkin, checkout---------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    var checkinDate = document.getElementById("checkinDate");
    var checkoutDate = document.getElementById("checkoutDate");

    if (checkinDate && checkoutDate) {

        // Thêm lắng nghe sự kiện cho input ngày đến
        checkinDate.addEventListener("input", function () {
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate());

            if (new Date(checkinDate.value) < currentDate) {
                alert("Ngày đến phải lớn hơn ngày hôm nay ít nhất 1 ngày.");
                checkinDate.value = null;
                return;
            }

            if (checkinDate.value >= checkoutDate.value || !checkoutDate.value) {
                if (checkinDate.value) {
                    var newDepartureDate = new Date(checkinDate.value);
                    newDepartureDate.setDate(newDepartureDate.getDate() + 1);
                    checkoutDate.value = newDepartureDate.toISOString().split("T")[0];
                }
            }
        });

        // Thêm lắng nghe sự kiện cho input ngày đi
        checkoutDate.addEventListener("input", function () {
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 1);

            if (new Date(checkoutDate.value) < currentDate) {
                alert("Ngày đi phải lớn hơn ngày hôm nay ít nhất 2 ngày.");
                checkoutDate.value = null;
                return;
            }

            if (checkoutDate.value <= checkinDate.value || !checkinDate.value) {
                if (checkoutDate.value) {
                    var newArrivalDate = new Date(checkoutDate.value);
                    newArrivalDate.setDate(newArrivalDate.getDate() - 1);
                    checkinDate.value = newArrivalDate.toISOString().split("T")[0];
                }
            }
        });
    }
});


// --------------------------------------tìm phòng----------------------------------------------//
document.addEventListener("DOMContentLoaded", function () {

    var timphongButton = document.getElementById('search');

    if (timphongButton) {
        timphongButton.addEventListener('click', function (event) {
            var checkinValue = document.getElementById('checkinDate').value;
            var checkoutValue = document.getElementById('checkoutDate').value;

            if (checkinValue === "" || checkoutValue === "") {
                alert('Vui lòng nhập đầy đủ ngày đến và ngày đi.');
                event.preventDefault();
            }
        });
    }
});

// -----------------------------------------------Booknow---------------------------------------------//
function clickBooknow(event, idphong) {
    var ngayden = document.getElementById("checkinDate").value;
    var ngaydi = document.getElementById("checkoutDate").value;
    var phongtrong = document.getElementById("sophongtrong").value;
    var mainContent = document.body.querySelector('main');

    if (mainContent.id == 'home-page') {
        event.preventDefault();
        openChangDate(idphong);
    } else {
        if (ngayden == '' || ngaydi == '') {
            event.preventDefault();
            openChangDate(idphong);
        } else {
            if (phongtrong <= 0) {
                event.preventDefault();
                alert("Số phòng trống hiện tại đã hết, vui lòng chọn lại lịch hoặc đổi phòng khác!");
            }
        }
    }
}

// -----------------Bắt sự kiện khi thay đổi giá trị trong booking room--------------------//
document.addEventListener("DOMContentLoaded", function () {

    var form = document.getElementById("bookingForm");

    if (form) {
        form.addEventListener("change", function () {
            var checkin = form.querySelector('#checkinDate').value;
            var checkout = form.querySelector('#checkoutDate').value;
            var adult = form.querySelector('#adult').value;
            var child = form.querySelector('#child').value;

            // Gửi yêu cầu POST thông qua AJAX
            $.ajax({
                url: 'http://localhost/HotelBooking/home/bookingForm',
                type: 'POST',
                data: {
                    checkin: checkin,
                    checkout: checkout,
                    adult: adult,
                    child: child
                },
                success: function (response) {
                    var mainContent = document.body.querySelector('main');
                    if (mainContent.id == 'detailroom-page') {
                        location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }
});

// -----------------Bắt sự kiện khi thay đổi giá trị trong change-date kiểm tra phòng trống--------------------//
document.addEventListener("DOMContentLoaded", function () {

    var changedate = document.getElementById("change-date");
    if (changedate) {
        changedate.addEventListener("change", function () {
            var arrival = changedate.querySelector('#arrival-input').value;
            var departure = changedate.querySelector('#departure-input').value;
            var idphong = changedate.querySelector('#idphong').value;

            // Gửi yêu cầu POST thông qua AJAX
            $.ajax({
                url: 'http://localhost/HotelBooking/home/checkRoom',
                type: 'POST',
                dataType: 'json',
                data: {
                    arrival: arrival,
                    departure: departure,
                    idphong: idphong
                },
                success: function (data) {
                    changedate.querySelector('#emptyRoom').textContent = data.emptyRoom;
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

        });
    }
});

// ------------------------------------- Submit Form Customer---------------------------------------//
function SubmitFormCustomer() {
    var form = document.getElementById("form-customer");
    var fullname = form.querySelector('#fullname').value;
    var email = form.querySelector('#email').value;
    var phone = form.querySelector('#phone').value;
    var address = form.querySelector('#address').value;

    // Gửi yêu cầu POST thông qua AJAX
    $.ajax({
        url: 'http://localhost/HotelBooking/payment/saveCustomer',
        type: 'POST',
        data: {
            fullname: fullname,
            email: email,
            phone: phone,
            address: address
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

// -----------------------------------------------check form payment---------------------------------------------//
function checkFormCustomer() {
    var fullname = document.getElementById('fullname').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var email = document.getElementById('email').value.trim();
    var valid = true;
    var errorMessage = "";
    var firstInvalidField = null;

    // Kiểm tra họ và tên
    if (fullname === "") {
        errorMessage += "- Họ và tên là bắt buộc.\n";
        valid = false;
        if (!firstInvalidField) {
            firstInvalidField = document.getElementById('fullname');
        }
    }

    if (phone === "") {
        errorMessage += "- Số điện thoại là bắt buộc.\n";
        valid = false;
        if (!firstInvalidField) {
            firstInvalidField = document.getElementById('phone');
        }
    } else if (!/^\d{10}$/.test(phone)) {
        errorMessage += "- Số điện thoại phải gồm 10 chữ số.\n+ Vui lòng nhập đúng định dạng: 0123456789.\n";
        valid = false;
        if (!firstInvalidField) {
            firstInvalidField = document.getElementById('phone');
        }
    }

    if (email === "") {
        errorMessage += "- Email là bắt buộc.\n";
        valid = false;
        if (!firstInvalidField) {
            firstInvalidField = document.getElementById('email');
        }
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errorMessage += "- Email không hợp lệ.\n+ Vui lòng nhập đúng định dạng: example@domain.com.\n";
        valid = false;
        if (!firstInvalidField) {
            firstInvalidField = document.getElementById('email');
        }
    }

    if (!valid) {
        alert(errorMessage);
        if (firstInvalidField) {
            firstInvalidField.focus();
        }
    } else {
        SubmitFormCustomer();
    }

    return valid;
}

// --------------------------------------------preview Image------------------------------------------------//
function previewImage(input) {
    var file = input.files[0];
    var reader = new FileReader();

    reader.onload = function (e) {
        var imgElement = input.parentNode.querySelector('img');
        imgElement.src = e.target.result;
    }
    reader.readAsDataURL(file);
}

// -----------------------------------------------confirm Action---------------------------------------------//
function confirmAction(button, message) {
    const isConfirmed = confirm(message);

    if (!isConfirmed) {
        return false;
    }
    return true;
}

// -----------------------------------------------check phòng trống---------------------------------------------//
function checkEmptyRoom() {
    var phongtrong = document.getElementById('sophongtrong').value;
    // var soluongdat = document.getElementById('soluongdat').value;
    if (phongtrong <= 0) {
        alert('Số phòng trống hiện tại đã hết, vui lòng chọn lại lịch hoặc đổi phòng khác!');
        return false;
    }
    return true;
}