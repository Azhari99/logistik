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
              <p class="navbar-right"><a href="<?php echo site_url('users/add') ?>" class="btn btn-primary">New User</a></p>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('msg'); ?>
            <table id="table-user" class="table table-hover table-bordered" style="width: 100%">
              <thead>
                <tr>
                  <th width="10px">No</th>
                  <th>Searh Key</th>
                  <th>Name</th>
                  <th>Level</th>
                  <th width="20px">Status</th>
                  <th width="100px"></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>