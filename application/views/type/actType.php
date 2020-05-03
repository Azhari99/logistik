<script type="text/javascript">
	var tb_type;
	resetType()
	getTypeEdit()

	$(document).ready(function () {
		$('#code_type').attr('readonly', true)

		tb_type = $('#table-type').DataTable({
			'ajax': '<?php echo site_url('type/getAll') ?>',
    		'processing': true,
	        'language': {
	          'processing': '<i class="fa fa-spinner fa-spin fa-10x fa-fw"></i><span> Processing...</span>'
	        },
    		'orders': [],
    		'columnDefs': [
    			{
    				'targets': -1, //last column
    				'orderable': false, //set not orderable
    			},
    		]
		})
	})
	
	function reloadType() {
  		tb_type.ajax.reload(null, false);
  	}

  	function getTypeEdit() {
  		var type_id = $('#id_jenis').val()
        $.ajax({
            url : "<?php echo site_url('type/get_type_edit');?>",
            type : "POST",
            data :{type_id :type_id},
            async : true,
            dataType : 'json',
            success : function(data){
                $.each(data, function(i, item){
                    $('[name="code"]').val(data[i].value)
                    $('[name="name"]').val(data[i].name)
                    if (data[i].isactive === 'Y') {
                    	$('[name=istype]').attr('checked', true)
                    } else {
                    	$('[name=istype]').attr('checked', false)
                    }
                })
            }
        })
  	}
	function deleteType(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('type/actDelete/') ?>'+id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
			        $.bootstrapGrowl(success_message, {
			          type: 'success',
			          width: 'auto',
			          align: 'center'
			        });
					reloadType()
				}
			})
		}
	}

	function resetType() {
		$('#resetType').click(function() {
			$('input[name=name]').val('')
		})
	}
</script>