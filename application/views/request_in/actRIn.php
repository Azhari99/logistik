<script type="text/javascript">
	var tb_request_in;
	resetProductRIn()
	// getProductRIn()

	$(document).ready(function() {
		tb_request_in = $('#table-request-in').DataTable({
			'ajax': '<?php echo site_url('requestin/getAll') ?>',
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

	function reloadProductRIn() {
		tb_request_in.ajax.reload(null, false);
	}

	function getProductRIn() {
		var request_in_id = $('#request_in_id').val()
		$.ajax({
			url: "<?php echo site_url('requestin/get_data_edit'); ?>",
			method: 'POST',
			data: {
				id: request_in_id
			},
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_out"]').val(data[i].documentno)
					$('[name="request_in"]').val(data[i].tbl_barang_id).change()
					$('[name="datetrx_out"]').val(formatDate(data[i].datetrx))
					$('[name="institute_out"]').val(data[i].tbl_instansi_id).change()
					$('[name="qty_out"]').val(data[i].qtyentered)
					$('[name="desc_out"]').val(data[i].keterangan)
				})
			}
		})
	}

	function completeProductRIn(id) {
		console.log(id);
		if (confirm("Apakah data akan di complete ?")) {
			$.ajax({
				url: '<?php echo site_url('requestin/actComplete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					if (data.success) {
						var success_msg = '<h4><i class="icon fa fa-info"></i> Sukses !</h4> Data berhasil di complete !';
						$.bootstrapGrowl(success_msg, {
							type: 'success',
							width: 'auto',
							align: 'center'
						})
						reloadProductRIn()
					} else {
						var error_msg = '<h4><i class="icon fa fa-ban"></i> Gagal !</h4> Data tidak dapat di complete,' + data.error;
						$.bootstrapGrowl(error_msg, {
							type: 'danger',
							width: 'auto',
							align: 'center'
						})
					}
				}
			})
		}
	}

	function detailRequestIn(id) {
		$('#form_request_in input, textarea').attr('readonly', true)
		$.ajax({
			url: "<?php echo site_url('requestin/get_data_edit'); ?>",
			method: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_req"]').val(data[i].documentno)
					$('[name="product_req"]').val(data[i].barang)
					$('[name="institute_req"]').val(data[i].instansi)
					$('[name="datetrx_req"]').val(formatDate(data[i].datetrx))
					$('[name="qty_req"]').val(data[i].qtyentered)
					$('[name="unitprice_req"]').val(formatRupiah(data[i].unitprice))
					$('[name="total_req"]').val(formatRupiah(data[i].amount))
					$('[name="budget_req"]').val(formatRupiah(data[i].amount))
					$('[name="desc_req"]').val(data[i].keterangan)
					$('[name="status_req"]').val('Completed')
				})
				$('.modal-title').text('Detail Request In')
				$('#modal_request_in').modal({
					backdrop: 'static',
					keyboard: false
				})
			}
		})
	}

	function resetProductRIn() {
		$('#resetProductRIn').click(function() {
			$('.select2').val(null).trigger('change')
			$('input[name=qty_out]').val('')
			$('textarea').val('')
			$('input[name=amount]').val('')
			$('#datetrx').datepicker('setDate', new Date($.now()))
		})
		
	}
</script>