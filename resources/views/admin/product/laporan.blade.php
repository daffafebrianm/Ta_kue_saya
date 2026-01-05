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
            background: #f8f9fa;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #0d6efd;
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
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            color: #155724;
            font-weight: bold;
        }

        .status-nonaktif {
            color: #6c757d;
            font-weight: bold;
        }

        .desc-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        tr {
            page-break-inside: avoid !important;
        }

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

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #555;
        }

        @media print {
            body {
                background: #fff;
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
                    <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">
                        {{ \Illuminate\Support\Str::limit($produk->deskripsi, 150) }}
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} | Daftar Produk
    </div>

</body>

</html>
