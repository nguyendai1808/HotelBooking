<?php require_once APPROOT . '/views/admin/includes/export.php'; ?>

<section class="main-section" id="booking-page">
    <div class="table-warpper">
        <div class="table-title-warpper">
            <h4 class="table-title">Danh sách đơn đặt phòng</h4>
            <button onclick="openExportDate()" class="text-secondary btn border-0"><i class="fa-solid fa-file-export"></i></button>
        </div>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> ID đơn <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Người đặt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng giá <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Đã trả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Còn thiếu <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method">Thao tác</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['bookings'])) : $stt = 1;
                        foreach ($data['bookings'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="number"><?= $item['iddondat'] ?></td>
                                <td class="name"><?= $item['tenkhachhang'] ?></td>
                                <td class="date"><?= date('d-m-Y H:i:s', strtotime($item['thoigiandat'])); ?></td>
                                <td class="number"><?= number_format($item['tongsotien'], 0, ',', '.') ?></td>
                                <td class="number"><?= number_format($item['sotiencoc'], 0, ',', '.') ?></td>
                                <td class="number"><?= number_format($item['sotienconthieu'], 0, ',', '.') ?></td>

                                <?php $color = ($item['trangthaidon'] == 'Đã hủy') ? 'danger'  : (($item['trangthaidon'] == 'Đã cọc tiền') ? 'warning' : 'success'); ?>

                                <td class="status fw-bold text-<?= $color ?>"><?= $item['trangthaidon'] ?></td>
                                <td class="method">
                                    <form class="d-flex justify-content-center" action="<?= URLROOT ?>/admin/booking/action" method="post">

                                        <a href="<?= URLROOT ?>/admin/booking/detailInvoice/<?= $item['iddondat'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if ($item['trangthaidon'] == 'Đã thanh toán') : ?>

                                            <button type="submit" name="completedInvoice" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn hoàn tất đơn đặt <?= $item['iddondat'] ?>');" class="btn btn-success text-white mx-1">
                                                <i class="fa-solid fa-clipboard-check"></i>
                                            </button>

                                        <?php endif; ?>

                                        <?php if ($item['trangthaidon'] == 'Đã cọc tiền') : ?>

                                            <button type="submit" name="paymentBooking" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xác nhận đã thanh toán đơn đặt <?= $item['iddondat'] ?>');" class="btn btn-success text-white mx-1">
                                                <i class="fa-solid fa-money-bill"></i>
                                            </button>

                                            <button type="submit" name="cancelInvoice" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt <?= $item['iddondat'] ?>');" class="btn btn-danger text-white mx-1">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>

                                        <?php endif; ?>

                                        <?php if ($item['trangthaidon'] == 'Hoàn tất') : ?>

                                            <button type="submit" name="exportPDF" value="<?= $item['iddondat'] ?>" formaction="<?= URLROOT ?>/admin/booking/exportPDF" class="btn btn-info text-white mx-1">
                                                <i class="fa-solid fa-file-invoice"></i>
                                            </button>

                                        <?php endif; ?>

                                    </form>
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
                        <li><a href="<?= URLROOT ?>/admin/booking/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/admin/booking/page/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li><a href="<?= URLROOT ?>/admin/booking/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>

        </div>
        <!-- End Pagination -->
    </div>

</section>