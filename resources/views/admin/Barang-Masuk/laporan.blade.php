<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #d1d5db;
        }
        th {
            background-color: #f3f4f6;
            color: #111827;
            padding: 8px;
            font-weight: 600;
            text-align: center;
        }
        td {
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <h2>Laporan Data Barang Masuk</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Modal (Rp)</th>
                <th>Harga Jual (Rp)</th>
                <th>Tanggal Masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuk as $bm)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td >{{ $bm->produk->nama ?? '-' }}</td>
                    <td>{{ $bm->jumlah }}</td>
                    <td>Rp {{ number_format($bm->harga_modal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($bm->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d/m/Y') }}</td>
                    <td >{{ $bm->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
    </div>

</body>
</html>
