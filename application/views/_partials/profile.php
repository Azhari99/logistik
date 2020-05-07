<div class="navbar nav_title" style="border: 0;">
  <a href="<?= site_url() ?>" class="site_title"><i class="fa fa-inbox"></i> <span>Logistics</span></a>
</div>

<div class="clearfix"></div>

<div class="profile clearfix">
  <div class="profile_pic">
    <img src="<?php echo base_url('assets/build/images/img.jpg') ?>" alt="..." class="img-circle profile_img">
  </div>
  <div class="profile_info">
    <span>Welcome,</span>
    <h2><?= ucfirst($this->session->userdata('name')) ?></h2>
  </div>
</div>