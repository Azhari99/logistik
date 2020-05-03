<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Product Out</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('error'); ?>
            <form class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="<?php echo site_url('productout/actAdd') ?>" id="form_product">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_out">Document No
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code_out" name="code_out" value="<?php echo $code ?>">
                </div>
              </div>
              <div class="item form-group <?= form_error('product_out') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_out">Product <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="product_out" name="product_out" style="width: 100%">
                    <option value="">-- Choose Product --</option>
                    <?php foreach ($product as $value) : ?>
                      <option value="<?= $value->tbl_barang_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('institute_out') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('institute_out') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="institute_out">Institute <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="institute_out" name="institute_out" style="width: 100%">
                    <option value="">-- Choose Institute --</option>
                    <?php foreach ($institute as $value) : ?>
                      <option value="<?= $value->tbl_instansi_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('institute_out') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('datetrx_out') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="datetrx_out">Date Trasansaction <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control datepicker" id="datetrx_out" name="datetrx_out" value="<?php echo date('d/m/Y') ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <?= form_error('datetrx_out') ?>
                </div>
              </div>
              <div class="item form-group" id="qtygroup_out">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty_out">Quantity
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="number" class="form-control col-md-3 col-xs-12" id="qty_out" name="qty_out">
                </div>
              </div>
              <div class="item form-group" id="unitgroup_out">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unitprice_out">Unit Price
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="unitprice_out" name="unitprice_out" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                </div>
              </div>
              <div class="item form-group" id="totalgroup_out">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_out">Total
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="total_out" name="total_out" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                </div>
              </div>
              <div class="item form-group" id="budgetgroup_out">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_out">Budget
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="budget_out" name="budget_out" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_out">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc_out" name="desc_out"></textarea>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('productout') ?>" class="btn btn-default">Back</a>
                  <button type="button" class="btn btn-danger" id="resetProductOut">Reset</button>
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