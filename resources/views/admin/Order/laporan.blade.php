<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 10mm 20mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            padding: 20px;
            background: #fff;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            color: #0d6efd;
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
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: top;
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

        .summary-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #000;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <h2>Laporan Penjualan Waroeng Koe Ree Cake & Cookies</h2>

    <p class="subtitle">
        Periode:
        {{ $bulan ? \Carbon\Carbon::createFromDate($tahun ?? now()->year, $bulan, 1)->translatedFormat('F') : 'Semua Bulan' }}
        {{ $tahun ?? '' }}
    </p>

    <p class="print-date">
        Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
    </p>

    {{-- Tabel laporan --}}
    <table>
        <thead>
            <tr>
                <th style="width:25px;">No</th>
                <th>Kode Order</th>
                <th>Tanggal Order</th>
                <th>Nama Customer</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Metode Pengiriman</th>
                <th>Produk (Jumlah)</th>
                <th>Status Pengiriman</th>
                <th>Total Harga (Rp)</th>
                <th>Laba (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $grandTotal = 0;
                $grandLaba = 0;
            @endphp

            @forelse($orders as $order)
                @php
                    $produkList = $order->orderDetails
                        ->map(function ($d) {
                            return ($d->produk->nama ?? '-') . " ({$d->jumlah})";
                        })
                        ->implode('<br>');

                    $totalOrder = $order->orderDetails->sum('total');
                    $totalModal = $order->orderDetails->sum(fn($d) => $d->harga_modal * $d->jumlah);
                    $labaOrder = $totalOrder - $totalModal;

                    $grandTotal += $totalOrder;
                    $grandLaba += $labaOrder;
                @endphp

                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $order->order_code }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td class="text-left">{{ $order->nama ?? '-' }}</td>
                    <td class="text-left">{{ $order->alamat ?? '-' }}</td>
                    <td class="text-center">{{ $order->phone_number ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($order->shipping_method) ?? '-' }}</td>
                    <td class="text-left">{!! $produkList !!}</td>
                    <td class="text-center">{{ ucfirst($order->shipping_status ?? '-') }}</td>
                    <td class="text-end">Rp {{ number_format($totalOrder, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($labaOrder, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data pesanan.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
                <tr class="summary-row">
                    <td></td>
                    <td colspan="8" class="text-end">Grand Total</td>
                    <td class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    <td class="text-center">Rp {{ number_format($grandLaba, 0, ',', '.') }}</td>
                </tr>
        </tfoot>
    </table>

    {{-- Tanda tangan --}}
    <div style="margin-top: 60px; width:100%;">
        <div style="width:250px; float:right; text-align:center;">
            <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Owner</p>
            <br><br><br><br>
            <p style="font-weight:bold; text-decoration:underline;">
                Desmawati Retno Dwi Hastuti
            </p>
        </div>
    </div>

    <div style="clear:both;"></div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }} |
        Laporan Penjualan Waroeng Koe Ree Cake & Cookies
    </div>

</body>

</html>
