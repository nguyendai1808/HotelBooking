<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Chi tiết đơn đặt phòng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> ID đơn <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Tên phòng - giường <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date-long"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Số lượng <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Giá phòng <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng giá <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>

                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['bookings'])) : $stt = 1;
                        foreach ($data['bookings'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="number"><?= $item['iddondat'] ?></td>
                                <td class="name"><?= trim($item['tenphong'] . ' - ' . $item['tengiuong']) ?></td>
                                <td class="date-long"><?= date('d-m-Y', strtotime($item['ngayden'])) ?><i class="bi bi-arrow-right-short mx-1"></i><?= date('d-m-Y', strtotime($item['ngaydi'])) ?></td>
                                <td class="number"><?= $item['soluongdat'] ?></td>
                                <td class="number"><?= number_format($item['giaphong'], 0, ',', '.') ?></td>
                                <td class="number"><?= number_format($item['tonggia'], 0, ',', '.') ?></td>

                                <?php $color = ($item['trangthaidat'] == 'Đã hủy') ? 'danger'  : (($item['trangthaidat'] == 'Đã cọc tiền') ? 'warning' : 'success'); ?>
                                <td class="status text-<?= $color ?>"><?= $item['trangthaidat'] ?></td>
                            </tr>

                    <?php $stt++;
                        endforeach;
                    endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>