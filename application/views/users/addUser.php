<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('users/actAdd') ?>" id="form_category">
              <div class="item form-group <?= form_error('username') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-6" for="username">Search Key <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="username" name="username">
                  <?= form_error('username') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('name') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Full Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name" name="name" >
                  <?= form_error('name') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('password') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12" id="password" name="password">
                  <?= form_error('password') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('passconf') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="passconf">Password Confirmation <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="password" class="form-control col-md-7 col-xs-12" id="passconf" name="passconf">
                  <?= form_error('passconf') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('level') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="level">Level <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="level" name="level" style="width: 100%">
                    <option value="">-- Choose Level --</option>
                    <option value="1">Admin</option>
                    <option value="2">Pimpinan</option>
                    <option value="3">User</option>
                  </select>
                  <?= form_error('level') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="isuser" name="isuser" checked> Active               
                    </label>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('users') ?>" class="btn btn-warning">Back</a>
                  <button type="reset" class="btn btn-danger">Reset</button>
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
