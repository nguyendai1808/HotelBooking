<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Chi tiết khuyến mãi phòng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên phòng - giường <i class="fa-solid fa-arrow-up"></i></th>
                        <?php if (strtotime($data['time'][0]['ngayketthuc']) > time()) : ?>
                            <th class="method"><a href="<?= URLROOT . '/admin/offers/createPromotionRoom/' . $data['idkhuyenmai'] ?>" class="btn btn-success"><small class="fa-solid fa-circle-plus pe-1"></small>Thêm</a></th>
                        <?php endif; ?>

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

                                <?php if (strtotime($data['time'][0]['ngayketthuc']) > time()) : ?>
                                    <td class="method">
                                        <div class="d-flex justify-content-center">
                                            <a href="<?= URLROOT ?>/admin/offers/deletePromotionRoom/<?= $item['idphong'] . '/' . $data['idkhuyenmai'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                <?php endif; ?>

                            </tr>

                    <?php $stt++;
                        endforeach;
                    endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>