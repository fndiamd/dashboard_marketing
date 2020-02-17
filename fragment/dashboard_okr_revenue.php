<?php include('../core/dashboard.php') ?>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            Sentra Bisnis Fastpay
            <h5 class="purple">
                <?php
                if (($sbf['rev'] - $sbfPass['rev']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="<?= $arrow ?>" data-pack="default"></li> <?= number_format($sbf['rev'], 0, ',', '.') ?>
            </h5>
            <small class="text-muted">
                <?php
                if (($sbf['trx'] - $sbfPass['trx']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="<?= $arrow ?>" data-pack="default"></li> <?= number_format(abs($sbf['trx'] - $sbfPass['trx']), 0, ',', '.') ?> transaction
            </small>
        </div>
        <div class="card">
            Outlet Retail
            <h5 class="purple">
                <?php
                if (($retail['rev'] - $retailPass['rev']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="ion-arrow-up-c" data-pack="default"></li> <?= number_format($retail['rev'], 0, ',', '.') ?>
            </h5>
            <small class="text-muted">
                <?php
                if (($retail['trx'] - $retailPass['trx']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="ion-arrow-down-c" data-pack="default"></li> <?= number_format(abs($retail['trx'] - $retailPass['trx']),0, ',', '.') ?> transaction
            </small>
        </div>
        <div class="card mt-2">
            Outlet H2H
            <h5 class="purple">
                <?php
                if (($h2h['rev'] - $h2hPass['rev']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="ion-arrow-down-c" data-pack="default"></li> <?= number_format($h2h['rev'], 0, ',', '.') ?>
            </h5>
            <small class="text-muted">
                <?php
                if (($h2h['trx'] - $h2hPass['trx']) > 0) {
                    $arrow = 'ion-arrow-up-c';
                } else {
                    $arrow = 'ion-arrow-down-c';
                }
                ?>
                <li class="ion-arrow-up-c" data-pack="default"></li> <?= number_format(abs($h2h['trx'] - $h2hPass['trx']),0, ',', '.') ?> transaction
            </small>
        </div>
    </div>
    <div class="col-md-9">
        <div id="grafik" style="height: 290px;"></div>
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
            foreach ($dataTable as $r) {
            ?>
                <tr>
                    <td><?php echo $r['kategori'] ?></td>
                    <td align="right"><?= $r['target']['trx'] ?></td>
                    <td align="right"><?= $r['target']['rev'] ?></td>
                    <td align="right"><?= $r['bulan_lalu']['trx'] ?></td>
                    <td align="right"><?= $r['bulan_lalu']['rev'] ?></td>
                    <td align="right">
                        <?= $r['bulan_ini']['trx'] ?>
                        <?php if (($r['bulan_ini']['trx'] - $r['bulan_lalu']['trx']) > 0) : ?>
                            <li class="ion-arrow-up-c" data-pack="default"></li>
                        <?php else : ?>
                            <li class="ion-arrow-down-c" data-pack="default"></li>
                        <?php endif; ?>
                    </td>
                    <td align="right">
                        <?= $r['bulan_ini']['rev'] ?>
                        <?php if (($r['bulan_ini']['rev'] - $r['bulan_lalu']['rev']) > 0) : ?>
                            <li class="ion-arrow-up-c" data-pack="default"></li>
                        <?php else : ?>
                            <li class="ion-arrow-down-c" data-pack="default"></li>
                        <?php endif; ?>
                    </td>
                    <td align="right"><?= $r['deviasi']['trx'] ?></td>
                    <td align="right"><?= $r['deviasi']['rev'] ?></td>
                    <td align="right"><?= $r['deviasi_okr']['trx'] ?></td>
                    <td align="right"><?= $r['deviasi_okr']['rev'] ?></td>
                    <td align="right"><?= $r['okr']['trx'] ?></td>
                    <td align="right"><?= $r['okr']['rev'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="assets/highcharts/highcharts.js?v=2"></script>
<script type="text/javascript">
    var targetRevenue = <?= json_encode($targetRevenue) ?>;
    var revenueLalu = <?= json_encode($resultRevenueLalu) ?>;
    var revenueSekarang = <?= json_encode($resultRevenueSekarang) ?>;
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
            text: 'Grafik OKR Revenue'
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
            data: targetRevenue

        }, {
            name: 'Bulan Lalu',
            marker: {
                symbol: 'cirle'
            },
            data: revenueLalu
        }, {
            name: 'Bulan Ini',
            marker: {
                symbol: 'cirle'
            },
            data: revenueSekarang
        }]
    });
</script>