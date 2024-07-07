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
                                    <p class="status"><?= $item['trangthai'] ?></p>
                                </td>
                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/account/detail/<?= $item['idtaikhoan'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if ($item['trangthai'] == 'Khóa') : ?>
                                            <a href="<?= URLROOT ?>/admin/account/unlock/<?= $item['idtaikhoan'] ?>" onclick="return confirm('Bạn có chắc chắn muốn mở khóa tài khoản này');" class="btn btn-info text-white mx-1"><i class="fa-solid fa-lock-open"></i></a>
                                        <?php else : ?>
                                            <a href="<?= URLROOT ?>/admin/account/lock/<?= $item['idtaikhoan'] ?>" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-lock"></i></a>
                                        <?php endif; ?>

                                    </div>
                                </td>
                            </tr>

                    <?php $stt++;
                        endforeach;
                    endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>