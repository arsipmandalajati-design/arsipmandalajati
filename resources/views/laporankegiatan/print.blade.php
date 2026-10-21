<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan - Kecamatan Mandalajati</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #222; line-height: 1.4; }
    .page-container { padding: 10mm 15mm; position: relative; }
    .header { display: flex; align-items: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
    .logo { width: 80px; flex-shrink: 0; }
    .logo img { width: 75px; height: auto; }
    .header-text { flex: 1; text-align: center; padding-right: 40px; }
    .header-text h2 { font-size: 17px; font-weight: bold; }
    .header-text h3 { font-size: 14px; font-weight: bold; margin: 2px 0; }
    .header-text p { font-size: 11px; color: #333; }
    .title { text-align: center; margin-bottom: 20px; }
    .title h2 { font-size: 14px; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; text-decoration: underline; }
    .title p { font-size: 11px; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    table th { background: #e2e8f0; border: 1px solid #333; padding: 6px 8px; text-align: center; font-size: 11px; font-weight: bold; }
    table td { border: 1px solid #333; padding: 6px 8px; font-size: 11px; vertical-align: top; }
    .footer-wrapper { width: 100%; margin-top: 25px; page-break-inside: avoid; }
    .footer { width: 250px; float: right; text-align: center; font-size: 11px; }
    .nama { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    @media print { @page { size: A4 landscape; margin: 15mm; } }
</style>
</head>
<body>

<div class="page-container">
    <div class="header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <div class="header-text">
            <h2>PEMERINTAH KOTA BANDUNG</h2>
            <h3>KECAMATAN MANDALAJATI</h3>
            <p>Jl. Pasir Impun No.33 Bandung | Telepon (022) XXXXXXX</p>
        </div>
    </div>

    <div class="title">
        <h2>LAPORAN REKAPITULASI KEGIATAN</h2>
        <p>Tanggal Cetak : {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Kegiatan</th>
                <th width="15%">Tanggal</th>
                <th width="12%">Jam</th>
                <th width="15%">Tempat</th>
                <th width="15%">Penyelenggara</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td><strong>{{ $item->nama_kegiatan }}</strong></td>
                <td align="center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td align="center">{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                <td>{{ $item->tempat }}</td>
                <td>{{ $item->penyelenggara }}</td>
                <td align="center">{{ $item->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" align="center" style="padding: 12px; color: #555;">Tidak ada data laporan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-wrapper">
        <div class="footer">
            <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>
            <p style="margin-top: 4px;">Mengetahui,</p>
            <p><strong>Camat Mandalajati</strong></p>
            <div class="nama">
                (................................)
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>

</body>
</html>