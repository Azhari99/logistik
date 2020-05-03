<script type="text/javascript">
	var tb_request_in;
	resetProductRIn()
	numberOnlyOut()
	getProductRIn()
	numberMin()
    
	$(document).ready(function () {
		$('#code_out').attr('readonly', true)

		tb_request_in = $('#table-request-in').DataTable({
			'ajax': '<?php echo site_url('requestin/getAll') ?>',
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

		$('#request_in').on('change', function() {
			var product_id = $(this).val()
			$.ajax({
				url: '<?php echo site_url('product/getProductType')?>',
				type: 'POST',
				data: {id:product_id},
				dataType: 'JSON',
				success: function(data) {
					if (data !== null) {
                        //console.log(data.tbl_jenis_id);
						if (data.type == 'Anggaran' || data.tbl_jenis_id == 2) {
							$('#qty_out').attr('readonly', true)
							$('[name=qty_out]').val(0)
						} else {
							$('#qty_out').attr('readonly', false)
						}
					} else {
						$('#qty_out').attr('readonly', false)
					}
				}
			})
		})
	})
	
	function reloadProductRIn() {
  		tb_request_in.ajax.reload(null, false);
  	}

  	function getProductRIn(){
        var request_in_id = $('#request_in_id').val()
        $.ajax({
            url : "<?php echo site_url('requestin/get_data_edit');?>",
            method : 'POST',
            data :{id :request_in_id},
            dataType : 'json',
            success : function(data){
                $.each(data, function(i, item){
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
				url: '<?php echo site_url('requestin/actComplete/') ?>'+id,
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
						var error_msg = '<h4><i class="icon fa fa-ban"></i> Gagal !</h4> Data tidak dapat di complete,'+data.error;
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

	function deleteProductRIn(id) {
		if (confirm("Apakah data akan dihapus ?")) {
			$.ajax({
				url: '<?php echo site_url('requestin/delete/') ?>'+id,
				type: 'POST',
				dataType: 'JSON',
				success: function(data) {
					var success_message = '<h4><i class="icon fa fa-info"></i> Sukses!</h4> Data berhasil dihapus !';
			        $.bootstrapGrowl(success_message, {
			          type: 'success',
			          width: 'auto',
			          align: 'center'
			        });
					reloadProductRIn()
				}
			})
		}
	}

	function numberOnlyOut() {
		$('#amount_out').keypress(function (event){ //Required Number
		  var keycode = event.which;
		  if(!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57 )))){
		    event.preventDefault();
		  }
		});
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