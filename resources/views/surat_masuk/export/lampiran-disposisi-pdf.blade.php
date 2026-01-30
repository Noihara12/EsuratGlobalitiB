<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lampiran Disposisi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.4;
            color: #000;
        }
        
        .container {
            max-width: 100%;
            padding: 20px 25px;
        }
        
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .kop-surat img {
            max-width: 100%;
            max-height: 130px;
            height: auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 11px;
            margin-top: 10px;
            margin-bottom: 8px;
            background-color: #f0f0f0;
            padding: 5px 8px;
            border-left: 3px solid #333;
        }
        
        /* Info rows dalam 2 kolom */
        .info-rows-container {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .info-column {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            margin-right: 2%;
        }
        
        .info-column:last-child {
            margin-right: 0;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 6px;
            font-size: 11px;
        }
        
        .info-label {
            width: 120px;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .info-value {
            flex: 1;
            padding-left: 5px;
            border-bottom: 1px dotted #ccc;
            word-wrap: break-word;
        }
        
        .disposisi-item {
            background-color: #f9f9f9;
            padding: 8px;
            margin-bottom: 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        .disposisi-item .label {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
            font-size: 10px;
        }
        
        .disposisi-item .content {
            margin: 3px 0;
            padding-left: 8px;
            border-left: 2px solid #0066cc;
            font-size: 10px;
        }
        
        .signature-section {
            margin-top: 20px;
            page-break-inside: avoid;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
        }

        .signature-content {
            text-align: center;
            width: 150px;
        }
        
        .signature-image {
            max-width: 120px;
            max-height: 70px;
            margin: 0 auto 3px;
            display: block;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            display: block;
            width: 100%;
            margin: 0 auto 3px;
        }
        
        .signature-name {
            font-weight: bold;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .catatan {
            background-color: #fff8dc;
            padding: 8px;
            border-left: 3px solid #ff9800;
            margin-top: 10px;
            font-size: 10px;
        }
        
        .catatan-label {
            font-weight: bold;
            color: #ff6600;
            margin-bottom: 3px;
            font-size: 10px;
        }
        
        .catatan-content {
            margin-top: 3px;
            line-height: 1.4;
            font-size: 10px;
        }
        
        .highlight {
            color: #0066cc;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 8px;
        }
        
        table th {
            background-color: #333;
            color: white;
            padding: 5px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        
        table td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .date-location {
            font-size: 10px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <img src="{{ public_path('images/kopsurat.jpg') }}" alt="Kop Surat">
        </div>

        <!-- Header -->
        <div style="text-align: center; margin: 15px 0; padding-bottom: 10px;">
            <h2 style="font-size: 16px; font-weight: bold; margin: 0;">LAMPIRAN DISPOSISI SURAT</h2>
        </div>

        <!-- Informasi Surat Masuk -->
        <div class="section-title">INFORMASI SURAT</div>
        
        <div class="info-rows-container">
            <!-- Column 1 - Kiri -->
            <div class="info-column">
                <div class="info-row">
                    <div class="info-label">Jenis Surat</div>
                    <div class="info-value">
                        @if($suratMasuk->jenis_surat === 'rahasia')
                            RAHASIA
                        @elseif($suratMasuk->jenis_surat === 'penting')
                            PENTING
                        @else
                            BIASA
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Kode Surat</div>
                    <div class="info-value">{{ $suratMasuk->kode_surat }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Nomor Surat</div>
                    <div class="info-value">{{ $suratMasuk->nomor_surat }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Tanggal Surat</div>
                    <div class="info-value">{{ $suratMasuk->tanggal_surat->format('d/m/Y') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Asal Surat</div>
                    <div class="info-value">{{ substr($suratMasuk->asal_surat, 0, 30) }}...</div>
                </div>
            </div>
            
            <!-- Column 2 - Kanan -->
            <div class="info-column">
                <div class="info-row">
                    <div class="info-label">Tanggal Terima</div>
                    <div class="info-value">{{ $suratMasuk->created_at->format('d/m/Y') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Perihal</div>
                    <div class="info-value">{{ substr($suratMasuk->perihal, 0, 70) }}...</div>
                </div>
                
                @if($suratMasuk->file_lampiran)
                <div class="info-row">
                    <div class="info-label">File Lampiran</div>
                    <div class="info-value">Ada ({{ basename($suratMasuk->file_lampiran) }})</div>
                </div>
                @else
                <div class="info-row">
                    <div class="info-label">File Lampiran</div>
                    <div class="info-value">-</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Disposisi Details -->
        <div class="section-title">DETAIL DISPOSISI</div>
        
        @forelse($disposisi as $key => $disp)
            <div class="disposisi-item">
                <div class="label">DISPOSISI #{{ $key + 1 }} | {{ $disp->user->name ?? 'N/A' }}</div>
                
                @if($disp->isi_disposisi)
                <div class="content">
                    <strong>Isi:</strong> {{ substr($disp->isi_disposisi, 0, 80) }}...
                </div>
                @endif
                
                @if($disp->status)
                <div class="content">
                    <strong>Status:</strong> 
                    @if($disp->status === 'disposed')
                        Sudah Didisposisikan
                    @elseif($disp->status === 'received')
                        Sudah Diterima
                    @else
                        {{ ucfirst($disp->status) }}
                    @endif
                </div>
                @endif
            </div>
        @empty
            <p style="text-align: center; color: #999; font-style: italic; font-size: 10px;">Tidak ada disposisi untuk surat ini</p>
        @endforelse

        <!-- Catatan Kepala Sekolah -->
        @php
            $catatanKepalSekolah = null;
            if($disposisi && $disposisi->count() > 0) {
                foreach($disposisi as $disp) {
                    if($disp->catatan_kepala_sekolah) {
                        $catatanKepalSekolah = $disp->catatan_kepala_sekolah;
                        break;
                    }
                }
            }
        @endphp
        @if($catatanKepalSekolah)
        <div class="catatan">
            <div class="catatan-label">CATATAN KEPALA SEKOLAH</div>
            <div class="catatan-content">
                {{ substr($catatanKepalSekolah, 0, 150) }}...
            </div>
        </div>
        @endif

        <!-- Tanda Tangan Kepala Sekolah -->
        @if($suratMasuk->kepala_sekolah_id)
        <div style="margin-top: 15px;">
            <div class="date-location">
                <p style="margin: 0;">Badung, {{ now()->format('d F Y') }}</p>
                <p style="margin: 2px 0 0 0;">Kepala SMK TI Bali Global Badung</p>
            </div>
            <div class="signature-section" style="text-align: left; margin-top: 15px;">
                @php
                    $kepalSekolah = \App\Models\User::find($suratMasuk->kepala_sekolah_id);
                    $tandaTangan = \App\Models\TandaTangan::where('user_id', $suratMasuk->kepala_sekolah_id)->first();
                @endphp
                
                @if($tandaTangan && $tandaTangan->file_path)
                    @if($tandaTangan->file_type === 'pdf')
                        <div style="color: #999; font-size: 10px;">
                            [Tanda Tangan Digital]
                        </div>
                    @else
                        <img src="{{ public_path('storage/' . $tandaTangan->file_path) }}" class="signature-image" alt="Tanda Tangan">
                    @endif
                @else
                    <div class="signature-line"></div>
                @endif
                
                <div class="signature-name">
                    {{ $kepalSekolah->name ?? 'Kepala Sekolah' }}
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
