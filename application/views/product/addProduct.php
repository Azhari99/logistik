<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>New Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          <?= $this->session->flashdata('error') ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('product/actAdd') ?>" id="form_product">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Code Product
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code" name="code" value="<?php echo $code ?>">
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
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Category
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="category" name="category" style="width: 100%">
                    <option value="">-- Choose Category --</option>
                  </select>
                </div>
              </div>
              <div class="item form-group <?= form_error('qty') ? 'has-error' : '' ?>" id="lqty">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty">Limit Qty <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12" id="qty" name="qty">
                  <?= form_error('qty') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('unitprice') ? 'has-error' : '' ?>" id="uprice">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unitprice">Unit Price <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="unitprice" name="unitprice" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                  <?= form_error('unitprice') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('budget') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget">Budget <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="budget" name="budget" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                  <?= form_error('budget') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc" name="desc"></textarea>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="isproduct" name="isproduct" checked> Active
                    </label>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('product') ?>" class="btn btn-default">Back</a>
                  <button type="button" class="btn btn-danger" id="resetProduct">Reset</button>
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