function toggleFilterOptions() {
    $('#filterOptions').toggle();
}
function applyFilter() {
    var filterValue = $('#filter').val();
    var filterColumn = $('#filterColumn').val();

    $.ajax({
        url: config.filteredItemsUrl,
        method: 'POST',
        data: {filter: filterValue, column: filterColumn},
        dataType: 'json',
        success: function (data) {
            updateTable(data);
        },
        error: function (error) {
            console.error('Chyba pri filtrovaní dát:', error);
        }
    });
}

function clearFilter() {
    // vycisti hodnoty filtra
    $('#filter').val('');
    $('#filterColumn').val('');

    // ziskaj vsetky data bez filtra
    $.ajax({
        url: config.allItemsUrl,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            updateTable(data);
        },
        error: function (error) {
            console.error('Chyba pri získavaní všetkých dát:', error);
        }
    });
}

