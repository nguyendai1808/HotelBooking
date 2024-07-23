<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách khuyến mãi</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Khuyến mãi <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Mô tả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Bắt đầu <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Kết thúc <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/promotion/create" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['promotions'])) : $stt = 1;
                        foreach ($data['promotions'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="number"><?= $item['khuyenmai'] ?>%</td>
                                <td class="desc"><?= $item['mota'] ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['ngaybatdau'])) ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['ngayketthuc'])) ?></td>
                                <td class="method">
                                    <form method="post" action="<?= URLROOT ?>/admin/promotion/delete" class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/promotion/detail/<?= $item['idkhuyenmai'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if (strtotime($item['ngayketthuc']) > time()) : ?>
                                            <a href="<?= URLROOT ?>/admin/promotion/update/<?= $item['idkhuyenmai'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <?php endif; ?>

                                        <button name="delete" value="<?= $item['idkhuyenmai'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa');" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></button>
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