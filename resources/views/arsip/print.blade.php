<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Arsip - Kecamatan Mandalajati</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .header-container {
            display: flex;
            align-items: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-instansi {
            width: 75px;
            height: auto;
            margin-right: 15px;
        }
        .header-surat {
            text-align: center;
            flex-grow: 1;
        }
        .header-surat h3, .header-surat h4, .header-surat p {
            margin: 2px 0;
        }
        .judul-laporan {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 13px;
            vertical-align: middle;
        }
        table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .ttd-section {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 20px;
        }
        .ttd-space {
            height: 70px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- KOP SURAT DENGAN LOGO -->
    <div class="header-container">
        <!-- Ganti 'logo.png' dengan nama file logo pemkot/kabupaten kamu di folder public/images/ -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo Instansi" class="logo-instansi" onerror="this.style.display='none'">
        
        <div class="header-surat">
            <h4>PEMERINTAH KOTA BANDUNG</h4>
            <h4>KECAMATAN MANDALAJATI</h4>
            <h3>KANTOR KECAMATAN MANDALAJATI</h3>
            <p style="font-size: 12px;">Jl. Pasir Impun No.33A Telp (022) 123456 Bandung</p>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="judul-laporan">
        Laporan Rekapitulasi Data Arsip Surat Kecamatan Mandalajati
    </div>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th style="width: 150px;">No. Registrasi</th>
                <th style="width: 100px;">Kode Arsip</th>
                <th>Perihal / Nama Arsip</th>
                <th style="width: 100px;">Tgl Arsip</th>
                <th style="width: 80px;">Retensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arsip as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nomor_registrasi }}</td>
                <td class="text-center">{{ $item->kode_arsip }}</td>
                <td>{{ $item->nama_arsip }}</td>
                <td class="text-center">{{ $item->tanggal_arsip }}</td>
                <td class="text-center">{{ $item->retensi_tahun }} Thn</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data arsip yang tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="ttd-section">
        <p>Bandung, {{ date('d F Y') }}</p>
        <p><strong>Camat Mandalajati</strong></p>
        <div class="ttd-space"></div>
        <p><strong><u>( Nama Pimpinan, S.IP., M.Si )</u></strong></p>
        <p>NIP. 19800101 200501 1 001</p>
    </div>

</body>
</html>