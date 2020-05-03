<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Institute</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <?= $this->session->flashdata('error') ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('institute/actEdit') ?>" id="form_product">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Code Institute
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code" name="code">
                </div>
              </div>
              <div class="item form-group <?= form_error('name') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name" name="name">
                  <?= form_error('name') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('email') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email Address <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="email" name="email">
                  <?= form_error('email') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone Number
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="phone" name="phone">
                </div>
              </div>
              <div class="item form-group <?= form_error('address') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="address" name="address"></textarea>
                  <?= form_error('address') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('budget_ins') ? 'has-error' : '' ?>">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_ins">Annual Budget <span class="required">*</span>
              </label>
              <div class="col-md-3 col-md-3 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12 rupiah" id="budget_ins" name="budget_ins" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
              </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="isinsti" name="isinsti"> Active
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" id="id_instansi" name="id_instansi" value="<?php echo $institute_id ?>">
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('institute') ?>" class="btn btn-warning">Back</a>
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