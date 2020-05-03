<script type="text/javascript">
	var tb_product;
	resetProduct()
	getProductEdit()
	typeList()

	$(document).ready(function() {
		// $('#code').attr('readonly', true)
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
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code"]').val(data[i].value)
					$('[name="name"]').val(data[i].name)
					$('[name="desc"]').val(data[i].keterangan)
					$('[name="typelog"]').val(data[i].jenis_id).change()
					$('[name="category"]').val(data[i].kategori_id).change()
					$('[name="qty"]').val(data[i].qtyentered)
					$('[name="unitprice"]').val(formatRupiah(data[i].unitprice))
					$('[name="budget"]').val(formatRupiah(data[i].budget))
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
		$('#typelog').on('change', function() {
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
					$('#category').empty()
					$.each(data, function(index, value) {
						if (kategori_id == value.tbl_kategori_id) {
							$('#category').append('<option value="' + value.tbl_kategori_id + '" selected>' + value.name + '</option>').change()
						} else {
							$('#category').append('<option value="' + value.tbl_kategori_id + '">' + value.name + '</option>')
						}
					})
				}
			})
		})
	}

	function resetProduct() {
		$('#resetProduct').click(function() {
			$('input[name=name]').val('')
			$('textarea').val('')
			$('.select2').val(null).trigger('change')
		})
	}
</script>