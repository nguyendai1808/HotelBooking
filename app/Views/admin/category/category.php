<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách danh mục phòng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên danh mục <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Mô tả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/category/create" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['category'])) :
                        $count = 0;
                        foreach ($data['category'] as $item) :
                            $count++; ?>
                            <tr>
                                <td class="stt"><?= $count ?></td>
                                <td class="name"><?= $item['tendanhmuc'] ?></td>
                                <td class="desc"><?= $item['mota'] ?></td>
                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/category/update/<?= $item['iddanhmuc'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= URLROOT ?>/admin/category/delete/<?= $item['iddanhmuc'] ?>" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></a>
                                    </div>
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