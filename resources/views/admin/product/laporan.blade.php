<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
            background-color: #ffffff; /* bg putih bersih */
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #000000;
        }

        .print-date {
            text-align: center;
            font-size: 11px;
            color: #555;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .status-active {
            color: #155724;
            font-weight: bold;
        }

        .status-nonaktif {
            color: #6c757d;
            font-weight: bold;
        }

        td.desc-cell {
            max-width: 250px;
            white-space: normal;
            word-wrap: break-word;
            text-align: center;
        }

        tr,
        td,
        th {
            page-break-inside: avoid !important;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        .signature {
            margin-top: 60px;
            width: 100%;
        }

        .signature-box {
            width: 250px;
            float: right;
            text-align: center;
        }

        .signature-box p.name {
            font-weight: bold;
            text-decoration: underline;
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
                background-color: #ffffff;
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

    <h2>Daftar Produk Waroeng Koe Ree Cake & Cookies</h2>

    <p class="print-date">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Berat</th>
                <th>Status</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produks as $key => $produk)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $produk->nama }}</td>
                    <td>{{ $produk->kategori->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>{{ $produk->berat }} gr</td>
                    <td class="{{ $produk->status === 'aktif' ? 'status-active' : 'status-nonaktif' }}">
                        {{ ucfirst($produk->status) }}
                    </td>
                    <td class="desc-cell">
                        {{ \Illuminate\Support\Str::limit($produk->deskripsi, 150) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div class="signature-box">
            <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Owner</p>
            <br><br><br><br>
            <p class="name">Desmawati Retno Dwi Hastuti</p>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} |
        Laporan Keuangan Waroeng Koe Ree Cake & Cookies
    </div>

</body>

</html>
