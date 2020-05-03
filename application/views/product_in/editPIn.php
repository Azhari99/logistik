<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product In</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('error'); ?>
            <form class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="<?php echo site_url('productin/actEdit') ?>" id="form_product">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_in">Document No
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code_in" name="code_in">
                </div>
              </div>
              <div class="item form-group <?= form_error('product_in') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_in">Product <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="product_in" name="product_in" style="width: 100%">
                    <option value="">-- Choose Product --</option>
                    <?php foreach ($product as $value) : ?>
                      <option value="<?= $value->tbl_barang_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('product_in') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('datetrx_in') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="datetrx_in">Date Trasansaction <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control datepicker" id="datetrx_in" name="datetrx_in">
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <?= form_error('datetrx_in') ?>
                </div>
              </div>
              <div class="item form-group" id="qtygroup_in">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty_in">Quantity
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="number" class="form-control col-md-3 col-xs-12" id="qty_in" name="qty_in">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unitprice_in">Unit Price
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="unitprice_in" name="unitprice_in" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_in">Total
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="total_in" name="total_in" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_in">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc_in" name="desc_in"></textarea>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nodin_file_in">File Nodin Barang Masuk
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="file" class="control-label" id="nodin_file_in" name="nodin_file_in"></input>
                  <small>(Maksimal Upload 5Mb)</small>
                </div>
              </div>
              <input type="hidden" class="form-control col-md-3 col-xs-12" id="id_barang_in" name="id_barang_in" value="<?= $product_in_id ?>" readonly>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('productin') ?>" class="btn btn-default">Back</a>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>