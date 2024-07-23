<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách Phòng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên phòng - giường <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Giá phòng <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Số lượng <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT . '/admin/room/create' ?>" class="btn btn-success"><small class="fa-solid fa-circle-plus pe-1"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['rooms'])) : $stt = 1;
                        foreach ($data['rooms'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name">
                                    <img src="<?= USER_PATH ?>/<?= !empty($item['anhphong']) ? $item['anhphong'] : 'images/notImage.jpg'; ?>" alt="img">
                                    <?= trim($item['tenphong'] . ' - ' . $item['tengiuong']) ?>
                                </td>
                                <td class="number"><?= number_format($item['giaphong'], 0, ',', '.') ?></td>
                                <td class="number"><?= $item['soluong'] ?></td>
                                <td class="status">
                                    <span class="fw-bold text-<?php echo $item['trangthai'] == 'Tạm dừng' ? 'warning' : 'success' ?>"><?= $item['trangthai'] ?></span>
                                </td>
                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/room/action" class="d-flex justify-content-center">

                                        <?php if ($item['trangthai'] == 'Hoạt động') : ?>

                                            <button name="pause" value="<?= $item['idphong'] ?>" onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái tạm dừng');" class="btn btn-info text-white mx-1"><i class="fa-solid fa-rotate"></i></button>
                                        <?php else : ?>

                                            <button name="continue" value="<?= $item['idphong'] ?>" onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái hoạt động');" class="btn btn-info text-white mx-1"><i class="fa-solid fa-rotate"></i></button>
                                        <?php endif; ?>

                                        <a href="<?= URLROOT ?>/admin/room/update/<?= $item['idphong'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button name="delete" value="<?= $item['idphong'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
                                    </form>
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