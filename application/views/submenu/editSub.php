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
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('submenu/actEdit') ?>">
              <div class="item form-group <?= form_error('name_sub') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_sub">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name_sub" name="name_sub">
                  <?= form_error('name_sub') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('menu_id') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu_id">Parent Menu
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="menu_id" name="menu_id" style="width: 100%">
                    <option value="">-- Choose Parent Menu --</option>
                    <?php foreach ($menu as $row) : ?>
                      <option value="<?php echo $row->tbl_menu_id ?>"><?php echo $row->name ?> </option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('menu_id') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('url_sub') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url_sub">Url
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="url_sub" name="url_sub">
                  <?= form_error('url_sub') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('line_sub') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="line_menu">Line No <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="number" class="form-control col-md-7 col-xs-12" id="line_sub" name="line_sub">
                  <?= form_error('line_sub') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label class="col-sm-3">
                      <input type="checkbox" id="issub" name="issub"> Active
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" id="id_sub" name="id_sub" value="<?php echo $sub_id ?>">
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('submenu') ?>" class="btn btn-default">Back</a>
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