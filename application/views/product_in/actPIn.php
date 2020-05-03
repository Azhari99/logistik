<script type="text/javascript">
	var tb_product_in;
	resetProductIn()
	getProductIn()
	getPrice()

	$(document).ready(function() {
		$('#code_in').attr('readonly', true)

		tb_product_in = $('#table-product-in').DataTable({
			'ajax': '<?php echo site_url('productin/getAll') ?>',
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

	function reloadProductIn() {
		tb_product_in.ajax.reload(null, false);
	}

	function getPrice() {
		var pageUrl = window.location.href;
		var add = pageUrl.includes('add');
		var actAdd = pageUrl.includes('actAdd');

		$('#product_in').on('change', function() {
			var product_id = $(this).val();
			$.ajax({
				url: '<?php echo site_url('product/getProductType') ?>',
				type: 'POST',
				data: {
					id: product_id
				},
				dataType: 'JSON',
				success: function(data) {
					if (data !== null) {
						$('#unitprice_in').attr('readonly', true)
						$('#total_in').attr('readonly', true)
						// $('[name=unitprice_in]').val(formatRupiah(data.unitprice))
						if (add === true || actAdd === true) {
							$('[name=unitprice_in]').val(formatRupiah(data.unitprice))
						} else {
							$('#product_in').on('change', function() {
								var id = $(this).val()
								$.ajax({
									url: '<?php echo site_url('product/getProductType') ?>',
									type: 'POST',
									data: {
										id: id
									},
									dataType: 'JSON',
									success: function(result) {
										$('[name=unitprice_in]').val(formatRupiah(result.unitprice))
									}
								})
							})
						}
					} else {
						$('[name=unitprice_in]').val('')
						$('[name=total_in]').val('')
						$('#unitprice_in').attr('readonly', false)
						$('#total_in').attr('readonly', false)
					}
					$('#qty_in').on('click keyup', function() {
						var qty = $(this).val()
						var total = (qty * data.unitprice)
						$('[name=total_in]').val(formatRupiah(total))
					})
				}
			})
		})
	}

	function getProductIn() {
		var product_in_id = $('#id_barang_in').val()
		$.ajax({
			url: "<?php echo site_url('productin/get_data_edit'); ?>",
			method: 'POST',
			data: {
				id: product_in_id
			},
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_in"]').val(data[i].documentno)
					$('[name="product_in"]').val(data[i].tbl_barang_id).change()
					$('[name="datetrx_in"]').val(formatDate(data[i].datetrx))
					$('[name="qty_in"]').val(data[i].qtyentered)
					$('[name="unitprice_in"]').val(formatRupiah(data[i].unitprice))
					$('[name="desc_in"]').val(data[i].keterangan)
					$('[name="total_in"]').val(formatRupiah(data[i].amount))
				})
			}
		})
	}

	function completeProductIn(id) {
		if (confirm("Apakah data akan di complete ?")) {
			$.ajax({
				url: '<?php echo site_url('productin/actComplete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					if (data.success) {
						var success_msg = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil di complete !';
						$.bootstrapGrowl(success_msg, {
							type: 'success',
							width: 'auto',
							align: 'center'
						})
						reloadProductIn()
					} else if (data.error_qty) {
						var error_msg = '<h4><i class="icon fa fa-ban"></i> Gagal !</h4> Quantity yang dimasukan tidak boleh: ' + data.error_qty;
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

	function detailProductIn(id) {
		$('#product_in_detail input, textarea').attr('readonly', true)
		$.ajax({
			url: "<?php echo site_url('productin/get_data_edit'); ?>",
			method: 'POST',
			data: {
				id: id
			},
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_in"]').val(data[i].documentno)
					$('[name="product_in"]').val(data[i].barang)
					$('[name="datetrx_in"]').val(formatDate(data[i].datetrx))
					$('[name="qty_in"]').val(data[i].qtyentered)
					$('[name="unitprice_in"]').val(formatRupiah(data[i].unitprice))
					$('[name="desc_in"]').val(data[i].keterangan)
					$('[name="total_in"]').val(formatRupiah(data[i].amount))
					$('[name="status"]').val('Completed')
				})
				$('.modal-title').text('Detail Product In')
				$('#modal_product_in').modal({
					backdrop: 'static',
					keyboard: false
				})
			}
		})
	}

	function deleteProductIn(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('productin/delete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					})
					reloadProductIn()
				}
			})
		}
	}

	function resetProductIn() {
		$('#resetProductIn').click(function() {
			$('.select2').val(null).trigger('change')
			$('input[name=qty_in]').val('')
			$('textarea').val('')
			$('input[name=total_in]').val('')
			$('#datetrx_in').datepicker('setDate', new Date($.now()))
		})
	}
</script>