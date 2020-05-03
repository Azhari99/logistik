<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Annual Budget</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?= $this->session->flashdata('error') ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('budget/actAdd') ?>" id="form_category">
              <div class="item form-group <?= form_error('name') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name" name="name">
                  <?= form_error('name') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('year_budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="year_budget">Year <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control yearpicker" id="year_budget" name="year_budget" value="<?php echo date('Y') ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <?= form_error('year_budget') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('typelog') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typelog">Type Logistic <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="typelog" name="typelog" style="width: 100%">
                    <option value="">-- Choose Type Logistic --</option>
                    <?php foreach ($type as $row) : ?>
                      <option value="<?php echo $row->tbl_jenis_id ?>"><?php echo $row->name ?> </option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('typelog') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('an_budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="an_budget">Annual Budget <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12 rupiah" id="an_budget" name="an_budget" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                  <?= form_error('an_budget') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc" name="desc"></textarea>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="isbudget" name="isbudget" checked> Active
                    </label>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('budget') ?>" class="btn btn-warning">Back</a>
                  <button type="button" class="btn btn-danger" id="resetBudget">Reset</button>
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