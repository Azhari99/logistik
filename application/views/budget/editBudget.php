<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Annual Budget</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?= $this->session->flashdata('error') ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('budget/actEdit') ?>" id="form_category">
              <div class="item form-group <?= form_error('name_budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_budget">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name_budget" name="name_budget">
                  <?= form_error('name_budget') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('year_budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="year_budget">Year <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class='input-group'>
                    <input type='text' class="form-control yearpicker" id="year_budget" name="year_budget" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                  <?= form_error('year_budget') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('typelog_budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typelog_budget">Type Logistic <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="typelog_budget" name="typelog_budget" style="width: 100%">
                    <option value="">-- Choose Type Logistic --</option>
                    <?php foreach ($type as $row) : ?>
                      <option value="<?php echo $row->tbl_jenis_id ?>"><?php echo $row->name ?> </option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('typelog_budget') ?>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc_budget">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc_budget" name="desc_budget"></textarea>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="isbudget" name="isbudget"> Active
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" class="form-control col-md-3 col-xs-12" id="id_budget" name="id_budget" value="<?= $budget_id ?>" readonly>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('budget') ?>" class="btn btn-default">Back</a>
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