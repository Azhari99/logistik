<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Report Product Budget Out</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('rpt_budgetout/proses') ?>" target="_blank">
              <div class="form-group">
                <div class="form-check form-check-inline col-md-6 col-md-offset-3">
                  <input class="form-check-input inlineRadioOptions" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="product" required>
                  <label class="form-check-label" for="inlineRadio1">By Product</label>
                  <input class="form-check-input inlineRadioOptions" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="institute" required>
                  <label class="form-check-label" for="inlineRadio2">By Institute</label>
                  <input class="form-check-input inlineRadioOptions" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="category" required>
                  <label class="form-check-label" for="inlineRadio3">By Category</label>
                  <input class="form-check-input inlineRadioOptions" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="type" required>
                  <label class="form-check-label" for="inlineRadio4">By Type</label>
                </div>
              </div>
              <div class="item form-group" id="listproduct">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="listproduct">Product
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="listproduct" style="width: 100%">
                    <option value="">-- Choose Product --</option>
                    <?php foreach ($product as $value) : ?>
                      <option value="<?= $value->tbl_barang_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="item form-group" id="listinstitute">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="listinstitute">Institute
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="listinstitute" style="width: 100%">
                    <option value="">-- Choose Institute --</option>
                    <?php foreach ($institute as $value) : ?>
                      <option value="<?= $value->tbl_instansi_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="item form-group" id="listcategory">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="listcategory">Category
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="listcategory" style="width: 100%">
                    <option value="">-- Choose Category --</option>
                    <?php foreach ($category as $value) : ?>
                      <option value="<?= $value->tbl_kategori_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="item form-group" id="listtype">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="listtype">Type Logistics
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="listtype" style="width: 100%">
                    <option value="">-- Choose Type --</option>
                    <?php foreach ($type as $value) : ?>
                      <option value="<?= $value->tbl_jenis_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="item form-group" id="listtransaction">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="t_transaction">Type Transaction
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="t_transaction" style="width: 100%">
                    <option value="PI">Product In</option>
                    <option value="PO" selected>Product Out</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="datetrx">Date Trasansaction <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-12 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control datepicker" name="datetrx_start" value="<?php echo date('d/m/Y') ?>" required />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control datepicker" name="datetrx_end" value="<?php echo date('d/m/Y') ?>" required />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-5">
                  <button type="reset" class="btn btn-danger">Reset</button>
                  <button type="submit" class="btn btn-primary">OK</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>