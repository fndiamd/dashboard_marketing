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
                <li class="ion-arrow-down-c" data-pack="default"></li> <?= number_format(abs($retail['trx'] - $retailPass['trx']), 0, ',', '.') ?> transaction
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
                <li class="ion-arrow-up-c" data-pack="default"></li> <?= number_format(abs($h2h['trx'] - $h2hPass['trx']), 0, ',', '.') ?> transaction
            </small>
        </div>
    </div>
    <div class="col-md-9">
        <div id="grafik" style="height: 290px;"></div>
    </div>
</div>
<div class="overflow-x">
    <br>
    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter">Tentukan Target</button>
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
                    <td style="min-width:150px"><?php echo $r['kategori'] ?></td>
                    <td align="right"><?= number_format($r['target']['trx'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['target']['rev'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['bulan_lalu']['trx'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['bulan_lalu']['rev'], 0, ',', '.') ?></td>
                    <td align="right">
                        <?= number_format($r['bulan_ini']['trx'], 0, ',', '.') ?>
                        <?php if (($r['bulan_ini']['trx'] - $r['bulan_lalu']['trx']) > 0) : ?>
                            <li class="ion-arrow-up-c" data-pack="default"></li>
                        <?php else : ?>
                            <li class="ion-arrow-down-c" data-pack="default"></li>
                        <?php endif; ?>
                    </td>
                    <td align="right">
                        <?= number_format($r['bulan_ini']['rev'], 0, ',', '.') ?>
                        <?php if (($r['bulan_ini']['rev'] - $r['bulan_lalu']['rev']) > 0) : ?>
                            <li class="ion-arrow-up-c" data-pack="default"></li>
                        <?php else : ?>
                            <li class="ion-arrow-down-c" data-pack="default"></li>
                        <?php endif; ?>
                    </td>
                    <td align="right"><?= number_format($r['deviasi']['trx'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['deviasi']['rev'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['deviasi_okr']['trx'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['deviasi_okr']['rev'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($r['okr']['trx'], 2, ',', '.') ?>%</td>
                    <td align="right"><?= number_format($r['okr']['rev'], 2, ',', '.') ?>%</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Target OKR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group row">
                        <label for="" class="col-form-label col-sm-3">Tahun dan Bulan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="bulan" placeholder="Format: Tahun-Bulan, ex:2020-02">
                        </div>
                    </div>
                    <?php foreach ($getKategori as $kategori) : ?>
                        <div class="form-group row">
                            <label for="" class="col-form-label col-sm-3"><?= $kategori['kategori'] ?></label>
                            <div class="col-sm-9">
                                <input type="hidden" name="kategori[]" value="<?= $kategori['id_kategori'] ?>">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="target_revenue[]" class="form-control" placeholder="Target Revenue untuk <?= $kategori['kategori'] ?>">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="target_transaksi[]" class="form-control" placeholder="Target Transaksi untuk <?= $kategori['kategori'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $tahun = explode('-', $_POST['bulan'])[0];
    $bulan = explode('-', $_POST['bulan'])[1];

    for ($i = 0; $i < count($_POST['kategori']); $i++) {
        $sql = "INSERT INTO target_marketing(bulan, tahun, target_transaksi, target_revenue, id_kategori) VALUES(:bulan, :tahun, :target_transaksi, :target_revenue, :id_kategori)";
        $state = $db->prepare($sql);
        $state->bindValue(':bulan', $bulan);
        $state->bindValue(':tahun', $tahun);
        $state->bindValue(':target_transaksi', $_POST['target_transaksi'][$i]);
        $state->bindValue(':target_revenue', $_POST['target_revenue'][$i]);
        $state->bindValue(':id_kategori', $_POST['kategori'][$i]);
        $state->execute();
    }

    echo '<script>alert("Target untuk bulan '.$bulan.' dan tahun '.$tahun.' berhasil ditetapkan");</script>';
}
?>

<script src="assets/highcharts/highcharts.js?v=2"></script>
<script type="text/javascript">
    var dataTarget = <?= json_encode($grafikTarget) ?>;
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
            text: 'Grafik OKR Revenue'
        },
        xAxis: {
            categories: ['<?php echo implode("','", $dataKategori) ?>']
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