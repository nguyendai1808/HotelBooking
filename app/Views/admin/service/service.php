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
                                    <form method="post" action="<?= URLROOT ?>/admin/service/delete" class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/service/update/<?= $item['iddichvu'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button name="delete" value="<?= $item['iddichvu'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
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

    <div class="table-warpper">
        <h4 class="table-title">Danh sách loại hình thanh toán</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên loại hình thanh toán <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/service/createPayType" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['paytypes'])) : $stt = 1;
                        foreach ($data['paytypes'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="namePayType"><?= $item['loaihinhthanhtoan'] ?></td>

                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/service/deletePayType" class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/service/updatePayType/<?= $item['idloaihinhtt'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <button name="deletePayType" value="<?= $item['idloaihinhtt'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa loại hình thanh toán này');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
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