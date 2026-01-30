<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat Keluar</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .kop-surat {
            margin-bottom: 15px;
        }
        .kop-surat img {
            max-width: 100%;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            font-size: 11px;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
            font-size: 11px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #22c55e;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #333;
            font-size: 11px;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-danger {
            background-color: #ef4444;
            color: white;
        }
        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }
        .badge-secondary {
            background-color: #6b7280;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="kop-surat">
            <img src="{{ public_path('images/kopsurat.jpg') }}" alt="Kop Surat" style="width: 100%; max-width: 100%; height: auto;">
        </div>
        <h1>LAPORAN SURAT KELUAR</h1>
        <p>Periode: {{ $dari->format('d-m-Y') }} sampai {{ $sampai->format('d-m-Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Total Surat:</strong> {{ count($suratKeluar) }} item</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Nomor Surat</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 10%;">Jenis</th>
                <th style="width: 20%;">Tujuan</th>
                <th style="width: 43%;">Perihal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suratKeluar as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nomor_surat }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        @if($item->jenis_surat === 'rahasia')
                            <span class="badge badge-danger">Rahasia</span>
                        @elseif($item->jenis_surat === 'penting')
                            <span class="badge badge-warning">Penting</span>
                        @else
                            <span class="badge badge-secondary">Biasa</span>
                        @endif
                    </td>
                    <td>{{ $item->tujuan }}</td>
                    <td>{{ substr($item->perihal, 0, 60) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #999;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
