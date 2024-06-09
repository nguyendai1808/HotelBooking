<!-- Comment Start -->
<section class="comment pt-5 pb-5">

    <?php if (!empty($data['comments'])) : ?>

        <div class="container">
            <div class="text-center">
                <h6 class="section-title text-center text-secondary text-uppercase">Đánh giá của khách hàng</h6>
                <h2 class="title-name-below mb-5">Những đánh giá về <span class="text-warning text-uppercase">Khách sạn</span></h2>
            </div>
            <div class="comment-content">
                <div class="slider-wrapper">
                    <i id="left" class="fa-solid fa-angle-left"></i>
                    <ul class="carousel">

                        <?php foreach ($data['comments'] as $item) : ?>

                            <li class="card">
                                <div class="comment-item">
                                    <img src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anhdaidien']) ? $item['anhdaidien'] : 'user.png'; ?>" alt="img" draggable="false">
                                    <h6><?= $item['tennguoidung'] ?></h6>

                                    <div class="star mb-2">

                                        <?php
                                        $star = (floatval($item['tongdiem']) * 0.5);
                                        $fullStars = floor($star); // Số sao đầy đủ
                                        $halfStar = ($star - $fullStars >= 0.5) ? 1 : 0; // Số sao nửa
                                        $emptyStars = 5 - $fullStars - $halfStar; // Số sao trống

                                        for ($i = 0; $i < $fullStars; $i++) : ?>
                                            <span class="fa fa-star text-warning"></span>
                                        <?php endfor; ?>

                                        <?php if ($halfStar) : ?>
                                            <span class="fa fa-star-half-stroke text-warning"></span>
                                        <?php endif; ?>

                                        <?php for ($i = 0; $i < $emptyStars; $i++) : ?>
                                            <span class="fa-regular fa-star text-warning"></span>
                                        <?php endfor; ?>

                                    </div>

                                    <div class="comment-desc">
                                        <i class="fa-solid fa-quote-left"></i>
                                        <span><?= $item['noidung'] ?></span>
                                        <i class="fa-solid fa-quote-right"></i>
                                    </div>
                                </div>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                    <i id="right" class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>

    <?php endif; ?>

</section>
<!-- Comment End -->