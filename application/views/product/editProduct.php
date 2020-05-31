<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?= $this->session->flashdata('error') ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?php echo site_url('product/actEdit') ?>" id="form_product">
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code_product">Code Product
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="code_product" name="code_product">
                </div>
              </div>
              <div class="item form-group <?= form_error('name_product') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name_product">Name <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" id="name_product" name="name_product">
                  <?= form_error('name_product') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('typelog_product') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="typelog">Type Logistic
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="typelog_product" name="typelog_product" style="width: 100%">
                    <option value="">-- Choose Type Logistic --</option>
                    <?php foreach ($type as $value) : ?>
                      <option value="<?= $value->tbl_jenis_id ?>"><?= $value->name ?></option>';
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('typelog_product') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_product">Category
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <select class="form-control select2" id="category_product" name="category_product" style="width: 100%">
                    <option value="">-- Choose Category --</option>
                  </select>
                </div>
                <input type="hidden" id="id_kategori" name="id_kategori" value="<?php echo $kategori ?>">
              </div>
              <div class="item form-group <?= form_error('qty_product') ? 'has-error' : '' ?>" id="lqty">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty_product">Limit Qty <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12" id="qty_product" name="qty_product">
                  <?= form_error('qty_product') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('unitprice_product') ? 'has-error' : '' ?>" id="uprice">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="unitprice_product">Unit Price <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="unitprice_product" name="unitprice_product" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                  <?= form_error('unitprice_product') ?>
                </div>
              </div>
              <div class="item form-group <?= form_error('budget_product') ? 'has-error' : '' ?>">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="budget_product">Budget <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" class="form-control col-md-3 col-xs-12 rupiah" id="budget_product" name="budget_product" data-a-sign="Rp." data-a-dec="," data-a-sep=".">
                  <?= form_error('budget_product') ?>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <textarea class="form-control col-md-7 col-xs-12" id="desc_product" name="desc_product"></textarea>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="isproduct" name="isproduct"> Active
                    </label>
                  </div>
                </div>
              </div>
              <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $product_id ?>">
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <a href="<?php echo site_url('product') ?>" class="btn btn-default">Back</a>
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