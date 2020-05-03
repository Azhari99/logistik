<!-- jQuery -->
<script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- Datatables -->
<script src="<?php echo base_url('assets/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/vendors/select2/js/select2.full.min.js') ?>"></script>
<!-- Bootstrap-Growl -->
<script src="<?php echo base_url('assets/vendors/bootstrap-growl/js/jquery.bootstrap-growl.min.js') ?>"></script>
<!-- Custom Theme Scripts -->
<script src="<?php echo base_url('assets/build/js/custom.js') ?>"></script>
<!-- bootstrap-datepicker -->
<script src="<?php echo base_url('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
<!-- autoNumeric -->
<script src="<?php echo base_url('assets/vendors/auto-numeric/autoNumeric.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2()

		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			todayBtn: true,
			orientation: "bottom auto",
			autoclose: true
		})

		$('.yearpicker').datepicker({
			format: 'yyyy',
			viewMode: 'years',
			minViewMode: 'years',
			orientation: 'bottom auto',
			autoclose: true
		})

		$('.rupiah').autoNumeric('init') //inisialisasi currency rupiah
		numberMin()
	})

	function alertComplete() {
		alert('Document No ini sudah completed')
	}

	function numberMin() {
		$('input[type="number"]').on('input', function() {
			var value = $(this).val();
			if ((value !== '')) {
				$(this).val(Math.max(value, 0));
			} else if ((value == '')) {
				$(this).val(0);
			}
		});
	}

	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		return [day, month, year].join('/');
	}

	function formatRupiah(angka) {
		var number_string = angka.toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.'); //penambahan separator titik setelah bilangan satuan
		}

		return rupiah ? 'Rp.' + rupiah + ',' + '00' : '';
	}
</script>