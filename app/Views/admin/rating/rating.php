<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách tài khoản</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Nội dung <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng điểm <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"> Thao tác </th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['ratings'])) : $stt = 1;
                        foreach ($data['ratings'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><img src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="img"><?= trim($item['ho'] . ' ' . $item['ten']) ?></td>
                                <td class="desc"><?= $item['noidung'] ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['thoigian']))  ?></td>
                                <td class="number"><?= round($item['tongdiem'], 1) ?></td>
                                <td class="status">
                                    <p class="status"><?= $item['trangthai'] ?></p>
                                </td>
                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/rating/website/<?= $item['iddanhgia'] ?>" class="btn btn-info text-white mx-1"><i class="fa-solid fa-globe"></i></a>
                                        <a href="<?= URLROOT ?>/admin/rating/display/<?= $item['iddanhgia'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>
                                        <a href="<?= URLROOT ?>/admin/rating/hidden/<?= $item['iddanhgia'] ?>" class="btn btn-secondary text-white mx-1"><i class="fa-solid fa-eye-slash"></i></a>
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