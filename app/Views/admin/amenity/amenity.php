<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách tiện nghi</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên tiện nghi <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/amenity/create" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['amenities'])) : $stt = 1;
                        foreach ($data['amenities'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><img src="<?= USER_PATH ?>/images/amenities/<?= !empty($item['icon']) ? $item['icon'] : 'notImage.jpg' ?>" alt="img"><?= $item['tentiennghi'] ?></td>

                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/amenity/detail/<?= $item['idtiennghi'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>
                                        <a href="<?= URLROOT ?>/admin/amenity/update/<?= $item['idtiennghi'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= URLROOT ?>/admin/amenity/delete/<?= $item['idtiennghi'] ?>" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></a>
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
    <div class="table-warpper">
        <h4 class="table-title">Danh sách giường</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên giường <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"><a href="<?= URLROOT ?>/admin/amenity/createBed" class="btn btn-success"><small class="fa-solid fa-circle-plus"></small>Thêm</a></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['beds'])) : $stt = 1;
                        foreach ($data['beds'] as $item) : ?>
                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="nameBed"><?= $item['tengiuong'] ?></td>

                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/amenity/detail/<?= $item['idgiuong'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>
                                        <a href="<?= URLROOT ?>/admin/amenity/updateBed/<?= $item['idgiuong'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="<?= URLROOT ?>/admin/amenity/deleteBed/<?= $item['idgiuong'] ?>" class="btn btn-danger text-white mx-1"><i class="fa-solid fa-trash"></i></a>
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