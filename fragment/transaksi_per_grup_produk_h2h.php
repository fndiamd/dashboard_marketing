<div class="row">
  <div class="col-md-3">
    <div class="card">
      Target H2H
      <h5 class="purple">23.000.000</h5>
      <small class="text-muted">1200 transaction</small>
    </div>
    <div class="card mt-1">
      Last Month
      <h5 class="purple">11.000.000</h5>
      <small class="text-muted">200 transaction</small>
    </div>
    <div class="card mt-1">
      This Month
      <h5 class="purple">
        <li class="ion-arrow-up-c" data-pack="default"></li> 12.000.000
      </h5>
      <small class="text-muted">1200 transaction</small>
      <i><small class="text-muted">(+200 transaction)</small></i>
    </div>
  </div>
  <div class="col-md-9">
    <div id="grafik" style="height: 315px;"></div>
  </div>
</div>
<div class="overflow-x">
  <table width="100%">
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
      $arr = array(
        'PLN/LISTRIK RETIL',
        'TELKOM',
        'SELULER PASCABAYAR',
        'TV KABEL',
        'PDAM',
        'MULTI FINANCE',
        'KARTU KREDIT',
        'GAME ONLINE',
        'PULSA SELULER',
        'ASURANSI',
        'RUMAH ZAKAT',
        'IKLAN/ADVERTISING',
        'BRANCHLESS BANKING',
        'PGN',
        'E-MONEY',
        'TIKET KA(TKAI,MKAI,PKAI)',
        'RAILINK',
        'TIKET PESAWAT',
        'HOTEL',
        'TIKET TRAVEL',
        'CAR RENTAL',
        'TIKET EVENT,KONSER,BIOSKOP,DLL',
        'PELNI',
        'FINTECH,PG,LAIN-LAIN'
      );
      foreach ($arr as $r) {
      ?>
        <tr>
          <td><?php echo $r ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?><li class="ion-arrow-up-c" data-pack="default"></li>
          </td>
          <td align="right"><?php echo rand() ?><li class="ion-arrow-down-c" data-pack="default"></li>
          </td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
          <td align="right"><?php echo rand() ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<script src="assets/highcharts/highcharts.js?v=2"></script>
<script type="text/javascript">
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
      text: 'Grafik Transaksi Per Grup Produk H2H'
    },
    xAxis: {
      categories: ['<?php echo implode("','", $arr) ?>']
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
      data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2]

    }, {
      name: 'Bulan Lalu',
      marker: {
        symbol: 'cirle'
      },
      data: [4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6]
    }, {
      name: 'Bulan Ini',
      marker: {
        symbol: 'cirle'
      },
      data: [4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6]
    }]
  });
</script>