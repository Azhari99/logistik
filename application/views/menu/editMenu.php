<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Menu</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('menu/actEdit') ?>">
              <div class="item form-group <?= form_error('name_menu') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_menu">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name_menu" name="name_menu">
                  <?= form_error('name_menu') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('url_menu') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url_menu">Url <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="url_menu" name="url_menu">
                  <?= form_error('url_menu') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('icon_menu') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon_menu">Icon <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="icon_menu" name="icon_menu">
                  <?= form_error('icon_menu') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('line_menu') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="line_menu">Line No <span class="required">*</span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <input type="number" class="form-control col-md-7 col-xs-12" id="line_menu" name="line_menu">
                  <?= form_error('line_menu') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="ismenu" name="ismenu"> Active
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" id="id_menu" name="id_menu" value="<?php echo $menu_id ?>">
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('menu') ?>" class="btn btn-default">Back</a>
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