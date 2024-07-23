//------------------------------------slider-wrapper-----------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll(".slider-wrapper");

    if (sliders) {
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
    }
});


// ----------------------------------------detail room -------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử DOM cần thiết
    const detail = document.getElementById('detail-image');
    if (detail) {
        const mainImage = document.getElementById('main-img');
        const carousel = detail.querySelector('.carousel');
        const carouselImages = detail.querySelectorAll('.carousel img');
        const leftArrow = detail.querySelector('.left');
        const rightArrow = detail.querySelector('.right');
        const arrowIcons = detail.querySelectorAll("i");
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
    }
});

//----------------------------------backtop----------------------------------//
document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.querySelector('.backtop');

    if (backToTopButton) {
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
    }
});


// ---------------------------------next tab reviews - amenities---------------------------------//
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
            if (bookingForm) {
                if (parseInt(input.value) == min || bookingForm.value == '') {
                    bookingForm.value = '';
                } else {
                    input.stepDown();
                }
            } else {
                input.stepDown();
            }
            input.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });
});

// -----------------------------------------------eye -pass---------------------------------------------//

document.addEventListener("DOMContentLoaded", togglePassword);
function togglePassword() {
    var toggles = document.querySelectorAll('#form-pass .eye-toggle');
    if (toggles) {
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const visible = this.getAttribute('data-visible') === 'true';

                if (visible) {
                    input.type = 'password';
                    this.src = USER_PATH + '/icon/eye-hidden.png';
                    this.setAttribute('data-visible', 'false');
                } else {
                    input.type = 'text';
                    this.src = USER_PATH + '/icon/eye.png';
                    this.setAttribute('data-visible', 'true');
                }
            });
        });
    }
}

// -----------------------------------------------ngăn chặn việc gửi lại form---------------------------------------------//
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// -----------------------------------------------Loader---------------------------------------------//

document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("beforeunload", function (event) {
        document.getElementById("loader").style.display = "block";
    });
});

