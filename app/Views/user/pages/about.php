<Main class="container-fluid">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/bg-img.jpg" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Giới thiệu</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><span>Giới thiệu</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- About start -->
    <section class="about pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="section-title text-start text-secondary text-uppercase">Khám phá</h6>
                    <h2 class="mb-2">Những trải nghiệm tuyệt vời cùng với <span class="text-warning text-uppercase">HotelStay</span></h2>
                    <div class="star line-below mb-3">
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star-half-stroke"></span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <p class="mb-4 mt-4" style="font-size: 17px;">HotelStay được đầu tư hệ thống phù hợp với nhiều nhu cầu của khách hàng. Hệ thống trang thiết bị hiện đại và các các dịch vụ đưa đón khách tham quan các điểm du lịch.</p>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="border rounded bg-white p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-door-open fa-2x text-warning mb-2"></i>
                                    <h3 class="mb-1">1234</h3>
                                    <p class="mb-0">Phòng</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="border rounded bg-white p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa-solid fa-cart-flatbed-suitcase fa-2x text-warning mb-2"></i>
                                    <h3 class="mb-1">1234</h3>
                                    <p class="mb-0">Dịch vụ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="border rounded bg-white p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-comment fa-2x text-warning mb-2"></i>
                                    <h3 class="mb-1">1234</h3>
                                    <p class="mb-0">Đánh giá</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="see-detail mb-2 mt-3">
                        <a class="btn btn-warning text-uppercase fw-bold text-white px-5 py-3" href="about.php">Xem chi tiết</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4">
                    <div class="about-list-img">
                        <div class="slider-wrapper">
                            <i id="left" class="fa-solid fa-angle-left"></i>
                            <ul class="carousel">
                                <li class="card">
                                    <div class="card-img">
                                        <img src="<?= USER_PATH ?>/images/hotel/hotel_img_1.webp" alt="img" draggable="false">
                                    </div>
                                </li>
                                <li class="card">
                                    <div class="card-img">
                                        <img src="<?= USER_PATH ?>/images/hotel/hotel_img_2.webp" alt="img" draggable="false">
                                    </div>
                                </li>
                                <li class="card">
                                    <div class="card-img">
                                        <img src="<?= USER_PATH ?>/images/hotel/hotel_img_3.webp" alt="img" draggable="false">
                                    </div>
                                </li>
                                <li class="card">
                                    <div class="card-img">
                                        <img src="<?= USER_PATH ?>/images/hotel/hotel_img_4.webp" alt="img" draggable="false">
                                    </div>
                                </li>
                                <li class="card">
                                    <div class="card-img">
                                        <img src="<?= USER_PATH ?>/images/hotel/hotel_img_5.webp" alt="img" draggable="false">
                                    </div>
                                </li>
                            </ul>
                            <i id="right" class="fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Video -->
    <section class="video pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pb-5">
                    <div class="video-img">
                        <div class="image-play">
                            <a href="javascript:void(0);" onclick="playVideo('<?= USER_PATH ?>/Video/about-video-hotel.mp4')">
                                <img src="<?= USER_PATH ?>/images/hotel/hotel_main_img.webp" alt="Image">
                                <span class="icon-wrap">
                                    <span class="icon-play bi bi-play-fill"></span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div id="video-overlay" class="video-overlay">
                        <div class="video-wrapper">
                            <button id="close-btn" onclick="closeVideo()"><i class="fa-solid fa-xmark fa-2x"></i></button>
                            <video id="video-player" controls>
                                <source src="" type="video/mp4">
                            </video>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 pb-5">
                    <div class="about-rating">
                        <div class="rating-title">
                            <h4>9,5/10 Tuyệt vời</h4>
                            <a href="#"><span>(1.232 bài đánh giá)</span></a>
                        </div>
                        <div class="rating-box">
                            <div class="rating-text">
                                <span class="title">Sạch sẽ</span>
                                <span class="score">9,5 điểm</span>
                            </div>
                            <div class="rating-bar">
                                <span class="score-bar" style="width: 100%;"></span>
                            </div>
                        </div>
                        <div class="rating-box">
                            <div class="rating-text">
                                <span class="title">Thoải mãi & chất lượng</span>
                                <span class="score">9,5 điểm</span>
                            </div>
                            <div class="rating-bar">
                                <span class="score-bar" style="width: 40%;"></span>
                            </div>
                        </div>
                        <div class="rating-box">
                            <div class="rating-text">
                                <span class="title">Tiện nghi</span>
                                <span class="score">9,5 điểm</span>
                            </div>
                            <div class="rating-bar">
                                <span class="score-bar" style="width: 100%;"></span>
                            </div>
                        </div>
                        <div class="rating-box">
                            <div class="rating-text">
                                <span class="title">Dịch vụ</span>
                                <span class="score">9,5 điểm</span>
                            </div>
                            <div class="rating-bar">
                                <span class="score-bar" style="width: 100%;"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- About End -->


    <!-- Service -->
    <section class="service pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-warning text-uppercase">Dịch vụ của HotelStay</h6>
                <h2 class="mb-5">Khám phá <span class="text-warning text-uppercase">Dịch vụ Nổi bật</span></h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item line-bottom">
                        <a href="service.php">
                            <div class="service-img">
                                <img src="<?= USER_PATH ?>/icon/tiennghi/tv.png" alt="tv">
                            </div>
                            <h5 class="mb-3 text-black">Dịch Vụ Phòng 24/7</h5>
                            <p class="text-body">Phục vụ nhu cầu của khách hàng mọi lúc</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service End -->

    <!-- Comment Start -->
    <section class="comment pt-5 pb-5">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-secondary text-uppercase">Đánh giá của khách hàng</h6>
                <h2 class="title-name-below mb-5">Những đánh giá về <span class="text-warning text-uppercase">HotelStay</span></h2>
            </div>
            <div class="comment-content">
                <div class="slider-wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                        <li class="card">
                            <div class="comment-item">
                                <div class="img"><img src="<?= USER_PATH ?>/images/room/room-2.jpg" alt="img" draggable="false"></div>
                                <h6>Client Name</h6>
                                <div class="comment-desc">
                                    <i class="fa-solid fa-quote-left"></i>
                                    <span>dsfagdas dsadsaTempor stet dsalabore dolor dsa dsasa </span>
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- Comment End -->
</Main>

<script>
    function playVideo(videoSrc) {
        var videoPlayer = document.getElementById('video-player');
        videoPlayer.src = videoSrc;

        videoPlayer.currentTime = 0;

        document.getElementById('video-overlay').style.display = 'flex';
    }


    function closeVideo() {
        var videoPlayer = document.getElementById('video-player');
        videoPlayer.pause();
        videoPlayer.src = '';
        document.getElementById('video-overlay').style.display = 'none';
    }
</script>