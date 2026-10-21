<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pejabat;
use App\Models\Arsip;
use App\Models\Agenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik (Total Arsip dihapus)
        $totalSuratMasuk  = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalAgenda      = Agenda::count();
        $totalUser        = User::count();
        $totalPejabat     = Pejabat::count();
    
        // Agenda Besok
        $agendaBesok = Agenda::whereDate(
                'tanggal',
                Carbon::tomorrow()
            )
            ->where('status','Terjadwal')
            ->get();
    
        // Chart Surat Masuk
        $chart = DB::table('surat_masuks')
            ->selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal_surat)')
            ->pluck('total','bulan');
    
        $dataChart = [];
    
        for($i=1;$i<=12;$i++){
            $dataChart[] = $chart[$i] ?? 0;
        }
    
        // Aktivitas Terbaru
        $aktivitas = collect()
    
            ->merge(
                SuratMasuk::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-envelope-fill',
                        'warna'=>'success',
                        'judul'=>'Surat Masuk',
                        'isi'=>$item->judul ?? $item->perihal ?? '-',
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                SuratKeluar::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-send-fill',
                        'warna'=>'primary',
                        'judul'=>'Surat Keluar',
                        'isi'=>$item->judul ?? $item->perihal ?? '-',
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                Agenda::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-calendar-event-fill',
                        'warna'=>'warning',
                        'judul'=>'Agenda',
                        'isi'=>$item->nama_kegiatan,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                Arsip::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-folder-fill',
                        'warna'=>'info',
                        'judul'=>'Arsip',
                        'isi'=>$item->nama_arsip,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->sortByDesc('waktu')
            ->take(6);
    
        $hour = now()->hour;

        if ($hour >= 5 && $hour < 11) {
            $greeting = "☀️ Selamat Pagi";
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = "🌤 Selamat Siang";
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = "🌥 Selamat Sore";
        } else {
            $greeting = "🌙 Selamat Malam";
        }

        // Agenda terbaru
        $agendaTerbaru = Agenda::latest()
            ->take(5)
            ->get();

        $belumVerifikasi = SuratMasuk::where(
            'status',
            'Belum Disposisi'
        )->count();

        // Surat Keluar Pending / Belum di-ACC (Khusus Pegawai yang login)
        $suratKeluarPending = SuratKeluar::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        // Pengingat Agenda Selesai tapi Belum Ada Laporan/Notulen (Pastikan tabel agendas sudah memiliki kolom notulen atau ganti kolomnya)
        $agendaBelumLaporan = Agenda::where('status', 'Selesai')
            ->where(function($q) {
                $q->whereNull('notulen')->orWhere('notulen', '');
            })
            ->get();

        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalAgenda',
            'totalUser',
            'totalPejabat',
            'aktivitas',
            'agendaBesok',
            'agendaTerbaru',
            'belumVerifikasi',
            'suratKeluarPending',
            'agendaBelumLaporan',
            'greeting'
        ));
    }
}