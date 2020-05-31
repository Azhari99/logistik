<script type="text/javascript">
	var tb_product;
	resetProduct()
	getProductEdit()
	typeList()

	$(document).ready(function() {
		$('#code_product').attr('readonly', true)
		$('#lqty').hide()
		$('#uprice').hide()

		tb_product = $('#table-product').DataTable({
			'ajax': '<?php echo site_url('product/getAll') ?>',
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

	function reloadProduct() {
		tb_product.ajax.reload(null, false);
	}

	function getProductEdit() {
		var product_id = $('#id_barang').val()
		$.ajax({
			url: "<?php echo site_url('product/get_product_edit'); ?>",
			type: "POST",
			data: {
				product_id: product_id
			},
			// async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_product"]').val(data[i].value)
					$('[name="name_product"]').val(data[i].name)
					$('[name="typelog_product"]').val(data[i].jenis_id).change()
					$('[name="category_product"]').val(data[i].kategori_id).change()
					$('[name="qty_product"]').val(data[i].qtyentered)
					$('[name="unitprice_product"]').val(formatRupiah(data[i].unitprice))
					$('[name="budget_product"]').val(formatRupiah(data[i].budget))
					$('[name="desc_product"]').val(data[i].keterangan)
					if (data[i].isactive === 'Y') {
						$('[name=isproduct]').attr('checked', true)
					} else {
						$('[name=isproduct]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteProduct(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('product/delete/') ?>' + id,
				dataType: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadProduct()
				}
			})
		}
	}

	function typeList() {
		$('#typelog_product').on('change', function() {
			var type_id = $(this).val()
			var kategori_id = $('#id_kategori').val()
			if (type_id != 2) {
				$('#lqty').show()
				$('#uprice').show()
				// $('#qty').attr('readonly', false)
			} else {
				$('#lqty').hide()
				$('#uprice').hide()
			}
			$.ajax({
				url: '<?php echo site_url('product/getCategory') ?>',
				type: 'POST',
				data: {
					id: type_id
				},
				dataType: 'JSON',
				success: function(data) {
					$('#category_product').empty()
					$.each(data, function(index, value) {
						if (kategori_id == value.tbl_kategori_id) {
							$('#category_product').append('<option value="' + value.tbl_kategori_id + '" selected>' + value.name + '</option>').change()
						} else {
							$('#category_product').append('<option value="' + value.tbl_kategori_id + '">' + value.name + '</option>')
						}
					})
				}
			})
		})
	}

	function resetProduct() {
		$('#resetProduct').click(function() {
			$('input[name=name_product]').val('')
			$('textarea').val('')
			$('.select2').val(null).trigger('change')
			$('#lqty').hide()
			$('#uprice').hide()
		})
	}
</script>