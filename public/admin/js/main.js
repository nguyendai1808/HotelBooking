
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function () {
    sidebar.classList.toggle("active");
}


const search = document.querySelector('.search-box input'),
    table_rows = document.querySelectorAll('.table-content tbody tr'),
    table_headings = document.querySelectorAll('.table-content thead th');

search.addEventListener('input', searchTable);

function searchTable() {
    table_rows.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    })

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}


table_headings.forEach((head, i) => {
    let sort_asc = false;
    head.onclick = () => {
        if (!head.classList.contains('method')) { // Kiểm tra nếu không phải cột "method"
            table_headings.forEach(head => head.classList.remove('active'));
            head.classList.add('active');

            document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
            table_rows.forEach(row => {
                if (!row.querySelector('.method')) { // Bỏ qua xử lý cho cột "method"
                    row.querySelectorAll('td')[i].classList.add('active');
                }
            })
            head.classList.toggle('asc', sort_asc);
            sort_asc = head.classList.contains('asc') ? false : true;

            sortTable(i, sort_asc);
        }
    }
})

function sortTable(column, sort_asc) {
    [...table_rows].sort((a, b) => {
        let first_row = a.querySelectorAll('.table-content td')[column].textContent.toLowerCase(),
            second_row = b.querySelectorAll('.table-content td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    })
        .map(sorted_row => document.querySelector('.table-content tbody').appendChild(sorted_row));
}

document.addEventListener("DOMContentLoaded", function () {
    var links = document.querySelectorAll(".sidebar-item a");
    links.forEach(function (link) {
        link.addEventListener("click", function () {
            links.forEach(function (item) {
                item.classList.remove("active");
            });
            this.classList.add("active");
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    var dateStart = document.getElementById("dateStart");
    var dateEnd = document.getElementById("dateEnd");

    if (dateStart && dateEnd) {

        // Thêm lắng nghe sự kiện cho input ngày bắt đầu
        dateStart.addEventListener("input", function () {
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate());

            if (new Date(dateStart.value) < currentDate) {
                alert("Ngày bắt đầu phải lớn hơn ngày hôm nay ít nhất 1 ngày.");
                dateStart.value = null;
                return;
            }

            if (dateStart.value >= dateEnd.value || !dateEnd.value) {
                if (dateStart.value) {
                    var newEndDate = new Date(dateStart.value);
                    newEndDate.setDate(newEndDate.getDate() + 1);
                    dateEnd.value = newEndDate.toISOString().split("T")[0];
                }
            }
        });

        // Thêm lắng nghe sự kiện cho input ngày kết thúc
        dateEnd.addEventListener("input", function () {
            var currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 1);

            if (new Date(dateEnd.value) < currentDate) {
                alert("Ngày kết thúc phải lớn hơn ngày hôm nay ít nhất 2 ngày.");
                dateEnd.value = null;
                return;
            }

            if (dateEnd.value <= dateStart.value || !dateStart.value) {
                if (dateEnd.value) {
                    var newStartDate = new Date(dateEnd.value);
                    newStartDate.setDate(newStartDate.getDate() - 1);
                    dateStart.value = newStartDate.toISOString().split("T")[0];
                }
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const roomSelect = document.getElementById('roomSelect');
    const quantityInput = document.getElementById('quantityInput');

    if (roomSelect && quantityInput) {
        roomSelect.addEventListener('change', function () {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const maxQuantity = selectedOption.getAttribute('data-soluong');
            quantityInput.max = maxQuantity;
        });

        const initialSelectedOption = roomSelect.options[roomSelect.selectedIndex];
        quantityInput.max = initialSelectedOption.getAttribute('data-soluong');
    }

});

