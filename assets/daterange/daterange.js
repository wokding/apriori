// Gunakan 2 input date HTML5 untuk semua device
var $input = $('.daterange');
var $wrapper = $input.parent();

// Ambil nilai range yang ada
var currentRange = $input.val().split(' - ');
var startDate = currentRange[0] || moment().subtract(29, 'days').format('YYYY-MM-DD');
var endDate = currentRange[1] || moment().format('YYYY-MM-DD');

// Sembunyikan input asli
$input.hide();

// Tambahkan 2 input date dengan wrapper untuk positioning icon
$wrapper.append(`
  <div class="mobile-daterange">
    <div class="row">
      <div class="col-md-6 col-6 mb-2">
        <label class="small font-weight-bold">Start Date</label>
        <div class="date-input-wrapper">
          <input type="date" class="form-control date-with-icon" id="mobile-start-date" value="${startDate}" max="${moment().format('YYYY-MM-DD')}">
          <i class="fas fa-calendar-alt date-icon"></i>
        </div>
      </div>
      <div class="col-md-6 col-6 mb-2">
        <label class="small font-weight-bold">End Date</label>
        <div class="date-input-wrapper">
          <input type="date" class="form-control date-with-icon" id="mobile-end-date" value="${endDate}" max="${moment().format('YYYY-MM-DD')}">
          <i class="fas fa-calendar-alt date-icon"></i>
        </div>
      </div>
    </div>
    <div class="mt-2">
      <button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-days="7">7 Days</button>
      <button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-days="30">1 Month</button>
      <button type="button" class="btn btn-sm btn-outline-primary mr-1 mb-1" data-days="90">3 Months</button>
      <button type="button" class="btn btn-sm btn-outline-primary mb-1" data-days="365">1 Year</button>
    </div>
  </div>
`);

// Update hidden input saat tanggal berubah
function updateRange() {
  var start = $('#mobile-start-date').val();
  var end = $('#mobile-end-date').val();
  if (start && end) {
    $input.val(start + ' - ' + end);
  }
}

// Set initial value
updateRange();

// Event listeners
$('#mobile-start-date, #mobile-end-date').on('change', updateRange);

// Icon calendar bisa diklik untuk membuka date picker
$('.date-icon').on('click', function() {
  $(this).siblings('input[type="date"]').focus().click();
});

// Quick select buttons
$('.mobile-daterange button').on('click', function() {
  var days = $(this).data('days');
  var end = moment().format('YYYY-MM-DD');
  var start = moment().subtract(days - 1, 'days').format('YYYY-MM-DD');
  $('#mobile-start-date').val(start);
  $('#mobile-end-date').val(end);
  updateRange();
  $(this).addClass('active').siblings().removeClass('active');
});
