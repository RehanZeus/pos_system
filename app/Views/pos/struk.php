<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk #<?= esc($sale['invoice_no']) ?></title>
    <style>
        /* 1. ATUR UKURAN KERTAS SECARA FISIK */
        @page {
            size: 58mm auto; /* Lebar 58mm, Tinggi otomatis mengikuti konten */
            margin: 0;       /* Menghilangkan margin browser (header/footer tanggal) */
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px; /* Ukuran font standar struk agar tidak meluap */
            width: 48mm;    /* Lebar konten (sedikit lebih kecil dari kertas agar tidak terpotong) */
            margin: 0 auto;
            padding: 2mm 0;
            background-color: #fff;
            color: #000;
        }

        /* 2. PENGATURAN TAMPILAN CETAK */
        @media print {
            body { 
                width: 48mm; 
            }
            /* Menghilangkan elemen yang tidak perlu jika ada */
            .no-print { display: none; }
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .dashed { border-top: 1px dashed #000; margin: 5px 0; }
        
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
    </style>
</head>
<body onload="window.print();">

    <div class="text-center">
        <div class="fw-bold" style="font-size: 13px;"><?= esc($store_name) ?></div>
        <div><?= esc($store_address) ?></div>
        <div><?= esc($store_phone) ?></div>
    </div>

    <div class="dashed"></div>

    <div style="font-size: 10px;">
        No : <?= esc($sale['invoice_no']) ?><br>
        Ksr: <?= esc($sale['cashier_name']) ?><br>
        Tgl: <?= date('d/m/y H:i', strtotime($sale['created_at'])) ?>
    </div>

    <div class="dashed"></div>

    <table>
        <?php foreach($items as $item): ?>
        <tr>
            <td colspan="2"><?= esc($item['product_name']) ?></td>
        </tr>
        <tr>
            <td><?= $item['qty'] ?> x <?= number_format($item['price_at_time'], 0,',','.') ?></td>
            <td class="text-right"><?= number_format($item['subtotal'], 0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="dashed"></div>

    <table>
        <tr>
            <td>TOTAL</td>
            <td class="text-right fw-bold" style="font-size: 12px;"><?= number_format($sale['total_price'], 0,',','.') ?></td>
        </tr>
        <tr>
            <td>TUNAI</td>
            <td class="text-right"><?= number_format($sale['pay_amount'], 0,',','.') ?></td>
        </tr>
        <tr>
            <td class="fw-bold">KEMBALI</td>
            <td class="text-right fw-bold"><?= number_format($sale['pay_amount'] - $sale['total_price'], 0,',','.') ?></td>
        </tr>
    </table>

    <div class="dashed"></div>

    <div class="text-center" style="margin-top: 10px; font-size: 10px;">
        TERIMA KASIH<br>
        BARANG TIDAK DAPAT DITUKAR
    </div>

</body>
</html>