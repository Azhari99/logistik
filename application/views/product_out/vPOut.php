<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Out</h2>
            <p class="navbar-right"><a href="<?php echo site_url('productout/add') ?>" class="btn btn-primary">New Product Out</a></p>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('msg'); ?>
            <table id="table-product-out" class="table table-hover table-bordered" style="width: 100%">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Document No</th>
                  <th>Product</th>
                  <th>Institute</th>
                  <th>Date</th>
                  <th width="10px">Qty</th>
                  <th>Budget</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_product_out">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" id="product_out_detail">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_out">Document No
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-7 col-xs-12" name="code_out">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_out">Product
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-7 col-xs-12" name="product_out">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="institute_out">Institute
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-7 col-xs-12" name="institute_out">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="datetrx_out">Date Trasansaction
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class='input-group'>
                <input type='text' class="form-control" name="datetrx_out" />
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="item form-group" id="qty">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty_out">Quantity
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" class="form-control col-md-6 col-xs-12" name="qty_out">
            </div>
          </div>
          <div class="item form-group" id="unitprice">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unitprice_out">Unit Price
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-6 col-xs-12" name="unitprice_out">
            </div>
          </div>
          <div class="item form-group" id="total">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_out">Total
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-6 col-xs-12" name="total_out">
            </div>
          </div>
          <div class="item form-group" id="budget">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_out">Budget
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-6 col-xs-12" name="budget_out">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_out">Description
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea class="form-control col-md-7 col-xs-12" name="desc_out"></textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status_out">Document Status
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-6 col-xs-12" name="status_out">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="resetProductOut()">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->