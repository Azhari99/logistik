<script type="text/javascript">
	var tb_category;
	resetCategory()
	getCategoryEdit()

	$(document).ready(function() {
		$('#code_cat').attr('readonly', true)

		tb_category = $('#table-category').DataTable({
			'ajax': '<?php echo site_url('category/getAll') ?>',
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

	function reloadCategory() {
		tb_category.ajax.reload(null, false);
	}

	function getCategoryEdit() {
		var category_id = $('#id_kategori').val()
		$.ajax({
			url: "<?php echo site_url('category/get_category_edit'); ?>",
			type: "POST",
			data: {
				category_id: category_id
			},
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="code_cat"]').val(data[i].value)
					$('[name="name_cat"]').val(data[i].name)
					$('[name="typelog_cat"]').val(data[i].jenis_id).change()
					if (data[i].isactive === 'Y') {
						$('[name=iscategory]').attr('checked', true)
					} else {
						$('[name=iscategory]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteCategory(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('category/actDelete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadCategory()
				}
			})
		}
	}

	function resetCategory() {
		$('#resetCategory').click(function() {
			$('input[name=name_cat]').val('')
			$('.select2').val(null).trigger('change')
		})
	}
</script>