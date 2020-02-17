<?php
require_once('connection.php');
$dataTable = [];

// Kategori
$getKategori = $db->query("select kategori from kategori")->fetchAll(PDO::FETCH_ASSOC);
$kategori = array();

foreach ($getKategori as $ktg) {
    array_push($kategori, $ktg['kategori']);
}

// SBF
$sbf = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$sbfPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

// Outlet Retail
$retail = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where id_outlet not like 'HH%' or id_outlet not like 'SP%' and tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$retailPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where id_outlet not like 'HH%' or id_outlet not like 'SP%' and tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

// H2H
$h2h = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where id_outlet like 'HH%' or id_outlet like 'SP%' and tanggal between date_trunc('month', current_date) and current_date")
    ->fetch(PDO::FETCH_ASSOC);
$h2hPass = $db->query("select sum(nilai_jual) as rev, sum(jml_transaksi) as trx from resume_transaksi_outlet_harian where id_outlet like 'HH%' or id_outlet like 'SP%' and tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')")
    ->fetch(PDO::FETCH_ASSOC);

// Target Revenue saat ini
$currentMonth = date("m");
$currentYear = date("Y");
$revenue = $db->query("select * from target_marketing where bulan = $currentMonth and tahun = $currentYear order by id_kategori asc");
$targetRevenue = [];
$targetTransaksi = [];

foreach ($revenue->fetchAll(PDO::FETCH_ASSOC) as $r) {
    array_push($targetRevenue, $r['target_revenue']);
    array_push($targetTransaksi, $r['target_transaksi']);
}

// Revenue bulan lalu sesuai tanggal berjalan
$baseQueryFirst = "select sum(jml_transaksi) as trx, sum(nilai_jual) as rev from resume_transaksi_outlet_harian";
$baseQueryLast = "tanggal between date_trunc('month', NOW() - interval '1 month') and date_trunc('day', NOW() - interval '1 month')";
$revenueLalu = [];
$trxLalu = [];
$resultRevenueLalu = [];
$revenueLalu['tomo'] = $db->query("$baseQueryFirst where id_produk = 'SBF' and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

$revenueLalu['minimarket'] = $db->query("$baseQueryFirst where id_outlet in( select id_outlet from mt_outlet where upline in ('FA146895', 'FA207324')) and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

$revenueLalu['top500'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 500') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueLalu['top600'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 600') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

$revenueLalu['travel'] = $db->query("$baseQueryFirst where id_produk like 'TP%' or id_produk like '%KAI' and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueLalu['ekspedisi'] = $db->query("$baseQueryFirst where id_produk in ('LOGLION', 'LOGIDL') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueLalu['top15h2h'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 15 H2H') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

foreach ($revenueLalu as $rl) {
    array_push($resultRevenueLalu, intval($rl['rev']));
    array_push($trxLalu, intval($rl['trx']));
}

// Revenue bulan sekarang sesuai tanggal berjalan
$baseQueryFirst = "select sum(jml_transaksi) as trx, sum(nilai_jual) as rev from resume_transaksi_outlet_harian";
$baseQueryLast = "tanggal between date_trunc('month', current_date) and current_date";
$revenueSekarang = [];
$trxSekarang = [];
$resultRevenueSekarang = [];
$revenueSekarang['tomo'] = $db->query("$baseQueryFirst where id_produk = 'SBF' and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

$revenueSekarang['minimarket'] = $db->query("$baseQueryFirst where id_outlet in( select id_outlet from mt_outlet where upline in ('FA146895', 'FA207324')) and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

$revenueSekarang['top500'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 500') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueSekarang['top600'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 600') and $baseQueryLast")
->fetch(PDO::FETCH_ASSOC);

$revenueSekarang['travel'] = $db->query("$baseQueryFirst where id_produk like 'TP%' or id_produk like '%KAI' and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueSekarang['ekspedisi'] = $db->query("$baseQueryFirst where id_produk in ('LOGLION', 'LOGIDL') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);
$revenueSekarang['top15h2h'] = $db->query("$baseQueryFirst where id_outlet in(select id_outlet from dashboard_top_outlet where kategori='Top 15 H2H') and $baseQueryLast")
    ->fetch(PDO::FETCH_ASSOC);

foreach ($revenueSekarang as $rl) {
    array_push($resultRevenueSekarang, intval($rl['rev']));
    array_push($trxSekarang, intval($rl['trx']));
}

$dataTable = [
    [
        'kategori' => $kategori[0],
        'target' => [
            'trx' => number_format($targetTransaksi[0], 0, ',', '.'),
            'rev' => number_format($targetRevenue[0], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[0], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[0], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[0], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[0], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[0] - $trxLalu[0], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[0] - $resultRevenueLalu[0], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[0] - $trxSekarang[0], 0, ',', '.'),
            'rev' => number_format($targetRevenue[0] - $resultRevenueSekarang[0], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[0] / $targetTransaksi[0]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[0] / $targetRevenue[0]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[1],
        'target' => [
            'trx' => number_format($targetTransaksi[1], 0, ',', '.'),
            'rev' => number_format($targetRevenue[1], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[1], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[1], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[1], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[1], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[1] - $trxLalu[1], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[1] - $resultRevenueLalu[1], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[1] - $trxSekarang[1], 0, ',', '.'),
            'rev' => number_format($targetRevenue[1] - $resultRevenueSekarang[1], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[1] / $targetTransaksi[1]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[1] / $targetRevenue[1]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[2],
        'target' => [
            'trx' => number_format($targetTransaksi[2], 0, ',', '.'),
            'rev' => number_format($targetRevenue[2], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[2], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[2], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[2], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[2], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[2] - $trxLalu[2], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[2] - $resultRevenueLalu[2], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[2] - $trxSekarang[2], 0, ',', '.'),
            'rev' => number_format($targetRevenue[2] - $resultRevenueSekarang[2], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[2] / $targetTransaksi[2]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[2] / $targetRevenue[2]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[3],
        'target' => [
            'trx' => number_format($targetTransaksi[3], 0, ',', '.'),
            'rev' => number_format($targetRevenue[3], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[3], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[3], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[3], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[3], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[3] - $trxLalu[3], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[3] - $resultRevenueLalu[3], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[3] - $trxSekarang[3], 0, ',', '.'),
            'rev' => number_format($targetRevenue[3] - $resultRevenueSekarang[3], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[3] / $targetTransaksi[3]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[3] / $targetRevenue[3]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[4],
        'target' => [
            'trx' => number_format($targetTransaksi[4], 0, ',', '.'),
            'rev' => number_format($targetRevenue[4], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[4], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[4], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[4], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[4], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[4] - $trxLalu[0], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[4] - $resultRevenueLalu[4], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[4] - $trxSekarang[4], 0, ',', '.'),
            'rev' => number_format($targetRevenue[4] - $resultRevenueSekarang[4], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[4] / $targetTransaksi[4]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[4] / $targetRevenue[4]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[5],
        'target' => [
            'trx' => number_format($targetTransaksi[5], 0, ',', '.'),
            'rev' => number_format($targetRevenue[5], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[5], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[5], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[5], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[5], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[5] - $trxLalu[5], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[5] - $resultRevenueLalu[1], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[5] - $trxSekarang[5], 0, ',', '.'),
            'rev' => number_format($targetRevenue[5] - $resultRevenueSekarang[5], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[5] / $targetTransaksi[5]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[5] / $targetRevenue[5]) * 100, 2, ',', ',') .'%'
        ]
    ],
    [
        'kategori' => $kategori[6],
        'target' => [
            'trx' => number_format($targetTransaksi[6], 0, ',', '.'),
            'rev' => number_format($targetRevenue[6], 0, ',', '.')
        ],
        'bulan_lalu' => [
            'trx' => number_format($trxLalu[6], 0, ',', '.'),
            'rev' => number_format($resultRevenueLalu[6], 0, ',', '.')
        ],
        'bulan_ini' => [
            'trx' => number_format($trxSekarang[6], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[6], 0, ',', '.')
        ],
        'deviasi' => [
            'trx' => number_format($trxSekarang[6] - $trxLalu[6], 0, ',', '.'),
            'rev' => number_format($resultRevenueSekarang[6] - $resultRevenueLalu[6], 0, ',', '.')
        ],
        'deviasi_okr' => [
            'trx' => number_format($targetTransaksi[6] - $trxSekarang[6], 0, ',', '.'),
            'rev' => number_format($targetRevenue[6] - $resultRevenueSekarang[6], 0, ',', '.')
        ],
        'okr' => [
            'trx' => number_format(($trxSekarang[6] / $targetTransaksi[6]) * 100, 2, ',', ',') .'%',
            'rev' => number_format(($resultRevenueSekarang[6] / $targetRevenue[6]) * 100, 2, ',', ',') .'%'
        ]
    ],
];
