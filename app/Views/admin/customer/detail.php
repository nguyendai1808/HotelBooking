<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách đơn đặt phòng</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> ID đơn <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng giá <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Đã trả <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Còn thiếu <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['bookings'])) : $stt = 1;
                        foreach ($data['bookings'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="number"><?= $item['iddondat'] ?></td>
                                <td class="date"><?= date('d-m-Y H:i:s', strtotime($item['thoigiandat'])); ?></td>
                                <td class="number"><?= number_format($item['tongsotien'], 0, ',', '.') ?></td>
                                <td class="number"><?= number_format($item['sotiencoc'], 0, ',', '.') ?></td>
                                <td class="number"><?= number_format($item['sotienconthieu'], 0, ',', '.') ?></td>

                                <?php $color = ($item['trangthaidon'] == 'Đã hủy') ? 'danger'  : (($item['trangthaidon'] == 'Đã cọc tiền') ? 'warning' : 'success'); ?>

                                <td class="status text-<?= $color ?>"><?= $item['trangthaidon'] ?></td>
                            </tr>

                    <?php $stt++;
                        endforeach;
                    endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>