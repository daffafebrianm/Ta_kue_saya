<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 5mm 15mm 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            /* lebih kecil */
            padding: 10px;
            background: #fff;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .subtitle {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 11px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 4px;
            /* lebih kecil */
            vertical-align: middle;
            font-size: 8.5px;
            /* lebih kecil */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
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
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            border-top: 1px solid #000;
            padding-top: 3px;
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

    {{-- 🔹 Periode Dinamis --}}
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

    {{-- 🔹 Rincian Penjualan --}}
    <h3>Rincian Penjualan</h3>

    <table>
        <thead>
            <tr>
                <th style="width: 15px;">No</th>
            <th style="width: 60px;">Kode Order</th>
            <th style="width: 60px;">Tanggal</th>
            <th style="width: 100px;">Nama Customer</th>
            <th style="width: 90px;">Produk</th>
            <th style="width: 60px;">Modal (Rp)</th>
            <th style="width: 60px;">Harga (Rp)</th>
            <th style="width: 30px;">Qty</th>
            <th style="width: 60px;">Total (Rp)</th>
            <th style="width: 60px;">Laba (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $total_modal_global = 0;
                $total_penjualan_global = 0;
                $total_laba_global = 0;
            @endphp

            @forelse ($orders as $order)
                @php $jumlah_produk = count($order->orderDetails); @endphp

                @foreach ($order->orderDetails as $index => $detail)
                    @php
                        $modal = ($detail->harga_modal ?? 0) * ($detail->jumlah ?? 0);
                        $harga = ($detail->harga ?? 0) * ($detail->jumlah ?? 0);
                        $total = $detail->total ?? ($detail->harga ?? 0) * ($detail->jumlah ?? 0);
                        $laba = (($detail->harga ?? 0) - ($detail->harga_modal ?? 0)) * ($detail->jumlah ?? 0);

                        $total_modal_global += $modal;
                        $total_penjualan_global += $total;
                        $total_laba_global += $laba;
                    @endphp

                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $jumlah_produk }}" class="text-center">{{ $no++ }}</td>
                            <td rowspan="{{ $jumlah_produk }}" class="text-center">{{ $order->order_code ?? '-' }}</td>
                            <td rowspan="{{ $jumlah_produk }}" class="text-center">
                                {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</td>
                            <td rowspan="{{ $jumlah_produk }}">{{ $order->nama ?? '-' }}</td>
                        @endif

                        <td>{{ $detail->produk->nama ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($detail->harga_modal ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($detail->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $detail->jumlah ?? 0 }}</td>
                        <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($laba, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                {{-- Subtotal per order --}}
                <tr class="summary-row">
                    <td colspan="5" class="text-center">Subtotal Order</td>
                    <td class="text-end">
                        Rp
                        {{ number_format($order->orderDetails->sum(fn($d) => ($d->harga_modal ?? 0) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                    </td>
                    <td>—</td>
                    <td class="text-center">{{ $order->orderDetails->sum(fn($d) => $d->jumlah) }}</td>
                    <td class="text-end">
                        Rp
                        {{ number_format($order->orderDetails->sum(fn($d) => $d->total ?? ($d->harga ?? 0) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                    </td>
                    <td class="text-end">
                        Rp
                        {{ number_format($order->orderDetails->sum(fn($d) => (($d->harga ?? 0) - ($d->harga_modal ?? 0)) * ($d->jumlah ?? 0)), 0, ',', '.') }}
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="summary-row">
                <td colspan="5" class="text-center">Total Keseluruhan</td>
                <td class="text-end">Rp {{ number_format($total_modal_global, 0, ',', '.') }}</td>
                <td>—</td>
                <td>—</td>
                <td class="text-end">Rp {{ number_format($total_penjualan_global, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($total_laba_global, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- 🔹 Ringkasan Keuangan --}}
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
                <td class="text-end">Rp {{ number_format($total_penjualan_global, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Total Modal</td>
                <td class="text-end">Rp {{ number_format($total_modal_global, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary-row">
                <td class="text-center">3</td>
                <td>Total Laba Bersih</td>
                <td class="text-end">Rp {{ number_format($total_laba_global, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- 🔹 Tanda Tangan --}}
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

    {{-- 🔹 Footer --}}
    <div class="footer">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s') }} |
        Laporan Keuangan Waroeng Koe Ree Cake & Cookies
    </div>

</body>

</html>
