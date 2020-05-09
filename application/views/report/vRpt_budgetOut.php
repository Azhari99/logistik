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
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('rpt_budgetout/report') ?>" target="_blank">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="isproduct">Product
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" name="isproduct" style="width: 100%">
                    <option value="">-- Choose Product --</option>
                    <?php foreach ($product as $value) : ?>
                      <option value="<?= $value->tbl_barang_id ?>"><?= $value->name ?></option>
                    <?php endforeach; ?>
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