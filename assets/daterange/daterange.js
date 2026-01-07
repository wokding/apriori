$('.daterange').daterangepicker({
  alwaysShowCalendars: true,
  showDropdowns: true,
  opens: "right",
  locale: { 
    format: "YYYY-MM-DD",
    separator: " - ",
    applyLabel: "Apply",
    cancelLabel: "Cancel",
    fromLabel: "From",
    toLabel: "To",
    customRangeLabel: "Custom",
    weekLabel: "W",
    daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
    monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    firstDay: 1
  },
  autoApply: true,
  // Tidak ada maxSpan - bisa pilih berapa lama pun
  ranges: {
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'Last 3 Months': [moment().subtract(3, 'months'), moment()],
    'Last 6 Months': [moment().subtract(6, 'months'), moment()],
    'Last 1 Year': [moment().subtract(1, 'years'), moment()],
    'Last 2 Years': [moment().subtract(2, 'years'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    'All Time': [moment().subtract(10, 'years'), moment()]
  },
  startDate: moment().subtract(29, 'days'),
  endDate: moment(),
  minDate: moment().subtract(10, 'years'), // Bisa pilih sampai 10 tahun ke belakang
  maxDate: moment() // Maksimal hari ini
}, function (start, end) {
  $('.daterange-span').text(start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD"));
});
