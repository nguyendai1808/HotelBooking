<Main class="container-fluid">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/bg-img-2.jpg" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Giới thiệu</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><span>Giới thiệu</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- About start -->
    <section class="about pb-5">
        <div class="container">
            <div class="row">

                <?php if (!empty($data['hotel'])) :
                    foreach ($data['hotel'] as $item) : ?>

                        <div class="col-lg-12">
                            <h6 class="section-title text-start text-secondary text-uppercase">Khám phá</h6>
                            <h2 class="mb-2">Những trải nghiệm tuyệt vời cùng với <span class="text-warning text-uppercase"><?= $item['tenkhachsan'] ?></span></h2>

                            <div class="star line-below mb-2">

                                <?php
                                $star = (floatval($item['sodiem']) * 0.5);
                                $fullStars = floor($star); // Số sao đầy đủ
                                $halfStar = ($star - $fullStars >= 0.5) ? 1 : 0; // Số sao nửa
                                $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống

                                for ($i = 0; $i < $fullStars; $i++) : ?>
                                    <span class="fa fa-star"></span>
                                <?php endfor; ?>

                                <?php if ($halfStar) : ?>
                                    <span class="fa fa-star-half-stroke"></span>
                                <?php endif; ?>

                                <?php for ($i = 0; $i < $emptyStars; $i++) : ?>
                                    <span class="fa-regular fa-star"></span>
                                <?php endfor; ?>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <p class="mb-4 mt-4" style="font-size: 17px;"><?= $item['thongtin'] ?></p>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa fa-door-open fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sophong'] ?></h3>
                                            <p class="mb-0">Phòng</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa-solid fa-cart-flatbed-suitcase fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sodichvu'] ?></h3>
                                            <p class="mb-0">Dịch vụ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="border rounded p-1 bg-white">
                                        <div class="border rounded text-center p-4">
                                            <i class="fa fa-comment fa-2x text-warning mb-2"></i>
                                            <h3 class="mb-1"><?= $item['sodanhgia'] ?></h3>
                                            <p class="mb-0">Đánh giá</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="see-detail mb-2 mt-3">
                                <a class="btn btn-warning text-uppercase fw-bold text-white px-5 py-3" href="<?= URLROOT ?>/room">Đặt phòng</a>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-4">
                            <div class="about-list-img">
                                <div class="slider-wrapper">
                                    <i id="left" class="fa-solid fa-angle-left"></i>
                                    <ul class="carousel">

                                        <?php if (!empty($item['anhks'])) :
                                            foreach ($item['anhks'] as $row) :  ?>

                                                <li class="card">
                                                    <div class="card-img">
                                                        <img src="<?= USER_PATH ?>/<?= !empty($row['anh']) ? $row['anh'] : 'images/notImage.jpg'; ?>" alt="img" draggable="false">
                                                    </div>
                                                </li>

                                            <?php endforeach;
                                        else : ?>

                                            <li class="card">
                                                <div class="card-img">
                                                    <img src="<?= USER_PATH ?>/images/notImage.jpg'; ?>" alt="img" draggable="false">
                                                </div>
                                            </li>

                                        <?php endif; ?>

                                    </ul>
                                    <i id="right" class="fa-solid fa-angle-right"></i>
                                </div>
                            </div>
                        </div>

                <?php endforeach;
                endif; ?>

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
                            <a href="javascript:void(0);" onclick="playVideo('<?= $data['video'] ?? '' ?>')">
                                <img src="<?= USER_PATH ?>/<?= !empty($data['imgMainHotel']) ? $data['imgMainHotel'] : 'images/notImage.jpg'; ?>" alt="Image">
                                <span class="icon-wrap">
                                    <span class="icon-play bi bi-play-fill"></span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div id="video-overlay" class="video-overlay" style="display:none;">
                        <div class="video-wrapper">
                            <button id="close-btn" onclick="closeVideo()"><i class="fa-solid fa-xmark fa-2x"></i></button>
                            <iframe id="video-player" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pb-5">
                    <div class="about-rating">

                        <?php if (!empty($data['ratingHotel'])) :
                            $rating = $data['ratingHotel'];
                            $tmp = '';
                            if (!empty($rating[0]['tongdiem'])) {
                                $diem = floatval($rating[0]['tongdiem']);
                                if ($diem == 10) {
                                    $tmp = 'Hoàn hảo';
                                } elseif ($diem >= 8 && $diem < 10) {
                                    $tmp = 'Tuyệt vời';
                                } elseif ($diem >= 5 && $diem < 8) {
                                    $tmp = 'Tốt';
                                } elseif ($diem >= 3 && $diem < 5) {
                                    $tmp = 'Trung bình';
                                } else {
                                    $tmp = 'Kém';
                                }
                            } else {
                                $tmp = 'Chưa có đánh giá nào!';
                            }
                        ?>

                            <div class="rating-title">
                                <h4><?= round($rating[0]['tongdiem'], 1) ?? '' ?>/10 <?= $tmp ?></h4>
                                <span class="text-secondary">(<?= $rating[0]['sodanhgia'] ?? '' ?> bài đánh giá)</span>
                            </div>

                            <?php if ($rating[0]['diemtheotieuchi']) :
                                foreach ($rating[0]['diemtheotieuchi'] as $item) : ?>

                                    <div class="rating-box">
                                        <div class="rating-text">
                                            <span class="title"><?= $item['tentieuchi'] ?? '' ?></span>
                                            <span class="score"><?= round($item['sodiem'], 1)  ?? '' ?> điểm</span>
                                        </div>
                                        <div class="rating-bar">
                                            <span class="score-bar" style="width: <?= intval($item['sodiem']) * 10 ?? 0 ?>%;"></span>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        <?php else : ?>

                            <p class="h6">Chưa có đánh giá nào!</p>

                        <?php endif; ?>

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
                <h6 class="section-title text-center text-secondary text-uppercase">Dịch vụ của khách sạn</h6>
                <h2 class="title-name-below mb-5">Khám phá <span class="text-warning text-uppercase">Dịch vụ Nổi bật</span></h2>
            </div>
            <div class="row g-4">

                <?php if (!empty($data['services'])) :
                    foreach ($data['services'] as $item) : ?>

                        <div class="col-lg-4 col-md-6">
                            <a href="<?= URLROOT ?>/contact">
                                <div class="service-item line-bottom">
                                    <div class="service-img">
                                        <img src="<?= USER_PATH ?>/images/services/<?= $item['icon'] ?>" alt="icon">
                                    </div>
                                    <h5 class="mb-3 text-black"><?= $item['tendichvu'] ?></h5>
                                    <p class="text-body"><?= $item['mota'] ?></p>
                                </div>
                            </a>
                        </div>

                <?php endforeach;
                endif; ?>

            </div>
        </div>
    </section>
    <!-- Service End -->

    <?php include APPROOT . '/views/user/pages/comment.php'; ?>

</Main>

<script>
    function playVideo(videoUrl) {
        var videoOverlay = document.getElementById('video-overlay');
        var videoPlayer = document.getElementById('video-player');
        videoPlayer.src = videoUrl;
        videoOverlay.style.display = 'block';
    }

    function closeVideo() {
        var videoOverlay = document.getElementById('video-overlay');
        var videoPlayer = document.getElementById('video-player');
        videoPlayer.src = '';
        videoOverlay.style.display = 'none';
    }
</script>