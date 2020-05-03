<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Type</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('type/actAdd')?>" id="form_type">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_type">Code Type
                </label>
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code" name="code" value="<?= $code ?>">                
                </div>
              </div>
              <div class="item form-group <?= form_error('name') ? 'has-error': ''?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name" name="name" >
                  <?= form_error('name') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="istype" name="istype" checked> Active
                    </label>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('type') ?>" class="btn btn-warning">Back</a>
                  <button type="button" class="btn btn-danger" id="resetType">Reset</button>
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
