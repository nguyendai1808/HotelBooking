<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách đơn đặt phòng</h4>
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
                                    <form class="d-flex justify-content-center" action="<?= URLROOT ?>/admin/booking/cancelInvoice" method="post">

                                        <a href="<?= URLROOT ?>/admin/booking/detailInvoice/<?= $item['iddondat'] ?>" class="btn btn-primary text-white mx-1"><i class="fa-solid fa-eye"></i></a>

                                        <?php if ($item['trangthaidon'] == 'Đã thanh toán') : ?>

                                            <button type="submit" name="completedInvoice" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn hoàn tắt đơn đặt <?= $item['iddondat'] ?>');" formaction="<?= URLROOT ?>/admin/booking/completedInvoice" class="btn btn-success text-white mx-1">
                                                <i class="fa-solid fa-clipboard-check"></i>
                                            </button>

                                        <?php endif; ?>

                                        <?php if ($item['trangthaidon'] == 'Đã cọc tiền') : ?>

                                            <button type="submit" name="paymentBooking" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xác nhận đã thanh toán đơn đặt <?= $item['iddondat'] ?>');" formaction="<?= URLROOT ?>/admin/booking/paymentBooking" class="btn btn-success text-white mx-1">
                                                <i class="fa-solid fa-money-bill"></i>
                                            </button>

                                            <button type="submit" name="cancelInvoice" value="<?= $item['iddondat'] ?>" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn đặt <?= $item['iddondat'] ?>');" class="btn btn-danger text-white mx-1">
                                                <i class="fa-solid fa-xmark"></i>
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
    </div>
</section>