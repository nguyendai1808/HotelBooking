<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách tài khoản</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="email"> Email <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Điểm <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Ngày tạo <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT . '/admin/account/create' ?>" class="btn btn-success"><small class="fa-solid fa-circle-plus pe-1"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['accounts'])) : $stt = 1;
                        foreach ($data['accounts'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><img src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="img"><?= trim($item['ho'] . ' ' . $item['ten']) ?></td>
                                <td class="email"><?= $item['email'] ?></td>
                                <td class="number"><?= $item['diemtichluy'] ?? 0 ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['ngaytao'])) ?></td>
                                <td class="status">
                                    <span class="status fw-bold text-<?php echo $item['trangthai'] == 'Khóa' ? 'danger' : 'success' ?> "><?= $item['trangthai'] ?></span>
                                </td>
                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/account/action" class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/account/detail/<?= $item['idtaikhoan'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if ($item['trangthai'] == 'Khóa') : ?>
                                            <button name="unlock" value="<?= $item['idtaikhoan'] ?>" onclick="return confirm('Bạn có chắc chắn muốn mở khóa tài khoản này');" class="btn btn-info text-white mx-1"><i class="fa-solid fa-lock-open"></i></button>
                                        <?php else : ?>
                                            <button name="lock" value="<?= $item['idtaikhoan'] ?>" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-lock"></i></button>
                                        <?php endif; ?>

                                    </form>
                                </td>
                            </tr>

                    <?php $stt++;
                        endforeach;
                    endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Start Pagination -->
        <div class="page-pagination" id="pagination-links">

            <?php if (isset($data['pagination'])) : extract($data['pagination']);
                $start = max($current_page - 1, 1);
                $end = min($start + 2, $total_pages);

                if ($current_page == $total_pages && $start > 1) :
                    $start--;
                endif; ?>

                <ul>
                    <?php if ($current_page > 1) : ?>
                        <li><a href="<?= URLROOT ?>/admin/account/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/admin/account/page/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li><a href="<?= URLROOT ?>/admin/account/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>

        </div>
        <!-- End Pagination -->
    </div>
</section>