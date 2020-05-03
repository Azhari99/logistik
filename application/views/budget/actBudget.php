<script type="text/javascript">
	var tb_budget;
	budgetCategory()
	getBudgetEdit()

	$(document).ready(function() {
		tb_budget = $('#table-budget').DataTable({
			'ajax': '<?php echo site_url('budget/getAll') ?>',
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

	function reloadBudget() {
		tb_budget.ajax.reload(null, false);
	}

	function getBudgetEdit() {
		var budget_id = $('#id_budget').val()
		$.ajax({
			url: "<?php echo site_url('budget/get_budget_edit'); ?>",
			type: "POST",
			data: {
				budget_id: budget_id
			},
			async: true,
			dataType: 'json',
			success: function(data) {
				$.each(data, function(i, item) {
					$('[name="name"]').val(data[i].name)
					$('[name="year_budget"]').val(data[i].tahun)
					$('[name="typelog"]').val(data[i].jenis_id).change()
					$('[name="an_budget"]').val(formatRupiah(data[i].budget))
					$('[name="desc"]').val(data[i].keterangan)
					if (data[i].isactive === 'Y') {
						$('[name=isbudget]').attr('checked', true)
					} else {
						$('[name=isbudget]').attr('checked', false)
					}
				})
			}
		})
	}

	function deleteCategory(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('budget/actDelete/') ?>' + id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
					$.bootstrapGrowl(success_message, {
						type: 'success',
						width: 'auto',
						align: 'center'
					});
					reloadBudget()
				}
			})
		}
	}

	function doPeriode(id) {
		var url = '<?= site_url('budget/getDetail') ?>';
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				id: id
			},
			dataType: 'JSON',
			success: function(data) {
				if (data.status == 'O') {
					var status = 'C';
					if (confirm("Apakah data akan diclose ?")) {
						$.ajax({
							url: '<?php echo site_url('budget/actPeriode') ?>',
							type: 'POST',
							data: {
								id: id,
								status: status
							},
							dataType: 'JSON',
							success: function(result) {
								var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil diclose !';
								$.bootstrapGrowl(success_message, {
									type: 'success',
									width: 'auto',
									align: 'center'
								});
								reloadBudget()
							}
						})
					}
				} else {
					var status = 'O';
					if (confirm("Apakah data akan diopen ?")) {
						$.ajax({
							url: '<?php echo site_url('budget/actPeriode') ?>',
							type: 'POST',
							data: {
								id: id,
								status: status
							},
							dataType: 'JSON',
							success: function(result) {
								var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil diopen !';
								$.bootstrapGrowl(success_message, {
									type: 'success',
									width: 'auto',
									align: 'center'
								});
								reloadBudget()
								// console.log(result)
							}
						})
					}
				}
			}
		})
	}

	function budgetCategory() {
		$('#resetBudget').click(function() {
			$('input[name=name]').val('')
			$('input[name=an_budget]').val('')
			$('.select2').val(null).trigger('change')
			$('textarea').val('')
			$('#year_budget').datepicker('setDate', new Date($.now()))
		})
	}
</script>