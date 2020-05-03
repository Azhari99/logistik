<script type="text/javascript">
	var tb_institute;
	getInstituteEdit()
	numberOnly()
	
	$(document).ready(function() {
		$('#code_institute').attr('readonly', true)

		tb_institute = $('#table-institute').DataTable({
			'ajax': '<?php echo site_url('institute/getAll') ?>',
			'processing': true,
			'language': {
				'processing': '<i class="fa fa-spinner fa-spin fa-10x fa-fw"></i><span> Processing...</span>'
			},
			'orders': [],
			'columnDefs': [{
				'targets': -1, //last column
				'orderable': false, //set not orderable
			}, ]
		})
	})

	function reloadInstitute() {
		tb_institute.ajax.reload(null, false);
	}

	function getInstituteEdit() {
		var institute_id = $('#id_instansi').val()
		$.ajax({
			url: "<?php echo site_url('institute/get_institute_edit'); ?>",
			type: "POST",
			data: {
				institute_id: institute_id
			},
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code"]').val(data[i].value)
					$('[name="name"]').val(data[i].name)
					$('[name="address"]').val(data[i].address)
					$('[name="email"]').val(data[i].email)
					$('[name="phone"]').val(data[i].phone)
					$('[name="budget_ins"]').val(formatRupiah(data[i].budget))
					if (data[i].isactive === 'Y') {
						$('[name=isinsti]').attr('checked', true)
					} else {
						$('[name=isinsti]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteInstitute(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('institute/actDelete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadInstitute()
				}
			})
		}
	}

	function numberOnly() {
		$('#phone').keypress(function(event) { //Required Number
			var keycode = event.which;
			if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
				event.preventDefault();
			}
		});
	}
</script>