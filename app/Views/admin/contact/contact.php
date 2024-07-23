<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách liên hệ</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="email"> Email <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Chủ đề <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Nội dung <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method">Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['contacts'])) :
                        $count = 0;
                        foreach ($data['contacts'] as $item) :
                            $count++; ?>
                            <tr>
                                <td class="stt"><?= $count ?></td>
                                <td class="name"><?= $item['hoten'] ?></td>
                                <td class="email"><?= $item['email'] ?></td>
                                <td class="name"><?= $item['chude'] ?></td>
                                <td class="desc"><?= $item['noidung'] ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['thoigian'])) ?></td>
                                <td class="status">
                                    <span class="status fw-bold text-<?php echo $item['trangthai'] == 'Chờ phản hồi' ? 'warning' : 'success' ?> "><?= $item['trangthai'] ?></span>
                                </td>
                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/contact/delete" class="d-flex justify-content-center">

                                        <?php if ($item['trangthai'] == 'Đã phản hồi') : ?>
                                            <a href="<?= URLROOT ?>/admin/contact/feedback/<?= $item['idlienhe'] ?>" class="btn btn-secondary text-white mx-1"><i class="fa-solid fa-envelope-circle-check"></i></a>

                                        <?php else : ?>

                                            <a href="<?= URLROOT ?>/admin/contact/feedback/<?= $item['idlienhe'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-reply"></i></a>
                                        <?php endif; ?>

                                        <button name="delete" value="<?= $item['idlienhe'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa liên hệ này');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</section>