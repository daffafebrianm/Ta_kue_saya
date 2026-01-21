<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>

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
            color: #000;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #000;
            margin-bottom: 3px;
        }

        .print-date {
            text-align: center;
            font-size: 11px;
            color: #000;
            margin-bottom: 15px;
        }

        h3 {
            color: #000;
            margin-bottom: 6px;
            font-size: 13px;
            text-transform: uppercase;
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

        td.text-end {
            text-align: right;
        }

        td.text-center {
            text-align: center;
        }

        .summary-row {
            font-weight: bold;
            background-color: #f5f5f5;
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

    <h2>Laporan Keuangan Waroeng Koe Ree Cake & Cookies</h2>

    {{-- 🔹 Periode Dinamis (Bulanan / Mingguan) --}}
    <p class="subtitle">
        Periode:
        @if ($minggu)
            Minggu ke-{{ $minggu }}
            {{ $bulan ? 'Bulan ' . \DateTime::createFromFormat('!m', $bulan)->format('F') : '' }}
            {{ $tahun }}
        @else
            {{ $bulan ? \DateTime::createFromFormat('!m', $bulan)->format('F') : 'Semua Bulan' }}
            {{ $tahun }}
        @endif
    </p>

    <h3>Rincian Penjualan</h3>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 90px;">Tanggal</th>
                <th>Produk</th>
                <th style="width: 45px;">Jml</th>
                <th style="width: 80px;">Modal (Rp)</th>
                <th style="width: 80px;">Harga (Rp)</th>
                <th style="width: 80px;">Total (Rp)</th>
                <th style="width: 80px;">Laba (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($orders as $order)
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</td>
                        <td>{{ $detail->produk->nama ?? '-' }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-end">Rp {{ number_format($detail->harga_modal, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                        <td class="text-end">
                            Rp {{ number_format(($detail->harga - $detail->harga_modal) * $detail->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Ringkasan Keuangan</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Keterangan</th>
                <th class="text-end" style="width: 180px;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Total Penjualan</td>
                <td class="text-end">Rp {{ number_format($total_penjualan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Total Modal</td>
                <td class="text-end">Rp {{ number_format($total_modal, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary-row">
                <td class="text-center">3</td>
                <td>Total Laba Bersih</td>
                <td class="text-end">Rp {{ number_format($total_laba, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
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

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} |
        Laporan Keuangan Waroeng Koe Ree Cake & Cookies
    </div>

</body>
</html>
