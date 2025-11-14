<?php

namespace App\Http\Controllers;

use App\Models\Asisten;
use App\Models\Configuration;
use App\Models\Feedback;
use App\Models\JadwalJaga;
use App\Models\JenisPolling;
use App\Models\Kelas;
use App\Models\LaporanPraktikan;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\Polling;
use App\Models\Praktikan;
use App\Models\Role;
use App\Models\SoalFitb;
use App\Models\SoalJurnal;
use App\Models\SoalMandiri;
use App\Models\SoalTa;
use App\Models\SoalTk;
use App\Models\SoalTp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Get common request parameters
     */
    private function getCommonParams()
    {
        return [
            'comingFrom' => request('comingFrom') ?? 'none',
            'position' => request('position') ?? 0,
        ];
    }

    /**
     * Welcome page
     */
    public function welcome()
    {
        return Inertia::render('Welcome', $this->getCommonParams());
    }

    /**
     * About page
     */
    public function about()
    {
        return Inertia::render('About', $this->getCommonParams());
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return Inertia::render('Contact', $this->getCommonParams());
    }

    /**
     * Login page
     */
    public function login()
    {
        $all_kelas = Kelas::whereRaw("kelas NOT LIKE 'TOT%'")->orderBy('kelas', 'asc')->get();
        $roles = Role::all();

        return Inertia::render('Login', array_merge($this->getCommonParams(), [
            'all_kelas' => $all_kelas,
            'roles' => $roles,
        ]));
    }

    /**
     * Asisten dashboard
     */
    public function asisten()
    {
        $user = Auth::guard('asisten')->user();

        $messages = Feedback::with(['kelas', 'praktikan'])
            ->where('asisten_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $userRole = Role::find($user->role_id);

        return Inertia::render('Asisten', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'messages' => $messages,
            'userRole' => $userRole->role,
        ]));
    }

    /**
     * Praktikan dashboard
     */
    public function praktikan()
    {
        $user = Auth::guard('praktikan')->user();
        $kelas = Kelas::find($user->kelas_id);
        $user->kelas = $kelas->kelas;

        // Check if user is from TOT class (for comments feature)
        $isTotClass = substr($kelas->kelas, 0, 3) === 'TOT';

        $allAsisten = Asisten::orderBy('kode', 'asc')->get();
        $allAsistenPolling = Asisten::where('kode', '!=', 'BOT')->orderBy('kode', 'asc')->get();
        $isRunmod = Configuration::find(1)->runmod_activation;
        $pollingComplete = Polling::where('praktikan_id', $user->id)->exists();
        $allPolling = JenisPolling::all();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();
        $allJurnal = SoalJurnal::with('modul:id,judul')->get();

        return Inertia::render('Praktikan', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'isTotClass' => $isTotClass,
            'allAsisten' => $allAsisten,
            'allAsistenPolling' => $allAsistenPolling,
            'isRunmod' => $isRunmod,
            'pollingComplete' => $pollingComplete,
            'allPolling' => $allPolling,
            'allModul' => $allModul,
            'allJurnal' => $allJurnal,
        ]));
    }

    /**
     * Soal management page
     */
    public function soal()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::find($user->role_id);
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();

        // Use relationships to get all soal with their modul data
        $allTP = SoalTp::with('modul:id,judul')->get();
        $allTA = SoalTa::with('modul:id,judul')->get();
        $allTK = SoalTk::with('modul:id,judul')->get();
        $allJurnal = SoalJurnal::with('modul:id,judul')->get();
        $allMandiri = SoalMandiri::with('modul:id,judul')->get();
        $allFITB = SoalFitb::with('modul:id,judul')->get();

        return Inertia::render('Soal', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
            'allTP' => $allTP,
            'allTA' => $allTA,
            'allTK' => $allTK,
            'allJurnal' => $allJurnal,
            'allMandiri' => $allMandiri,
            'allFITB' => $allFITB,
        ]));
    }

    /**
     * Kelas management page
     */
    public function kelas()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allKelas = Kelas::all();
        $kelasPrivilege = [1, 2, 4, 5];

        if (! in_array($userRole->id, $kelasPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Kelas', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allKelas' => $allKelas,
        ]));
    }

    /**
     * Modul management page
     */
    public function modul()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();
        $modulPrivilege = [1, 2, 4, 15, 7];

        if (! in_array($userRole->id, $modulPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Modul', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
        ]));
    }

    /**
     * Plotting page
     */
    public function plotting()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::find($user->role_id);

        $allJaga = JadwalJaga::with([
            'asisten:id,kode',
            'kelas:id,kelas,hari,shift',
        ])->get()->map(fn (JadwalJaga $jadwal) => [
            'id' => $jadwal->id,
            'kelas_id' => $jadwal->kelas_id,
            'asisten_id' => $jadwal->asisten_id,
            'kode' => optional($jadwal->asisten)->kode,
            'kelas' => optional($jadwal->kelas)->kelas,
            'hari' => optional($jadwal->kelas)->hari,
            'shift' => optional($jadwal->kelas)->shift,
        ])->values();

        $allKelas = Kelas::all();
        $allAsisten = Asisten::orderBy('kode', 'asc')->get();
        $plottingPrivilege = [1, 2, 4, 5];

        if (! in_array($userRole->id, $plottingPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Plotting', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allJaga' => $allJaga,
            'allKelas' => $allKelas,
            'allAsisten' => $allAsisten,
        ]));
    }

    /**
     * Praktikum page
     */
    public function praktikum()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allKelas = Kelas::all();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();
        $isRunmod = Configuration::find(1)->runmod_activation;

        return Inertia::render('Praktikum', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allKelas' => $allKelas,
            'allModul' => $allModul,
            'isRunmod' => $isRunmod,
        ]));
    }

    /**
     * Konfigurasi page
     */
    public function konfigurasi()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $currentConfig = Configuration::find(1);
        $konfigurasiPrivilege = [1, 2, 4, 18, 7];

        if (! in_array($userRole->id, $konfigurasiPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Konfigurasi', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'currentConfig' => $currentConfig ?? 'nope',
        ]));
    }

    /**
     * Jawaban page
     */
    public function jawaban()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allModul = Modul::where('isEnglish', 0)
            ->where('id', '<', '20')
            ->orderBy('id', 'asc')
            ->get();
        $jawabanPrivilege = [1, 2, 7, 11, 15];

        if (! in_array($userRole->id, $jawabanPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Jawaban', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
        ]));
    }

    /**
     * Pelanggaran page
     */
    public function pelanggaran()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();

        $pelanggaranPrivilege = [1, 2, 4, 5, 6, 18];
        if (! in_array($userRole->id, $pelanggaranPrivilege, true)) {
            return redirect('/');
        }

        // Get all existing nilai combinations for faster lookup
        $existingNilai = Nilai::select('praktikan_id', 'modul_id', 'asisten_id')
            ->get()
            ->map(function ($nilai) {
                return "{$nilai->praktikan_id}-{$nilai->modul_id}-{$nilai->asisten_id}";
            })
            ->flip();

        // Get all asisten with their laporan
        $allAsisten = Asisten::with([
            'laporanPraktikan.praktikan:id,nama,nim,kelas_id',
        ])
            ->orderBy('kode', 'asc')
            ->get();

        // Calculate nilaiUnexists for each asisten
        foreach ($allAsisten as $asisten) {
            $nilaiUnexists = 0;

            foreach ($asisten->laporanPraktikan as $laporan) {
                $key = "{$laporan->praktikan_id}-{$laporan->modul_id}-{$laporan->asisten_id}";

                if (! $existingNilai->has($key)) {
                    $nilaiUnexists++;
                }
            }

            $asisten->nilaiUnexists = $nilaiUnexists;
        }

        return Inertia::render('Pelanggaran', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allAsisten' => $allAsisten,
        ]));
    }

    /**
     * Polling page
     */
    public function polling()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();

        $jenisPollings = JenisPolling::all();

        // Get all polling counts in a single optimized query
        $pollingCounts = Polling::select('asisten_id', 'polling_id', DB::raw('COUNT(*) as count'))
            ->groupBy('asisten_id', 'polling_id')
            ->get()
            ->groupBy('asisten_id');

        // Get all asisten
        $allAsisten = Asisten::select('id', 'kode', 'nama')
            ->orderBy('kode', 'asc')
            ->get();

        $pollingResults = $allAsisten->map(function ($asisten) use ($jenisPollings, $pollingCounts) {
            $asistenPolling = $pollingCounts->get($asisten->id, collect());

            $allPolling = $jenisPollings->map(function ($jenis) use ($asistenPolling) {
                $count = $asistenPolling->where('polling_id', $jenis->id)->first();

                return (object) [
                    'jenis' => $jenis->judul,
                    'jumlah_poll' => $count ? $count->count : 0,
                ];
            });

            return (object) [
                'id' => $asisten->id,
                'kode' => $asisten->kode,
                'nama' => $asisten->nama,
                'polling' => $allPolling,
            ];
        });

        return Inertia::render('Polling', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allJenisPollings' => $jenisPollings,
            'allPollingResults' => $pollingResults,
        ]));
    }

    /**
     * Tugas Pendahuluan page
     */
    public function tp()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allTP = DB::table('tugaspendahuluans')
            ->join('moduls', 'tugaspendahuluans.modul_id', '=', 'moduls.id')
            ->select('tugaspendahuluans.*', 'moduls.judul', 'moduls.isEnglish')->get();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();

        if ($allTP !== null) {
            foreach ($allTP as $key => $value) {
                $value->isActive = $value->isActive == '1';
            }
        }

        $tpPrivilege = [1, 2, 15, 11, 7];
        if (! in_array($userRole->id, $tpPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('TugasPendahuluan', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allTP' => $allTP ?? 'nope',
            'allModul' => $allModul,
        ]));
    }

    /**
     * Nilai page
     */
    public function nilai()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();

        $allLaporan = LaporanPraktikan::with([
            'praktikan:id,nama,nim,kelas_id',
            'praktikan.kelas:id,kelas,shift,hari',
        ])
            ->where('asisten_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($laporan) {
                // Map to flat structure for frontend compatibility
                return [
                    'id' => $laporan->id,
                    'pesan' => $laporan->pesan,
                    'asisten_id' => $laporan->asisten_id,
                    'modul_id' => $laporan->modul_id,
                    'praktikan_id' => $laporan->praktikan_id,
                    'rating_praktikum' => $laporan->rating_praktikum,
                    'rating_asisten' => $laporan->rating_asisten,
                    'created_at' => $laporan->created_at,
                    'updated_at' => $laporan->updated_at,
                    'nama' => $laporan->praktikan->nama ?? null,
                    'nim' => $laporan->praktikan->nim ?? null,
                    'kelas_id' => $laporan->praktikan->kelas_id ?? null,
                    'kelas' => $laporan->praktikan->kelas->kelas ?? null,
                    'shift' => $laporan->praktikan->kelas->shift ?? null,
                    'hari' => $laporan->praktikan->kelas->hari ?? null,
                    'nilaiExists' => Nilai::where([
                        'praktikan_id' => $laporan->praktikan_id,
                        'modul_id' => $laporan->modul_id,
                        'asisten_id' => $laporan->asisten_id,
                    ])->exists(),
                ];
            });

        return Inertia::render('Nilai', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allLaporan' => $allLaporan,
        ]));
    }

    /**
     * History page
     */
    public function history()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $asistenExist = false;
        $allAsistenHistory = [];
        $allHistory = DB::table('laporan_pjs')
            ->join('moduls', 'laporan_pjs.modul_id', '=', 'moduls.id')
            ->select('laporan_pjs.*', 'moduls.judul')->orderBy('created_at', 'desc')->get();

        foreach ($allHistory as $history => $h) {
            $asistenExist = false;
            foreach (explode('-', $h->allasisten_id) as $asisten => $a) {
                if ($a == $user->id) {
                    $asistenExist = true;
                }
            }

            if ($asistenExist) {
                array_push($allAsistenHistory, $h);
            }
        }

        return Inertia::render('History', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allHistory' => $allAsistenHistory ?? 'nope',
        ]));
    }

    /**
     * Set Praktikan page
     */
    public function setpraktikan()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();

        return Inertia::render('SetPraktikan', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
        ]));
    }

    /**
     * Lihat TP page
     */
    public function lihatTp()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();

        return Inertia::render('LihatTp', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
        ]));
    }

    /**
     * Rating page
     */
    public function rating()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();

        $RatingPrivilege = [1, 2, 4, 5, 8, 16];
        if (! in_array($userRole->id, $RatingPrivilege, true)) {
            return redirect('/');
        }

        // Get all kelas first
        $allKelas = Kelas::where('id', '!=', 12)->orderBy('kelas', 'asc')->get();

        // Get all praktikan with their aggregated nilai in a single query
        $allPraktikan = Praktikan::select(
            'praktikans.id',
            'praktikans.nama',
            'praktikans.nim',
            'kelas.kelas',
            'praktikans.kelas_id',
            DB::raw('COALESCE(SUM(nilais.rating), 0) as rating'),
            DB::raw('COALESCE(SUM(nilais.tp), 0) as tp'),
            DB::raw('COALESCE(SUM(nilais.ta), 0) as ta'),
            DB::raw('COALESCE(SUM(nilais.jurnal), 0) as jurnal'),
            DB::raw('COALESCE(SUM(nilais.tk), 0) as tk'),
            DB::raw('COALESCE(SUM(nilais.skill), 0) as skill'),
            DB::raw('COALESCE(SUM(nilais.diskon), 0) as diskon')
        )
            ->join('kelas', 'praktikans.kelas_id', '=', 'kelas.id')
            ->leftJoin('nilais', 'praktikans.id', '=', 'nilais.praktikan_id')
            ->where('kelas.id', '!=', 12)
            ->groupBy(
                'praktikans.id',
                'praktikans.nama',
                'praktikans.nim',
                'kelas.kelas',
                'praktikans.kelas_id'
            )
            ->get();

        // Calculate total for each praktikan
        foreach ($allPraktikan as $praktikan) {
            $praktikan->total = ($praktikan->tp * 0.15) +
                               ($praktikan->ta * 0.15) +
                               ($praktikan->jurnal * 0.1) +
                               ($praktikan->tk * 0.2) -
                               ($praktikan->diskon * 0.01);
        }

        // Group praktikan by kelas and sort
        $allRating = [];
        $allNilai = [];

        foreach ($allKelas as $kelas) {
            $kelasPraktikan = $allPraktikan->where('kelas_id', $kelas->id);

            // Sort by rating (descending)
            $allRating[] = $kelasPraktikan->sortByDesc('rating')->values()->all();

            // Sort by total (descending)
            $allNilai[] = $kelasPraktikan->sortByDesc('total')->values()->all();
        }

        return Inertia::render('Rating', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allRating' => $allRating,
            'allNilai' => $allNilai,
            'allKelas' => $allKelas,
        ]));
    }

    /**
     * All Laporan page
     */
    public function allLaporan()
    {
        $user = Auth::guard('asisten')->user();
        $userRole = Role::where('id', $user->role_id)->first();
        $allModul = Modul::orderBy('isEnglish', 'asc')->get();
        $allHistory = DB::table('laporan_pjs')
            ->join('moduls', 'laporan_pjs.modul_id', '=', 'moduls.id')
            ->select('laporan_pjs.*', 'moduls.judul')->orderBy('created_at', 'desc')->get();

        $allLaporanPrivilege = [1, 2, 4, 5, 6];
        if (! in_array($userRole->id, $allLaporanPrivilege, true)) {
            return redirect('/');
        }

        return Inertia::render('Laporan', array_merge($this->getCommonParams(), [
            'currentUser' => $user,
            'userRole' => $userRole->role,
            'allModul' => $allModul,
            'allHistory' => $allHistory,
        ]));
    }

    /**
     * Contact Asisten page for praktikan
     */
    public function contactAsisten()
    {
        $user = Auth::guard('praktikan')->user();
        $allAsisten = Asisten::orderBy('kode', 'asc')->get();

        return Inertia::render('ContactAsisten', [
            'allAsisten' => $allAsisten,
            'user' => $user,
        ]);
    }
}
