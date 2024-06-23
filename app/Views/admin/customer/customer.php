<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách khách hàng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="email"> Email <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Số đơn <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng tiền <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method">Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['customers'])) : $stt = 1;
                        foreach ($data['customers'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><?= $item['hoten'] ?></td>
                                <td class="email"><?= $item['email'] ?></td>
                                <td class="number"><?= $item['sodon'] ?></td>
                                <td class="number"><?= $item['tongtien'] ?></td>
                                <td class="method">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= URLROOT ?>/admin/customer/detail/<?= $item['idkhachhang'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>
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