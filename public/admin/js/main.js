//login
function showpass() {
    document.getElementById('eye-open').style.display = "block";
    document.getElementById('eye-close').style.display = "none";
    document.getElementById('eye-pass').type = "text";
}
function hiddenpass() {
    document.getElementById('eye-open').style.display = "none";
    document.getElementById('eye-close').style.display = "block";
    document.getElementById('eye-pass').type = "password";
}


let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function () {
    sidebar.classList.toggle("active");
}


const search = document.querySelector('.search-box input'),
    table_rows = document.querySelectorAll('.table-content tbody tr'),
    table_headings = document.querySelectorAll('.table-content thead th');

// 1. Searching for specific data of HTML table
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

// 2. Sorting | Ordering data of HTML table

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
            // Remove active class from all links
            links.forEach(function (item) {
                item.classList.remove("active");
            });
            // Add active class to the clicked link
            this.classList.add("active");
        });
    });
});
