<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách bảo trì</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên bảo trì <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Bắt đầu <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Kết thúc <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Mô tả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/maintenance/create" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['maintenances'])) : $stt = 1;
                        foreach ($data['maintenances'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><?= $item['tenbaotri'] ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['thoigianbatdau'])) ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['thoigianketthuc'])) ?></td>
                                <td class="desc"><?= $item['mota'] ?></td>
                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/maintenance/delete" class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/maintenance/detail/<?= $item['idbaotri'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if (strtotime($item['thoigianketthuc']) > time()) : ?>
                                            <a href="<?= URLROOT ?>/admin/maintenance/update/<?= $item['idbaotri'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <?php endif; ?>

                                        <button name="delete" value="<?= $item['idbaotri'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
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