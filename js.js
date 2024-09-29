document.addEventListener('DOMContentLoaded', function() {
    var searchBox = document.getElementById('course-search');
    var tables = document.querySelectorAll('.course-table .table-container');
    var searchTimer;

    searchBox.addEventListener('input', function() {
        clearTimeout(searchTimer);
        var searchValue = searchBox.value.trim().toLowerCase();

        searchTimer = setTimeout(function() {
            var found = false;

            tables.forEach(function(table) {
                var rows = table.querySelectorAll('table tbody tr');

                rows.forEach(function(row, rowIndex) {
                    if (rowIndex !== 0) {
                        var rowVisible = false;
                        var cells = row.querySelectorAll('td');

                        cells.forEach(function(cell, cellIndex) {
                            var cellText = cell.textContent.trim().toLowerCase();
                            if (cellText.includes(searchValue)) {
                                rowVisible = true;
                                found = true;
                            }
                        });

                        row.style.display = rowVisible ? '' : 'none';
                    } else {
                        row.style.display = '';
                    }
                });

                var tableVisible = Array.from(rows).some(function(row, rowIndex) {
                    return rowIndex !== 0 && row.style.display !== 'none';
                });

                table.style.display = tableVisible ? '' : 'none';
            });

            if (!found && searchValue !== '') {
                alert('No matching results found.');
            }
        }, 700);
    });
});