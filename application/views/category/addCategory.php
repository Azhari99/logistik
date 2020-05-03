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
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('category/actAdd') ?>" id="form_category">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Code Category
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code" name="code" value="<?php echo $code ?>">                
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typelog">Type Logistic
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control select2" id="typelog" name="typelog" style="width: 50%">
                    <option value="">-- Choose Type Logistic --</option>
                    <?php foreach ($type as $row): ?>
                      <option value="<?php echo $row->tbl_jenis_id ?>"><?php echo $row->name ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="iscategory" name="iscategory" checked> Active
                    </label>
                    <!-- <label>
                      <input type="checkbox" id="isdefault" name="isdefault"> Default
                    </label> -->
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('category') ?>" class="btn btn-warning">Back</a>
                  <button type="button" class="btn btn-danger" id="resetCategory">Reset</button>
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
