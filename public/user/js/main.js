//------------------------------------slider-wrapper-----------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll(".slider-wrapper");

    sliders.forEach(slider => {
        const carousel = slider.querySelector(".carousel");

        // Lấy chiều rộng của thẻ đầu tiên trong "carousel"
        const firstCardWidth = carousel.querySelector(".card").offsetWidth;

        // Lấy ra tất cả các nút mũi tên trong slider-wrapper
        const arrowBtns = slider.querySelectorAll("i");

        // Danh sách các thẻ con của "carousel" dưới dạng một mảng
        const carouselChildren = Array.from(carousel.children);

        // Biến để kiểm tra trạng thái kéo
        let isDragging = false;

        // Biến để lưu trữ tọa độ x khi bắt đầu kéo
        let startX;

        // Biến để lưu trữ vị trí scrollLeft khi bắt đầu kéo
        let startScrollLeft;

        // Số lượng thẻ hiển thị trên một dòng
        let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

        // Biến lưu trữ ID của timeout
        let timeoutId;

        // Thêm các bản sao của một số thẻ cuối vào đầu "carousel" để tạo hiệu ứng cuộn vô tận
        carouselChildren.slice(-cardPerView).reverse().forEach(card => {
            carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
        });

        // Thêm các bản sao của một số thẻ đầu vào cuối "carousel" để tạo hiệu ứng cuộn vô tận
        carouselChildren.slice(0, cardPerView).forEach(card => {
            carousel.insertAdjacentHTML("beforeend", card.outerHTML);
        });

        // Cuộn đến vị trí phù hợp để ẩn một số thẻ bản sao đầu tiên trên Firefox
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");

        // Thêm sự kiện click cho các nút mũi tên để cuộn "carousel" qua trái và phải
        arrowBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
            });
        });

        // Hàm xử lý sự kiện khi bắt đầu kéo
        const dragStart = (e) => {
            isDragging = true;
            carousel.classList.add("dragging");
            startX = e.pageX;
            startScrollLeft = carousel.scrollLeft;
        }

        // Hàm xử lý sự kiện khi kéo
        const dragging = (e) => {
            if (!isDragging) return;
            carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
        }

        // Hàm xử lý sự kiện khi kết thúc kéo
        const dragStop = () => {
            isDragging = false;
            carousel.classList.remove("dragging");
        }

        // Hàm xử lý sự kiện cuộn vô tận
        const infiniteScroll = () => {
            if (carousel.scrollLeft === 0) {
                carousel.classList.add("no-transition");
                carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
                carousel.classList.remove("no-transition");
            } else if (Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
                carousel.classList.add("no-transition");
                carousel.scrollLeft = carousel.offsetWidth;
                carousel.classList.remove("no-transition");
            }
            clearTimeout(timeoutId);
            // Nếu slider-wrapper không hover thì tự động cuộn lại
            if (window.innerWidth >= 768 && !slider.matches(":hover")) {
                autoPlay();
            }
        }

        // Hàm tự động cuộn
        const autoPlay = () => {
            timeoutId = setTimeout(() => {
                carousel.scrollLeft += firstCardWidth;
                autoPlay();
            }, 2500);
        }

        // Gọi hàm tự động cuộn
        autoPlay();

        // Thêm các sự kiện cho "carousel"
        carousel.addEventListener("mousedown", dragStart);
        carousel.addEventListener("mousemove", dragging);
        document.addEventListener("mouseup", dragStop);
        carousel.addEventListener("scroll", infiniteScroll);
        slider.addEventListener("mouseenter", () => clearTimeout(timeoutId));
        slider.addEventListener("mouseleave", autoPlay);
    });
});


// ----------------------------------------detail room -------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử DOM cần thiết
    const mainImage = document.getElementById('main-img');
    const carousel = document.querySelector('.wrapper-img .carousel');
    const carouselImages = document.querySelectorAll('.wrapper-img .carousel img');
    const leftArrow = document.querySelector('.wrapper-img .left');
    const rightArrow = document.querySelector('.wrapper-img .right');
    const arrowIcons = document.querySelectorAll(".wrapper-img i");

    // Biến để kiểm tra trạng thái kéo chuột hoặc chạm màn hình
    let isDragStart = false,
        prevPageX, prevScrollLeft, positionDiff, currentIndex = 0;


    // Hàm cập nhật hình ảnh chính và áp dụng kiểu highlight cho ảnh đầu tiên trong danh sách
    function updateMainImageAndHighlight() {
        if (carouselImages.length > 0) {
            let firstImage = carouselImages[0];
            let imagePath = firstImage.getAttribute('src');
            mainImage.setAttribute('src', imagePath);
            applyImageHighlight(0);
        }
    }

    // Cập nhật hình ảnh chính và áp dụng kiểu highlight ngay sau khi tải trang lên
    updateMainImageAndHighlight();

    // Xử lý sự kiện khi người dùng click vào mũi tên điều hướng
    arrowIcons.forEach(icon => {
        icon.addEventListener("click", () => {
            let firstImgWidth = carouselImages[0].clientWidth + 14;
            // Kiểm tra xem mũi tên được nhấn là mũi tên trái hay phải
            if (icon.classList.contains("left")) {
                // Kiểm tra xem danh sách ảnh đã đến đầu chưa trước khi cuộn
                if (carousel.scrollLeft !== 0) {
                    carousel.scrollLeft -= firstImgWidth;
                }
            } else {
                // Kiểm tra xem danh sách ảnh đã đến cuối chưa trước khi cuộn
                if (carousel.scrollLeft !== (carousel.scrollWidth - carousel.offsetWidth)) {
                    carousel.scrollLeft += firstImgWidth;
                }
            }
        });
    });

    // Xử lý sự kiện khi bắt đầu kéo chuột hoặc chạm màn hình
    const dragStart = (e) => {
        isDragStart = true;
        prevPageX = e.pageX || e.touches[0].pageX;
        prevScrollLeft = carousel.scrollLeft;
    }

    // Xử lý sự kiện khi đang kéo chuột hoặc chạm màn hình
    const dragging = (e) => {
        if (!isDragStart) return;
        e.preventDefault();
        carousel.classList.add("dragging");
        positionDiff = (e.pageX || e.touches[0].pageX) - prevPageX;
        carousel.scrollLeft = prevScrollLeft - positionDiff;
    }

    // Xử lý sự kiện khi kết thúc kéo chuột hoặc chạm màn hình
    const dragStop = () => {
        isDragStart = false;
        carousel.classList.remove("dragging");
    }

    // Thêm các sự kiện cho việc kéo chuột và chạm màn hình
    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("touchstart", dragStart);
    document.addEventListener("mousemove", dragging);
    carousel.addEventListener("touchmove", dragging);
    document.addEventListener("mouseup", dragStop);
    carousel.addEventListener("touchend", dragStop);

    // Thêm sự kiện khi click vào mỗi ảnh trong carousel
    carouselImages.forEach((image, index) => {
        image.addEventListener('click', () => {
            currentIndex = index;
            let imagePath = carouselImages[currentIndex].getAttribute('src');
            mainImage.setAttribute('src', imagePath);
            applyImageHighlight(index);
        });
    });

    // Thêm sự kiện khi click vào mũi tên trái
    leftArrow.addEventListener('click', function () {
        if (currentIndex !== 0) {
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            let imagePath = carouselImages[currentIndex].getAttribute('src');
            mainImage.setAttribute('src', imagePath);
            applyImageHighlight(currentIndex);
        }
    });

    // Thêm sự kiện khi click vào mũi tên phải
    rightArrow.addEventListener('click', function () {
        if (currentIndex !== carouselImages.length - 1) {
            currentIndex = (currentIndex + 1) % carouselImages.length;
            let imagePath = carouselImages[currentIndex].getAttribute('src');
            mainImage.setAttribute('src', imagePath);
            applyImageHighlight(currentIndex);
        }
    });

    // Áp dụng kiểu highlight cho ảnh được chọn
    function applyImageHighlight(selectedIndex) {
        carouselImages.forEach((image, index) => {
            image.classList.toggle('selected', index === selectedIndex);
        });
    }
});

// next tab reviews - amenities---------------------------------//
document.addEventListener("DOMContentLoaded", setDefaultTab);

function setDefaultTab() {
    openTab('amenities');
}

function openTab(tabName) {
    // Ẩn tất cả các tab content
    var tabContents = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = 'none';
    }

    // Tìm tab content cần hiển thị và hiển thị nó
    var selectedTab = document.getElementById(tabName);
    if (selectedTab) {
        selectedTab.style.display = 'block';

        // Loại bỏ class 'active' từ tất cả các nút
        var tabButtons = document.getElementsByClassName('tab-button');
        for (var i = 0; i < tabButtons.length; i++) {
            tabButtons[i].classList.remove('active');
            // Reset màu cho tất cả các tab button
            tabButtons[i].style.backgroundColor = '#f0f0f0';
            tabButtons[i].style.color = '#000';
        }

        // Thêm class 'active' và đặt màu cho nút được chọn
        var activeTabButton = document.getElementById('tab' + tabName.charAt(0).toUpperCase() + tabName.slice(1));
        if (activeTabButton) {
            activeTabButton.classList.add('active');
            activeTabButton.style.backgroundColor = '#3498db';
            activeTabButton.style.color = '#fff';
        }
    }
}


//----------------------------------backtop----------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.querySelector('.backtop');

    // Hàm kiểm tra vị trí cuộn và hiển thị/ẩn nút quay lên top
    const checkScrollPosition = () => {
        if (window.scrollY > 0) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    };

    // Thêm sự kiện cho việc cuộn trang
    window.addEventListener('scroll', checkScrollPosition);

    // Thêm sự kiện cho nút quay lên top
    backToTopButton.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});


//------------------------------------------change-date--------------------------------------------/
function openChangDate() {
    var changedate = document.getElementById("change-date");
    changedate.style.display = "block";
}

function openChangeCartDate(idform) {
    var changedate = document.getElementById("change-date");
    changedate.style.display = "block";
    changedate.setAttribute("idform", idform);

    var numberDate = changedate.querySelector('#number-date');

    var form = document.getElementById(idform);
    var arrivalDate = form.querySelector('#arrival-date').textContent;
    var departureDate = form.querySelector('#departure-date').textContent;

    changedate.querySelector("#arrival-input").value = arrivalDate == "Ngày đến" ? null : formatDateYMD(arrivalDate);
    changedate.querySelector("#departure-input").value = departureDate == "Ngày đi" ? null : formatDateYMD(departureDate);

    numberDate.innerText = gapBetweenDate(formatDateYMD(departureDate), formatDateYMD(arrivalDate));
}

function saveChangeDate() {

    var mainContent = document.body.querySelector('main');
    if (mainContent.id == 'cart-page') {
        updateChangeCartDate();
    } else {
        var ngayden = document.getElementById("arrival-input").value;
        var ngaydi = document.getElementById("departure-input").value;

        if (ngayden == '' || ngaydi == '') {
            alert("Hãy nhập đầy đủ ngày đến và ngày đi");
        } else {
            // Gửi yêu cầu POST thông qua AJAX
            $.ajax({
                url: 'http://localhost/HotelBooking/home/changedate',
                type: 'POST',
                data: {
                    checkin: ngayden,
                    checkout: ngaydi
                },
                success: function (response) {

                    document.getElementById('checkinDate').value = ngayden;
                    document.getElementById('checkoutDate').value = ngaydi;
                    closeChangeDate();
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });

        }
    }
}

function updateChangeCartDate() {

    var idform = document.getElementById("change-date").getAttribute("idform");

    var ngayden = document.getElementById("arrival-input").value;
    var ngaydi = document.getElementById("departure-input").value;

    if (ngayden == '' || ngaydi == '') {
        alert("Hãy nhập đầy đủ ngày đến và ngày đi");
    } else {
        var homnay = new Date();
        var date1 = new Date(ngayden);
        var date2 = new Date(ngaydi);
        if (date1 <= homnay || date1 >= date2 || date2 <= homnay) {
            alert("Lịch đặt không hợp lệ, vui lòng chỉnh lại lịch đặt !");

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
            form.querySelector('#arrival-date').innerText = formatDateDMY(data.ngayden);
            form.querySelector('#departure-date').innerText = formatDateDMY(data.ngaydi);

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


function closeChangeDate() {
    document.getElementById("change-date").style.display = "none";
}

// ----------------------------------check change date ------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    var arrivalInput = document.getElementById("arrival-input");
    var departureInput = document.getElementById("departure-input");
    var numberDate = document.getElementById("number-date");

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

        numberDate.innerText = gapBetweenDate(departureInput.value, arrivalInput.value);
    });
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


// ------------------------------------- checkbox CheckboxChange---------------------------------------//
function checkboxChange(checkbox, idform) {
    var form = document.getElementById(idform);
    var ngayden = form.querySelector('#ngayden').value;
    var ngaydi = form.querySelector('#ngaydi').value;

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
            updateTotal();
        }
    }
}

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



function getListRoomByCategory(listIdPhong, iddanhmuc) {
    if (listIdPhong != '') {
        var url = 'category.php?listIdPhong=' + listIdPhong + '&iddanhmuc=' + iddanhmuc;
        window.location.href = url;
    } else {
        return;
    }
}


//------------------------------------BookingForm - checkin, checkout---------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    var checkinDate = document.getElementById("checkinDate");
    var checkoutDate = document.getElementById("checkoutDate");

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
});


// --------------------------------------tìm phòng----------------------------------------------//
document.addEventListener("DOMContentLoaded", function () {

    var timphongButton = document.getElementById('timphong');

    timphongButton.addEventListener('click', function (event) {
        var checkinValue = document.getElementById('checkinDate').value;
        var checkoutValue = document.getElementById('checkoutDate').value;

        if (checkinValue === "" && checkoutValue === "") {
            alert('Vui lòng nhập ngày đến hoặc ngày đi.');
            event.preventDefault();
        }
    });
});

// -----------------------------------------------Booknow---------------------------------------------//
function clickBooknow(event) {
    var ngayden = document.getElementById("checkinDate").value;
    var ngaydi = document.getElementById("checkoutDate").value;
    if (ngayden == '' || ngaydi == '') {
        event.preventDefault();
        openChangDate();
    }
}

// -----------------Bắt sự kiện khi thay đổi giá trị trong booking room--------------------//
document.addEventListener("DOMContentLoaded", function () {

    var form = document.getElementById("bookingForm");

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
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    });
});

// -----------------------------------------------số lượng---------------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    const quantities = document.querySelectorAll(".quantity");

    quantities.forEach((quantity) => {
        const plus = quantity.querySelector(".plus"),
            minus = quantity.querySelector(".minus"),
            input = quantity.querySelector(".num"),
            bookingForm = quantity.querySelector("#bookingForm .num"),
            min = parseInt(input.min);

        plus.addEventListener("click", () => {
            input.stepUp();
            input.dispatchEvent(new Event('change', { bubbles: true }));
        });

        minus.addEventListener("click", () => {
            if (parseInt(input.value) == min) {
                bookingForm.value = '';
            } else {
                input.stepDown();
            }
            input.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });
});

// ------------------------------------- checkbox bed-quantity --------------------------------------------//
const checkboxes = document.querySelectorAll('.bed-quantity');
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const quantity = this.closest('.bed-item').querySelector('.quantity');
        if (this.checked) {
            quantity.style.display = 'block';
        } else {
            quantity.style.display = 'none';
        }
    });
});

/* ----------------------------------------------range Price -------------------------------------------*/
const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");

// Đặt giới hạn khoảng giá
let priceGap = 100000;

// Thêm bộ lắng nghe sự kiện cho các trường nhập giá
priceInput.forEach(input => {
    input.addEventListener("input", e => {
        // Lấy giá tối thiểu và tối đa
        let minPrice = parseInt(priceInput[0].value.replace(/[đ.]/g, '').replace(/,/g, '')),
            maxPrice = parseInt(priceInput[1].value.replace(/[đ.]/g, '').replace(/,/g, ''));

        // Kiểm tra xem khoảng giá có lớn hơn giới hạn không và giá tối đa có nhỏ hơn giá trị tối đa của dải không
        if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
            // Nếu sự kiện là nhập giá tối thiểu
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                // Cập nhật vị trí của dải trượt dựa trên giá tối thiểu
                range.style.left = ((minPrice - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
            } else {
                rangeInput[1].value = maxPrice;
                // Cập nhật vị trí của dải trượt dựa trên giá tối đa
                range.style.right = ((rangeInput[1].max - maxPrice) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
            }
        }
    });
});

// Thêm bộ lắng nghe sự kiện cho các input của dải giá
rangeInput.forEach(input => {
    input.addEventListener("input", e => {
        // Lấy giá trị tối thiểu và tối đa
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        // Kiểm tra xem khoảng giá có nhỏ hơn giới hạn không
        if ((maxVal - minVal) < priceGap) {
            // Nếu sự kiện là nhập giá trượt tối thiểu
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            // Cập nhật giá trị của trường nhập giá
            priceInput[0].value = formatCurrency(minVal);
            priceInput[1].value = formatCurrency(maxVal);
            // Cập nhật vị trí của dải trượt dựa trên giá trị tối thiểu và tối đa
            range.style.left = ((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100 + "%";
            range.style.right = ((rangeInput[1].max - maxVal) / (rangeInput[1].max - rangeInput[1].min)) * 100 + "%";
        }
    });
});

function formatCurrency(number) {
    return number.toLocaleString('vi-VN') + 'đ';
}

// document.addEventListener('DOMContentLoaded', function () {
//     const priceRangeInput = document.getElementById('priceRange');
//     const selectedPriceElement = document.getElementById('selectedPrice');

//     priceRangeInput.addEventListener('input', function () {
//         const selectedPrice = Number(priceRangeInput.value).toLocaleString('vi-VN');
//         selectedPriceElement.textContent = selectedPrice;
//     });
// });


function SubmitFormCustomer() {
    var form = document.getElementById("form-customer");
    var fullname = form.querySelector('#fullname').value;
    var email = form.querySelector('#email').value;
    var phone = form.querySelector('#phone').value;

    // Gửi yêu cầu POST thông qua AJAX
    $.ajax({
        url: 'http://localhost/HotelBooking/payment/saveCustomer',
        type: 'POST',
        data: {
            fullname: fullname,
            email: email,
            phone: phone
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

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


//eye -pass
function showpass() {
    document.getElementById('eye-open').style.display = "block";
    document.getElementById('eye-close').style.display = "none";
    document.getElementById('eye-pass').type = "text";
}
function hiddenpass() {
    document.getElementById('eye-open').style.display = "none";
    document.getElementById('eye-close').style.display = "block";
    document.getElementById('eye-pass').type = "password";
}



