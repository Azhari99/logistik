<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('_partials/head') ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            
            <!-- menu profile quick info -->
            <?php $this->load->view('_partials/profile') ?>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php $this->load->view('_partials/sidebar') ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php $this->load->view('_partials/menu') ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php $this->load->view('_partials/navbar') ?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php echo $contents ?>
        <!-- /page content -->

        <!-- footer content -->
        <?php $this->load->view('_partials/footer') ?>
        <!-- /footer content -->
      </div>
    </div>

    <?php $this->load->view('_partials/js') ?>
  </body>
</html>

<?php $this->load->view('product/actProduct') ?>
<?php $this->load->view('type/actType') ?>
<?php $this->load->view('category/actCategory') ?>
<?php $this->load->view('institute/actInstitute') ?>
<?php $this->load->view('product_in/actPIn') ?>
<?php $this->load->view('request_in/actRIn') ?>
<?php $this->load->view('product_out/actPOut') ?>
<?php $this->load->view('users/actUser') ?>
<?php $this->load->view('menu/actMenu') ?>
<?php $this->load->view('submenu/actSub') ?>
<?php $this->load->view('budget/actBudget') ?>
