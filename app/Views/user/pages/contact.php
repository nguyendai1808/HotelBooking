<Main class="container-fluid">

    <section class="banner-image banner-gray mb-5">
        <img src="<?= USER_PATH ?>/images/<?= $data['display']['baner'] ?? 'notbg.jpg'?>" alt="banner">
        <div class="banner-content">
            <h3 class="section-title text-uppercase">Liên hệ</h3>
            <div class="banner-item">
                <ul>
                    <li><a href="<?= URLROOT ?>/home">Trang chủ</a></li>
                    <li><span>Liên hệ</span></li>
                </ul>
            </div>
        </div>
    </section>


    <!-- Contact start -->
    <section class="contact pb-5">
        <div class="container">
            <div class="row">
                <?php if (!empty($data['hotel'])) :
                    foreach ($data['hotel'] as $item) : ?>

                        <div class="col-lg-12 mb-4">
                            <h6 class="section-title text-start text-secondary text-uppercase">Xin chào !</h6>
                            <h2 class="mb-2">Hãy liên hệ với chúng tôi tại <span class="text-warning text-uppercase"><?= $item['tenkhachsan'] ?></span></h2>
                            <p>Nếu có bất kỳ câu hỏi, yêu cầu đặc biệt hoặc muốn biết thêm thông tin, hãy đừng ngần ngại liên hệ với chúng tôi.</p>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <div class="contact-item p-4">
                                        <div class="item-icon mb-3 pb-3">
                                            <i class="fa-solid fa-location-dot fa-2x text-warning pe-3"></i>
                                            <h5 class="m-0">Địa chỉ</h5>
                                        </div>
                                        <p class="mb-0"><?= $item['diachi'] ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="contact-item p-4">
                                        <div class="item-icon mb-3 pb-3">
                                            <i class="fa-solid fa-phone fa-2x text-warning pe-3"></i>
                                            <h5 class="m-0">Số điện thoại</h5>
                                        </div>
                                        <p class="mb-0"><?= $item['sdt'] ?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="contact-item p-4">
                                        <div class="item-icon mb-3 pb-3">
                                            <i class="fa-regular fa-envelope fa-2x text-warning pe-3"></i>
                                            <h5 class="m-0">Email</h5>
                                        </div>
                                        <p class="mb-0"><?= $item['email'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php endforeach;
                endif; ?>

                <div class="col-lg-6 mb-5">
                    <div class="contact-wrapper">
                        <div class="contact-title">
                            <h4>Google Map</h4>
                        </div>
                        <div class="contact-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7448.2798086305675!2d105.
                                    79689843384105!3d21.027087372197983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.
                                    1!3m3!1m2!1s0x3135ab424a50fff9%3A0xbe3a7f3670c0a45f!2zVHLGsOG7nW5nIMSQ4bqhaSBI4buNYyBHaWFvIFRow7RuZyBW4bqtbiBU4bqjaQ!5e0!3m2!1svi!2s!4v1699545757775!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-wrapper">
                        <div class="contact-title">
                            <h4>Liên Hệ</h4>
                        </div>
                        <div class="contact-form">
                            <form id="contact-form" action="<?= URLROOT ?>/contact/send" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="contact-box mb-20">
                                            <label for="contact-name">Họ tên</label>
                                            <input name="fullname" type="text" id="contact-name" placeholder="Nhập tên của bạn" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact-box mb-20">
                                            <label for="contact-email">Email</label>
                                            <input name="email" type="email" id="contact-email" placeholder="Nhập email của bạn" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="contact-box mb-20">
                                            <label for="contact-subject">Chủ đề</label>
                                            <input name="subject" type="text" id="contact-subject" placeholder="Nhập chủ đề bạn muốn" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="contact-box mb-20">
                                            <label for="contact-message">Tin nhắn của bạn</label>
                                            <textarea name="message" id="contact-message" cols="10" rows="4" placeholder="Nội dung tin nhắn" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn-contact" type="submit" name="send">Gửi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Contact end -->

</Main>