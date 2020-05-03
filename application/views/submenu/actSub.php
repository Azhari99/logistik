<script type="text/javascript">
	var tb_submenu;
	getSubEdit()

	$(document).ready(function() {
		tb_submenu = $('#table-submenu').DataTable({
			'ajax': '<?php echo site_url('submenu/getAll') ?>',
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

	function reloadSubmenu() {
		tb_submenu.ajax.reload(null, false);
	}

	function getSubEdit() {
		var sub_id = $('#id_sub').val()
		$.ajax({
			url: "<?php echo site_url('submenu/get_sub_edit'); ?>",
			type: "POST",
			data: {
				sub_id: sub_id
			},
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="name_sub"]').val(data[i].name)
					$('[name="menu_id"]').val(data[i].tbl_menu_id).change()
					$('[name="url_sub"]').val(data[i].url)
					$('[name="icon_sub"]').val(data[i].icon)
					$('[name="line_sub"]').val(data[i].seqno)
					if (data[i].isactive === 'Y') {
						$('[name=issub]').attr('checked', true)
					} else {
						$('[name=issub]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteSub(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('submenu/actDelete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadSubmenu()
				}
			})
		}
	}
</script>