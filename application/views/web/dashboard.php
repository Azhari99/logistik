<div class="right_col" role="main">
  <div class="">
    <div class="row top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icondash"><i class="fa fa-archive"></i></div>
          <div class="total"><?= rupiah($budget->total_budget) ?></div>
          <h3>Anggaran</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icondash"><i class="fa fa-caret-square-o-up"></i></div>
          <div class="total"><?= rupiah($budgetOut->budget_total) ?></div>
          <h3>Anggaran Keluar</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icondash"><i class="fa fa-caret-square-o-down"></i></div>
          <div class="total"><?= $requestIn ?></div>
          <h3>Jumlah Pengajuan</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icondash"><i class="fa fa-list"></i></div>
          <div class="total"><?= rupiah($remainBudget) ?></div>
          <h3>Sisa Anggaran</h3>
        </div>
      </div>
    </div>
  </div>
</div>