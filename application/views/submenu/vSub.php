<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo ucfirst($this->uri->segment(1)) ?></h2>
            <p class="navbar-right"><a href="<?php echo site_url('submenu/add') ?>" class="btn btn-primary">New Submenu</a></p>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('msg'); ?>
            <table id="table-submenu" class="table table-hover table-bordered" style="width: 100%">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Menu Name</th>
                  <th width="50px">Line No</th>
                  <th>Parent Menu</th>
                  <th>Url</th>
                  <th width="50px">Status</th>
                  <th width="70px">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>