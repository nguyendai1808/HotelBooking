<!-- backtop -->
<?php if ($page != 'cart.php') : ?>
    <a href="#" class="backtop back-to-top"><i class="bi bi-arrow-up"></i></a>
<?php endif; ?>


<!-- Footer Start -->
<footer>
    <div class="footer">
        <div class="footer-wrapper">
            <?php if (!empty($footer)) :
                foreach ($footer as $item) : ?>
                    <div class="footer-item">
                        <a href="<?= URLROOT ?>/home">
                            <img src="<?= USER_PATH ?>/images/HotelBooking-logo.png" class="logo"/>
                        </a>
                        <p class="desc">
                            <?= $item['mota'] ?>
                        </p>
                        <ul class="socials">
                            <li>
                                <a href="<?= URLROOT ?>/Information">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?= URLROOT ?>/Information">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?= URLROOT ?>/Information">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?= URLROOT ?>/Information">
                                    <i class="fa-brands fa-tiktok"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h6>Liên Hệ</h6>
                        <ul class="links-contact">
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <a href="<?= URLROOT ?>/Information"><?= $item['diachi'] ?></a>
                            </li>
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <a href="<?= URLROOT ?>/Information"><?= $item['sdt'] ?></a>
                            </li>
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <a href="<?= URLROOT ?>/Information"><?= $item['email'] ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h6>Công Ty</h6>
                        <ul class="links">
                            <li><a href="<?= URLROOT ?>/Information">Thông tin</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Tuyển dụng</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Báo chí</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Nhật ký mạng</a></li>
                        </ul>
                    </div>
                    <div class="footer-item">
                        <h6>Trợ Giúp</h6>
                        <ul class="links">
                            <li><a href="<?= URLROOT ?>/Information">Trung tâm trợ giúp</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Câu hỏi thường gặp</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Chính sách bảo mật</a></li>
                            <li><a href="<?= URLROOT ?>/Information">Điều khoản sử dụng</a></li>
                        </ul>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
        <div class="footer-copyright">
            <p>
                &copy; HotelBokking là nhà cung cấp dịch vụ du lịch trực tuyến & các dịch vụ có liên quan hàng đầu Việt Nam.
            </p>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- link js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?= USER_PATH ?>/js/main.js"></script>
<script src="<?= USER_PATH ?>/js/script.js"></script>
<script src="<?= USER_PATH ?>/js/ajax/pagination.js"></script>
<script src="<?= USER_PATH ?>/js/ajax/update_content.js"></script>
</body>

</html>