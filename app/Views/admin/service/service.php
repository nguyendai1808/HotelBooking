<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách dịch vụ</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên dịch vụ <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> mô tả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/service/create" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['services'])) : $stt = 1;
                        foreach ($data['services'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><img src="<?= USER_PATH ?>/images/services/<?= !empty($item['icon']) ? $item['icon'] : 'notImage.jpg' ?>" alt="img"><?= $item['tendichvu'] ?></td>
                                <td class="desc"><?= $item['mota'] ?></td>
                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/service/update/<?= $item['iddichvu'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= URLROOT ?>/admin/service/delete/<?= $item['iddichvu'] ?>" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></a>
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