<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 10mm 20mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            padding: 20px;
            background: #ffffff;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #000000;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            color: #000;
            margin-bottom: 10px;
        }

        .print-date {
            text-align: center;
            font-size: 11px;
            color: #000;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            font-size: 11px;
        }

        td {
            font-size: 10.5px;
        }

        td.text-left {
            text-align: left;
        }

        td.text-center {
            text-align: center;
        }

        td.text-end {
            text-align: right;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #000;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        @media print {
            body {
                background: #fff;
            }

            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
            }
        }
    </style>
</head>

<body>

    <h2>Laporan Barang Masuk</h2>

    <p class="print-date">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Produk</th>
                <th style="width: 45px;">Jumlah</th>
                <th style="width: 90px;">Harga Modal (Rp)</th>
                <th style="width: 90px;">Harga Jual (Rp)</th>
                <th style="width: 90px;">Tanggal Masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangMasuk as $bm)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $bm->produk->nama ?? '-' }}</td>
                    <td class="text-center">{{ $bm->jumlah }}</td>
                    <td class="text-end">Rp {{ number_format($bm->harga_modal, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($bm->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $bm->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="font-style: italic; color: #6c757d;">
                        Tidak ada data barang masuk pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 60px; width: 100%;">
        <div style="width: 250px; float: right; text-align: center;">
            <p>Padang, {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p>Owner</p>
            <br><br><br><br>
            <p style="font-weight: bold; text-decoration: underline;">
                Desmawati Retno Dwi Hastuti
            </p>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y, H:i:s') }} |
        Laporan Barang Masuk Waroeng Koe Ree Cake & Cookies
    </div>

</body>

</html>
