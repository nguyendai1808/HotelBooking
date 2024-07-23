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
                                <td class="number"><?= number_format($item['tongtien'], 0, ',', '.') ?></td>
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
        <!-- Start Pagination -->
        <div class="page-pagination" id="pagination-links">

            <?php if (isset($data['pagination'])) : extract($data['pagination']);
                $start = max($current_page - 1, 1);
                $end = min($start + 2, $total_pages);

                if ($current_page == $total_pages && $start > 1) :
                    $start--;
                endif; ?>

                <ul>
                    <?php if ($current_page > 1) : ?>
                        <li><a href="<?= URLROOT ?>/admin/customer/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/admin/customer/page/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li><a href="<?= URLROOT ?>/admin/customer/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>

        </div>
        <!-- End Pagination -->
    </div>
</section>