<section class="main-section">
    <div class="table-warpper">
        <h4 class="table-title">Danh sách đánh giá</h4>
        <div class="table-content">
            <table>
                <thead>
                    <tr>
                        <th class="stt"> Stt <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="name"> Họ tên <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="desc"> Nội dung <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="date"> Thời gian <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="number"> Tổng điểm <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="status"> Trạng thái <i class="fa-solid fa-arrow-up"></i></th>
                        <th class="method"> Thao tác </th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($data['ratings'])) : $stt = 1;
                        foreach ($data['ratings'] as $item) : ?>

                            <tr>
                                <td class="stt"><?= $stt ?></td>
                                <td class="name"><img src="<?= USER_PATH ?>/images/avatars/<?= !empty($item['anh']) ? $item['anh'] : 'user.png' ?>" alt="img"><?= trim($item['ho'] . ' ' . $item['ten']) ?></td>
                                <td class="desc"><?= $item['noidung'] ?></td>
                                <td class="date"><?= date('d-m-Y', strtotime($item['thoigian']))  ?></td>
                                <td class="number"><?= round($item['tongdiem'], 1) ?></td>
                                <td class="status">
                                    <p class="status"><?= $item['trangthai'] ?></p>
                                </td>
                                <td class="method">
                                    <form class="d-flex justify-content-center" method="post" action="<?= URLROOT ?>/admin/rating/action">
                                        <button name="detail" value="<?= $item['id_phong'] ?>" class="btn btn-primary text-white mx-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <?php if ($item['trangthai'] == 'Website') : ?>
                                            <button name="display" value="<?= $item['iddanhgia'] ?>" onclick="return confirm('Bạn có chắc chắn muốn chuyển về hiển thị');" class="btn btn-info text-white mx-1">
                                                <i class="fa-solid fa-display"></i>
                                            </button>
                                        <?php else : ?>
                                            <button name="website" value="<?= $item['iddanhgia'] ?>" onclick="return confirm('Bạn có chắc chắn muốn cho bình luận này hiển thị lên trang web');" class="btn btn-info text-white mx-1">
                                                <i class="fa-solid fa-globe"></i>
                                            </button>
                                        <?php endif; ?>

                                        <button name="delete" value="<?= $item['iddanhgia'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này');" class="btn btn-danger text-white mx-1">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
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
                        <li><a href="<?= URLROOT ?>/admin/rating/page/1"><i class="fa-solid fa-angles-left"></i></a></li>
                    <?php endif; ?>

                    <?php for ($i = $start; $i <= $end; $i++) : ?>
                        <li><a <?= $i == $current_page ? 'class="active"' : '' ?> href="<?= URLROOT ?>/admin/rating/page/<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li><a href="<?= URLROOT ?>/admin/rating/page/<?= $total_pages ?>"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php endif; ?>
                </ul>

            <?php endif; ?>

        </div>
        <!-- End Pagination -->

    </div>

</section>