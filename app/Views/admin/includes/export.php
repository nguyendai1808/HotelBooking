<section class="export-date" id="export-date">
    <form id="export-date-form" method="post" onsubmit="return exportFile()">
        <div class="date-content row">
            <span class="close-date"><i class="fa-solid fa-xmark" onclick="closeExportDate()"></i></span>
            <div class="col-lg-4 mb-2">
                <div class="date">
                    <label for="">Từ</label>
                    <input type="date" name="start" class="form-control" id="start-date" />
                </div>
            </div>
            <div class="col-lg-4 mb-2">
                <div class="date">
                    <label for="">Đến</label>
                    <input type="date" name="end" class="form-control" id="end-date" />
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <div class="export">
                    <button class="btn-export" type="submit" name="export">Xuất file</button>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    function openExportDate() {
        var exportFile = document.getElementById("export-date");
        exportFile.style.display = "block";
    }

    document.addEventListener("DOMContentLoaded", function() {
        var startDate = document.getElementById("start-date");
        var endDate = document.getElementById("end-date");
        if (startDate && endDate) {

            startDate.addEventListener("input", function() {

                var currentDate = new Date();
                currentDate.setDate(currentDate.getDate() - 1);

                if (new Date(startDate.value) > currentDate) {
                    alert("Thời gian bắt đầu phải nhỏ hơn ngày hiện tại");
                    startDate.value = null;
                    return;
                }

                if (startDate.value >= endDate.value || !endDate.value) {
                    if (startDate.value) {
                        var newEndDate = new Date(startDate.value);
                        newEndDate.setDate(newEndDate.getDate() + 1);
                        endDate.value = newEndDate.toISOString().split("T")[0];
                    }

                }
            });

            // Thêm lắng nghe sự kiện cho input ngày đi
            endDate.addEventListener("input", function() {

                var currentDate = new Date();
                currentDate.setDate(currentDate.getDate());

                if (new Date(endDate.value) > currentDate) {
                    alert("Thống kê không vượt quá ngày hiện tại");
                    endDate.value = null;
                    return;
                }

                if (endDate.value <= startDate.value || !startDate.value) {
                    if (endDate.value) {
                        var newStartDate = new Date(endDate.value);
                        newStartDate.setDate(newStartDate.getDate() - 1);
                        startDate.value = newStartDate.toISOString().split("T")[0];
                    }

                }
            });
        }

    });

    function closeExportDate() {
        document.getElementById("export-date").style.display = "none";
    }

    function exportFile() {
        var start = document.getElementById("start-date").value;
        var end = document.getElementById("end-date").value;

        if (start == '' || end == '') {
            alert("Hãy chọn đủ thời gian");
            return false;
        } else {
            var form = document.getElementById('export-date-form');
            if (form) {
                form.action = URLROOT + '/admin/home/exportExcel';
                closeExportDate();
                document.getElementById("loader").remove();
                return true;
            } else {
                return false;
            }
        }
    }
</script>