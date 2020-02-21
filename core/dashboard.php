<?php
require_once('connection.php');

$dataTable = [];

// Select kategori
$getKategori = $db->query("select * from kategori where id_kategori != 8 and id_kategori != 10 order by id_kategori asc")->fetchAll(PDO::FETCH_ASSOC);
$dataKategori = [];

// Base Query
$baseQuery = "select sum(jml_transaksi) as trx, sum(nilai_jual) as rev from resume_transaksi_outlet_harian";
$lastMonth = "tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')";
$thisMonth = "tanggal between date_trunc('month', current_date) and current_date";


// SBF
$sbf = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$sbfPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

// Outlet Retail
$retail = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where substring(id_outlet, -2, 5) not in('HH', 'SP') and tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$retailPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where substring(id_outlet, -2, 5) not in('HH', 'SP') and tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

// H2H
$h2h = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where substring(id_outlet, -2, 5) in('HH', 'SP') and tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$h2hPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where substring(id_outlet, -2, 5) in('HH', 'SP') and tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

foreach ($getKategori as $ktg) {
    array_push($dataKategori, $ktg['kategori']);
}


$currentMonth = date("m");
$currentYear = date("Y");
$dataTarget = $db->query("select * from target_marketing where bulan = $currentMonth and tahun = $currentYear and id_kategori != 8 and id_kategori != 10 order by id_kategori asc")->fetchAll(PDO::FETCH_ASSOC);

// Data Bulan lalu
$dataBulanLalu = [];
$dataBulanLalu[0] = $db->query("$baseQuery where substring(id_outlet, -2, 5) not in('HH', 'SP') and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[1] = $db->query("$baseQuery where id_outlet in( select id_outlet from mt_outlet where upline in ('FA146895', 'FA207324')) and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[2] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 500') and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[3] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 600') and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[4] = $db->query("$baseQuery where id_produk like 'TP%' or id_produk like '%KAI' and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[5] = $db->query("$baseQuery where id_produk in ('LOGLION', 'LOGIDL') and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanLalu[6] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 15 H2H') and $lastMonth")->fetchAll(PDO::FETCH_ASSOC);

// Data Bulan ini
$dataBulanSekarang = [];
$dataBulanSekarang[0] = $db->query("$baseQuery where substring(id_outlet, -2, 5) not in('HH', 'SP') and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[1] = $db->query("$baseQuery where id_outlet in( select id_outlet from mt_outlet where upline in ('FA146895', 'FA207324')) and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[2] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 500') and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[3] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 600') and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[4] = $db->query("$baseQuery where id_produk like 'TP%' or id_produk like '%KAI' and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[5] = $db->query("$baseQuery where id_produk in ('LOGLION', 'LOGIDL') and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);
$dataBulanSekarang[6] = $db->query("$baseQuery where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 15 H2H') and $thisMonth")->fetchAll(PDO::FETCH_ASSOC);

$grafikTarget = [];
$grafikBulanLalu = [];
$grafikBulanSekarang = [];

// Membuat data untuk grafik target bulanan
foreach ($dataTarget as $dt) {
    array_push($grafikTarget, $dt['target_revenue']);
}

// Membuat data untuk grafik bulan lalu
foreach ($dataBulanLalu as $dbl) {
    array_push($grafikBulanLalu, intval($dbl[0]['rev']));
}

// Membuat data untuk grafik bulan ini
foreach ($dataBulanSekarang as $dbs) {
    array_push($grafikBulanSekarang, intval($dbs[0]['rev']));
}

for ($i = 0; $i < count($dataKategori); $i++) {
    $data = [
        'kategori' => $dataKategori[$i],
        'target' => [
            'trx' => $dataTarget[$i]['target_transaksi'],
            'rev' => $dataTarget[$i]['target_revenue']
        ],
        'bulan_lalu' => [
            'trx' => intval($dataBulanLalu[$i][0]['trx']),
            'rev' => intval($dataBulanLalu[$i][0]['rev'])
        ],
        'bulan_ini' => [
            'trx' => intval($dataBulanSekarang[$i][0]['trx']),
            'rev' => intval($dataBulanSekarang[$i][0]['rev'])
        ],
        'deviasi' => [
            'trx' => ($dataBulanSekarang[$i][0]['trx'] - $dataBulanLalu[$i][0]['trx']),
            'rev' => ($dataBulanSekarang[$i][0]['rev'] - $dataBulanLalu[$i][0]['rev'])
        ],
        'deviasi_okr' => [
            'trx' => $dataTarget[$i]['target_transaksi'] - $dataBulanSekarang[$i][0]['trx'],
            'rev' => $dataTarget[$i]['target_revenue'] - $dataBulanSekarang[$i][0]['rev']
        ],
        'okr' => [
            'trx' => $dataBulanSekarang[$i][0]['trx'] / $dataTarget[$i]['target_transaksi'] * 100,
            'rev' => $dataBulanSekarang[$i][0]['rev'] / $dataTarget[$i]['target_revenue'] * 100
        ]
    ];

    array_push($dataTable, $data);
}
