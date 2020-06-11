<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo ucfirst($this->uri->segment(1)) ?></h2>
            <?php
            $level = $this->session->userdata('level');
            if (!($level == 2 || $level == 3)) { ?>
              <p class="navbar-right"><a href="<?php echo site_url('product/add') ?>" class="btn btn-primary">New Product</a></p>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content table-responsive">
            <?php echo $this->session->flashdata('msg'); ?>
            <table id="table-product" class="table table-hover table-bordered" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Code Product</th>
                  <th>Name</th>
                  <th>Jenis</th>
                  <th>Category</th>
                  <th>Limit Qty</th>
                  <th>Stock</th>
                  <th>Price</th>
                  <th>Remaining Budget</th>
                  <th>Annual Budget</th>
                  <th>Description</th>
                  <th>Created</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>