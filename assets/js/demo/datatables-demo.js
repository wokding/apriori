// Call the dataTables jQuery plugin
$(document).ready(function() {
  // Check if dataTable is not already initialized to prevent reinitialize error
  if (!$.fn.DataTable.isDataTable('#dataTable')) {
    $('#dataTable').DataTable({
      "pageLength": 10,
      "ordering": true,
      "info": true,
      "responsive": {
        details: {
          type: 'column',
          target: 'tr'
        }
      },
      "destroy": true,
      "autoWidth": false,
      "scrollX": true,
      "language": {
        "search": "<i class='fas fa-search mr-2'></i>Search:",
        "lengthMenu": "Show _MENU_ entries per page",
        "info": "<i class='fas fa-info-circle mr-2'></i>Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries",
        "infoEmpty": "<i class='fas fa-inbox mr-2'></i>No entries available",
        "infoFiltered": "(filtered from <strong>_MAX_</strong> total entries)",
        "loadingRecords": "<i class='fas fa-spinner fa-spin mr-2'></i>Loading...",
        "processing": "<i class='fas fa-spinner fa-spin mr-2'></i>Processing...",
        "zeroRecords": "<i class='fas fa-search mr-2'></i>No matching records found",
        "paginate": {
          "first": "<i class='fas fa-angle-double-left'></i>",
          "last": "<i class='fas fa-angle-double-right'></i>",
          "next": "<i class='fas fa-angle-right'></i>",
          "previous": "<i class='fas fa-angle-left'></i>"
        },
        "aria": {
          "sortAscending": ": activate to sort column ascending",
          "sortDescending": ": activate to sort column descending"
        }
      },
      "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      "initComplete": function() {
        // Add custom styling after initialization
        $('.dataTables_filter input').addClass('form-control form-control-sm').attr('placeholder', 'Type to search...');
        $('.dataTables_length select').addClass('form-control form-control-sm');
        // Ensure responsive layout recalculates when inside tabs/modals
        this.api().columns.adjust().responsive.recalc();
      }
    });
  }
});
