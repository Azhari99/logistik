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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_ins">Code Institute
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code_ins" name="code_ins">
                </div>
              </div>
              <div class="item form-group <?= form_error('name_ins') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_ins">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name_ins" name="name_ins">
                  <?= form_error('name_ins') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('email_ins') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email Address <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="email_ins" name="email_ins">
                  <?= form_error('email_ins') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_ins">Phone Number
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="phone_ins" name="phone_ins">
                </div>
              </div>
              <div class="item form-group <?= form_error('address_ins') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address_ins">Address <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="address_ins" name="address_ins"></textarea>
                  <?= form_error('address_ins') ?>
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
                  <a href="<?php echo site_url('institute') ?>" class="btn btn-default">Back</a>
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