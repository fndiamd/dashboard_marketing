<?php include('../core/tomo.php') ?>
<div class="row">
  <div class="col-md-3">
    <div class="card">
      Target Toko Modern
      <h5 class="purple"><?= number_format($targetTokoModern['target_revenue'], 0, ',', '.')?></h5>
      <small class="text-muted"><?= number_format($targetTokoModern['target_transaksi'], 0, ',', '.')?> transaction</small>
    </div>
    <div class="card mt-1">
      Last Month
      <h5 class="purple"><?= number_format($revenueBulanLalu, 0, ',', '.')?></h5>
      <small class="text-muted"><?= number_format($trxBulanLalu, 0, ',', '.')?> transaction</small>
    </div>
    <div class="card mt-1">
      This Month
      <h5 class="purple">
        <?php 
          if($revenueBulanIni - $revenueBulanLalu > 0){
            $arrow = 'ion-arrow-up-c';
          }else{
            $arrow = 'ion-arrow-down-c';
          }
        ?>
        <li class="<?= $arrow?>" data-pack="default"></li> <?= number_format($revenueBulanIni, 0, ',', '.')?>
      </h5>
      <small class="text-muted"><?= number_format($trxBulanIni, 0, ',', '.')?> transaction</small>
      <?php 
          if($trxBulanIni - $trxBulanLalu > 0){
            $operator = '+';
          }else{
            $operator = '';
          }
        ?>
      <i><small class="text-muted">(<?= $operator;?><?= number_format($trxBulanIni - $trxBulanLalu, 0, ',', '.')?> transaction)</small></i>
    </div>
  </div>
  <div class="col-md-9">
    <div id="grafik" style="height: 315px;"></div>
  </div>
</div>
<div class="overflow-x">
  <table width="120%">
    <tbody>
      <tr>
        <th colspan="1" rowspan="2" class="th">POIN</th>
        <th colspan="2">TARGET BULAN INI</th>
        <th colspan="2">BULAN LALU</th>
        <th colspan="2">BULAN INI</th>
        <th colspan="2">DEVIASI BULAN</th>
        <th colspan="2">DEVIASI OKR</th>
        <th colspan="2">% OKR</th>
      </tr>
      <tr class="th">
        <th>Trx</th>
        <th>Rev</th>
        <th>Trx</th>
        <th>Rev</th>
        <th>Trx</th>
        <th>Rev</th>
        <th>Trx</th>
        <th>Rev</th>
        <th>Trx</th>
        <th>Rev</th>
        <th>Trx</th>
        <th>Rev</th>
      </tr>
      <?php
      foreach ($dataTable as $r) {
      ?>
        <tr>
          <td style="min-width:150px"><?php echo $r['kategori'] ?></td>
          <td align="right"><?= number_format($r['target']['trx'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['target']['rev'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['bulan_lalu']['trx'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['bulan_lalu']['rev'],0,',','.') ?></td>
          <td align="right">
            <?= number_format($r['bulan_ini']['trx'],0,',','.')?>
            <?php if (($r['bulan_ini']['trx'] - $r['bulan_lalu']['trx']) > 0) : ?>
              <li class="ion-arrow-up-c" data-pack="default"></li>
            <?php else : ?>
              <li class="ion-arrow-down-c" data-pack="default"></li>
            <?php endif; ?>
          </td>
          <td align="right">
            <?= number_format($r['bulan_ini']['rev'],0,',','.') ?>
            <?php if (($r['bulan_ini']['rev'] - $r['bulan_lalu']['rev']) > 0) : ?>
              <li class="ion-arrow-up-c" data-pack="default"></li>
            <?php else : ?>
              <li class="ion-arrow-down-c" data-pack="default"></li>
            <?php endif; ?>
          </td>
          <td align="right"><?= number_format($r['deviasi']['trx'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['deviasi']['rev'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['deviasi_okr']['trx'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['deviasi_okr']['rev'],0,',','.') ?></td>
          <td align="right"><?= number_format($r['okr']['trx'],2,',',',') ?></td>
          <td align="right"><?= number_format($r['okr']['rev'],2,',',',') ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</div>
<script src="assets/highcharts/highcharts.js?v=2"></script>
<script type="text/javascript">
  var dataTarget = <?= json_encode($grafikTarget)?>;
  var dataBulanLalu = <?= json_encode($grafikBulanLalu) ?>;
  var dataBulanSekarang = <?= json_encode($grafikBulanSekarang) ?>;

  Highcharts.theme = {
    colors: ['#51d0de', '#bf4aa8', '#d9d9d9', '#4f5f76', '#6B7A8F', '#007f4f',
      '#0f2862', '#9e363a', '#1561ad'
    ]
  };
  Highcharts.setOptions(Highcharts.theme);
  Highcharts.chart('grafik', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Grafik Transaksi Per Grup Produk Tomo'
    },
    xAxis: {
      categories: ['<?php echo implode("','", $kategori) ?>']
    },
    yAxis: {
      title: {
        text: 'Jumlah Revenue'
      }
    },
    plotOptions: {
      spline: {
        marker: {
          radius: 4,
          lineColor: '#666666',
          lineWidth: 1
        }
      }
    },
    series: [{
      name: 'Target',
      marker: {
        symbol: 'cirle'
      },
      data: dataTarget

    }, {
      name: 'Bulan Lalu',
      marker: {
        symbol: 'cirle'
      },
      data: dataBulanLalu 
    }, {
      name: 'Bulan Ini',
      marker: {
        symbol: 'cirle'
      },
      data: dataBulanSekarang 
    }]
  });
</script>