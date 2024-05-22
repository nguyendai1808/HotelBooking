<section class="main-section">
    <h2>Thêm Danh Mục Phòng</h2>
    <form action="<?= URLROOT ?>/admin/category/create" method="POST">
        <label for="name">Tên Danh Mục:</label><br>
        <input type="text" name="name" required><br><br>
        <button class="btn green" name="create" type="submit">Thêm mới</button>
    </form>
</section>