<script type="text/javascript">
	var tb_menu;
	getMenuEdit()

	$(document).ready(function() {
		tb_menu = $('#table-menu').DataTable({
			'ajax': '<?php echo site_url('menu/getAll') ?>',
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

	function reloadMenu() {
		tb_menu.ajax.reload(null, false);
	}

	function getMenuEdit() {
		var menu_id = $('#id_menu').val()
		$.ajax({
			url: "<?php echo site_url('menu/get_menu_edit'); ?>",
			type: "POST",
			data: {
				menu_id: menu_id
			},
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="name_menu"]').val(data[i].name)
					$('[name="icon_menu"]').val(data[i].icon)
					$('[name="url_menu"]').val(data[i].url)
					$('[name="line_menu"]').val(data[i].seqno)
					if (data[i].isactive === 'Y') {
						$('[name=ismenu]').attr('checked', true)
					} else {
						$('[name=ismenu]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteMenu(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('menu/actDelete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadMenu()
				}
			})
		}
	}
</script>