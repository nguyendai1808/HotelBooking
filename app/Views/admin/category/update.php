<section class="main-section">
    <h2>Cập Nhật Danh Mục Phòng</h2>

    <?php foreach ($data['findCate'] as $item) : ?>

        <form action="<?= URLROOT ?>/admin/category/update/<?= $item['iddanhmuc'] ?>" method="POST">
            <label for="name">Tên Danh Mục:</label><br>
            <input type="text" name="name" value="<?= $item['tendanhmuc'] ?>" required><br><br>
            <button class="btn btn-success" name="update" type="submit">Cập nhật</button>
        </form>

    <?php endforeach; ?>

</section>