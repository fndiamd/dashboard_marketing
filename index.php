  <?php include "header.php";?>
  <?php require_once('core/dashboard.php')?>
    <main role="main" class="container">
      <div id="dashboard" class="mb-5">
        <h3 class="group">OKR</h3>
        <div id="menu_okr" class="dropdown show">
          <a class="dropdown-toggle" href="#" role="button" id="dropdownOkr" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dashboard OKR Revenue</a>
          <div class="dropdown-menu" aria-labelledby="dropdownOkr" id="dropdownItemOkr">
            <a class="dropdown-item" href="javascript:void(0)" data-panel="dashboard_okr_revenue">Dashboard OKR Revenue</a>
            <a class="dropdown-item" href="javascript:void(0)" data-panel="transaksi_per_grup_produk_tomo">Transaksi Per Grup Produk - Tomo</a>
            <a class="dropdown-item" href="javascript:void(0)" data-panel="transaksi_per_grup_produk_h2h">Transaksi Per Grup Produk - H2H</a>
            <a class="dropdown-item" href="javascript:void(0)" data-panel="dashboard_okr_mat">Dashboard Member Aktif Transaksi</a>
            <a class="dropdown-item" href="javascript:void(0)" data-panel="dashboard_okr_new_mat">Dashboard New Member Aktif Transaksi</a>
          </div>
        </div>
        <div class="loading" style="display:none;" align="center"><img src="assets/img/loading.gif"></div>
        <div id="panel">
            <?php include 'fragment/dashboard_okr_revenue.php';?>
        </div>
      </div>
    </main><!-- /.container -->
<?php include "footer.php";?>
