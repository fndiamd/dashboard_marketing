<?php
require_once('connection.php');

$dataTable = [];

// Kategori
$queryKategori = $db->query("select distinct group_layanan from mt_group_produk order by group_layanan asc")->fetchAll(PDO::FETCH_COLUMN);
$kategori = [];
$baseQueryFirst = "select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where id_group_produk in ";
$lastMonth = "and tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month') and substring(id_outlet, -2, 5) in('HH', 'SP')";
$thisMonth = "and tanggal between date_trunc('month', current_date) and current_date and substring(id_outlet, -2, 5) in('HH', 'SP')";
$dataTarget = [];
$dataBulanLalu = [];
$dataBulanSekarang = [];

$grafikTarget = [];
$grafikBulanLalu = [];
$grafikBulanSekarang = [];

$currentMonth = date("m");
$currentYear = date("Y");

// id 8 untuk kategori h2h
$targetH2h = $db->query("select * from target_marketing where bulan = $currentMonth and tahun = $currentYear and id_kategori = 8")->fetch(PDO::FETCH_ASSOC);
$revenueBulanLalu = 0; $trxBulanLalu = 0;
$revenueBulanIni = 0; $trxBulanIni = 0;

// Mengambil data kategori beserta rekapan data transaksi dan revenue untuk bulan sekarang dan lalu
foreach ($queryKategori as $ktg) {
    array_push($kategori, substr($ktg, 4));
    $dataBulanLalu[substr($ktg, 4)] = $db->query($baseQueryFirst . "(select id_group_produk from mt_group_produk as mgp where mgp.group_layanan = '$ktg')" . $lastMonth)->fetchAll(PDO::FETCH_ASSOC);
    $dataBulanSekarang[substr($ktg, 4)] = $db->query($baseQueryFirst . "(select id_group_produk from mt_group_produk as mgp where mgp.group_layanan = '$ktg')" . $thisMonth)->fetchAll(PDO::FETCH_ASSOC);
    // id 8 untuk kategori h2h
    $dataTarget[substr($ktg, 4)] = $db->query("select * from target_marketing_group_produk where group_produk = '$ktg' and id_kategori = 8")->fetchAll(PDO::FETCH_ASSOC);
}

$counter = 1;
foreach($dataTarget as $dt){
    array_push($grafikTarget, intval($dt[0]['target_revenue']));
    if($counter >= 7) break;
    $counter++;
}

// Membuat data revenue untuk chart data bulan lalu
$counterBulanLalu = 1;
$counterBulanIni = 1;
foreach ($dataBulanLalu as $dbl) {
    $revenueBulanLalu += $dbl[0]['rev'];
    $trxBulanLalu += $dbl[0]['trx'];
    if ($counterBulanLalu <= 7) {
        array_push($grafikBulanLalu, intval($dbl[0]['rev']));
    }
    $counterBulanLalu++;
}

// Membuat data revenue untuk chart data bulan sekarang
foreach ($dataBulanSekarang as $dbs) {
    $revenueBulanIni += $dbs[0]['rev'];
    $trxBulanIni += $dbs[0]['trx'];
    if ($counterBulanIni <= 7) {
        array_push($grafikBulanSekarang, intval($dbs[0]['rev']));
    }
    $counterBulanIni++;
}


// Membuat data untuk tabel
foreach ($kategori as $ktg) {
    $data = [
        'kategori' => $ktg,
        'target' => [
            'trx' => $dataTarget[$ktg][0]['target_transaksi'],
            'rev' => $dataTarget[$ktg][0]['target_revenue']
        ],
        'bulan_lalu' => [
            'trx' => $dataBulanLalu[$ktg][0]['trx'],
            'rev' => $dataBulanLalu[$ktg][0]['rev']
        ],
        'bulan_ini' => [
            'trx' => $dataBulanSekarang[$ktg][0]['trx'],
            'rev' => $dataBulanSekarang[$ktg][0]['rev']
        ],
        'deviasi' => [
            'trx' => $dataBulanSekarang[$ktg][0]['trx'] - $dataBulanLalu[$ktg][0]['trx'],
            'rev' => $dataBulanSekarang[$ktg][0]['rev'] - $dataBulanLalu[$ktg][0]['rev']
        ],
        'deviasi_okr' => [
            'trx' => $dataTarget[$ktg][0]['target_transaksi'] - $dataBulanSekarang[$ktg][0]['trx'],
            'rev' => $dataTarget[$ktg][0]['target_revenue'] - $dataBulanSekarang[$ktg][0]['rev']
        ],
        'okr' => [
            'trx' => ($dataBulanSekarang[$ktg][0]['trx'] / $dataTarget[$ktg][0]['target_transaksi']) * 100,
            'rev' => ($dataBulanSekarang[$ktg][0]['rev'] / $dataTarget[$ktg][0]['target_revenue']) * 100,
        ]
    ];
    array_push($dataTable, $data);
}