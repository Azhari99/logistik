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
	doChangePass()

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

		$('#saveChange').on('click', function() {
			var url = '<?php echo site_url('users/changePass') ?>';

			$.ajax({
				url: url,
				method: 'POST',
				data: $('#form_change_pass').serialize(),
				dataType: 'JSON',
				success: function(data) {
					if (data.error) {
						if (data.pass_old_error != '') {
							$('#pass_old_error').html(data.pass_old_error)
						}
						if (data.pass_new_error != '') {
							$('#pass_new_error').html(data.pass_new_error)
						}
						if (data.pass_conf_error != '') {
							$('#pass_conf_error').html(data.pass_conf_error)
						}
					}
					if (data.success) {
						var success_msg = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Password berhasil diubah !';
						$.bootstrapGrowl(success_msg, {
							type: 'success',
							width: 'auto',
							align: 'center'
						})
						$('#modal_change_pass').modal('hide')
						$('#form_change_pass')[0].reset()
						$('#pass_old_error').html('')
						$('#pass_new_error').html('')
						$('#pass_conf_error').html('')
					}
				}
			})
		})
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

	function doChangePass() {
		$('#changePass').on('click', function() {
			$('.modal-title').text('Change Password')
			$('#modal_change_pass').modal({
				backdrop: 'static',
				keyboard: false
			})
		})
	}

	function doShowProfile(id) {
		$.ajax({
			url: '<?php echo site_url('users/get_users_edit') ?>',
			method: 'POST',
			data: {
				user_id: id
			},
			dataType: 'JSON',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="show_username"]').val(data[i].value)
					$('[name="show_name"]').val(data[i].name)
					$('[name="show_password"]').val(data[i].password)
				})
				$('[name="show_username"]').prop('readonly', true)
				$('[name="show_name"]').prop('readonly', true)
				$('[name="show_password"]').prop('readonly', true)
				$('[name="show_active"]').prop('disabled', true)
				$('[name="show_active"]').prop('checked', true)
				$('.modal-title').text('Show Profile')
				$('#modal_show_profile').modal({
					backdrop: 'static',
					keyboard: false
				})
			}
		})
	}
</script>