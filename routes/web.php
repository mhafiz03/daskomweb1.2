<?php

use App\Http\Controllers\AsistenController;
use App\Http\Controllers\Auth\AsistenLoginController;
use App\Http\Controllers\Auth\PraktikanLoginController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CurrentPraktikumController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HistoryIzinController;
use App\Http\Controllers\HistoryJagaController;
use App\Http\Controllers\JadwalJagaController;
use App\Http\Controllers\JawabanFitbController;
use App\Http\Controllers\JawabanJurnalController;
use App\Http\Controllers\JawabanMandiriController;
use App\Http\Controllers\JawabanSnapshotController;
use App\Http\Controllers\JawabanTaController;
use App\Http\Controllers\JawabanTkController;
use App\Http\Controllers\JawabanTpController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KumpulTpController;
use App\Http\Controllers\LaporanPjController;
use App\Http\Controllers\LaporanPraktikanController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PollingController;
use App\Http\Controllers\PraktikanController;
use App\Http\Controllers\PraktikanLihatJawabanController;
use App\Http\Controllers\PraktikumController;
use App\Http\Controllers\SoalCommentController;
use App\Http\Controllers\SoalFitbController;
use App\Http\Controllers\SoalJurnalController;
use App\Http\Controllers\SoalMandiriController;
use App\Http\Controllers\SoalTaController;
use App\Http\Controllers\SoalTkController;
use App\Http\Controllers\SoalTpController;
use App\Http\Controllers\TempJawabantpController;
use App\Http\Controllers\TugaspendahuluanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

// Public Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/', [PageController::class, 'welcome'])->name('welcome');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/login', [PageController::class, 'login'])->name('login');
});

// Authentication Routes
Route::prefix('auth')->name('auth.')->group(function () {
    // Login routes
    Route::post('/asisten/login', [AsistenLoginController::class, 'login'])->name('asisten.login');
    Route::post('/praktikan/login', [PraktikanLoginController::class, 'login'])->name('praktikan.login');

    // Signup routes
    Route::post('/asisten/signup', [AsistenController::class, 'store'])->name('asisten.signup');
    Route::post('/praktikan/signup', [PraktikanController::class, 'store'])->name('praktikan.signup');

    // Logout routes
    Route::get('/asisten/logout', [AsistenLoginController::class, 'logout'])->name('asisten.logout');
    Route::get('/praktikan/logout', [PraktikanLoginController::class, 'logout'])->name('praktikan.logout');
});

// Asisten Routes
Route::middleware('loggedIn:asisten')->prefix('asisten')->name('asisten.')->group(function () {
    // Dashboard
    Route::get('/', [PageController::class, 'asisten'])->name('dashboard');

    // Pages
    Route::get('/soal', [PageController::class, 'soal'])->name('soal');
    Route::get('/kelas', [PageController::class, 'kelas'])->name('kelas');
    Route::get('/modul', [PageController::class, 'modul'])->name('modul');
    Route::get('/plotting', [PageController::class, 'plotting'])->name('plotting');
    Route::get('/praktikum', [PageController::class, 'praktikum'])->name('praktikum');
    Route::get('/konfigurasi', [PageController::class, 'konfigurasi'])->name('konfigurasi');
    Route::get('/jawaban', [PageController::class, 'jawaban'])->name('jawaban');
    Route::get('/pelanggaran', [PageController::class, 'pelanggaran'])->name('pelanggaran');
    Route::get('/polling', [PageController::class, 'polling'])->name('polling');
    Route::get('/tp', [PageController::class, 'tp'])->name('tp');
    Route::get('/nilai', [PageController::class, 'nilai'])->name('nilai');
    Route::get('/history', [PageController::class, 'history'])->name('history');
    Route::get('/setpraktikan', [PageController::class, 'setpraktikan'])->name('setpraktikan');
    Route::get('/rating', [PageController::class, 'rating'])->name('rating');
    Route::get('/allLaporan', [PageController::class, 'allLaporan'])->name('legacy.laporan');
    Route::get('/laporan', [PageController::class, 'allLaporan'])->name('laporan');

    // Profile
    Route::get('/profil/{asisten_id}', [AsistenController::class, 'show'])->name('profil');
    Route::post('/update-desc', [AsistenController::class, 'updateDesc'])->name('update_desc');

    // Feedback
    Route::post('/pesan', [FeedbackController::class, 'index'])->name('pesan.index');

    // Kelas Management
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::post('/kelas/{kelas_id}', [KelasController::class, 'show'])->name('kelas.show');
    Route::put('/kelas', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Modul Management
    Route::post('/modul', [ModulController::class, 'store'])->name('modul.store');
    Route::post('/modul/read', [ModulController::class, 'show'])->name('modul.show');
    Route::put('/modul', [ModulController::class, 'update'])->name('modul.update');
    Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('modul.destroy');
    Route::post('/modul/jawaban-config', [ModulController::class, 'updateJawabanConfiguration'])->name('modul.jawaban_config');

    // Soal Management - TP
    Route::post('/soal/tp', [SoalTpController::class, 'store'])->name('soal.tp.store');
    Route::put('/soal/tp', [SoalTpController::class, 'update'])->name('soal.tp.update');
    Route::delete('/soal/tp/{id}', [SoalTpController::class, 'destroy'])->name('soal.tp.destroy');

    // Soal Management - TA
    Route::post('/soal/ta', [SoalTaController::class, 'store'])->name('soal.ta.store');
    Route::put('/soal/ta', [SoalTaController::class, 'update'])->name('soal.ta.update');
    Route::delete('/soal/ta/{id}', [SoalTaController::class, 'destroy'])->name('soal.ta.destroy');

    // Soal Management - TK
    Route::post('/soal/tk', [SoalTkController::class, 'store'])->name('soal.tk.store');
    Route::put('/soal/tk', [SoalTkController::class, 'update'])->name('soal.tk.update');
    Route::delete('/soal/tk/{id}', [SoalTkController::class, 'destroy'])->name('soal.tk.destroy');

    // Soal Management - Jurnal
    Route::post('/soal/jurnal', [SoalJurnalController::class, 'store'])->name('soal.jurnal.store');
    Route::put('/soal/jurnal', [SoalJurnalController::class, 'update'])->name('soal.jurnal.update');
    Route::delete('/soal/jurnal/{id}', [SoalJurnalController::class, 'destroy'])->name('soal.jurnal.destroy');

    // Soal Management - Mandiri
    Route::post('/soal/mandiri', [SoalMandiriController::class, 'store'])->name('soal.mandiri.store');
    Route::put('/soal/mandiri', [SoalMandiriController::class, 'update'])->name('soal.mandiri.update');
    Route::delete('/soal/mandiri/{id}', [SoalMandiriController::class, 'destroy'])->name('soal.mandiri.destroy');

    // Soal Management - FITB
    Route::post('/soal/fitb', [SoalFitbController::class, 'store'])->name('soal.fitb.store');
    Route::put('/soal/fitb', [SoalFitbController::class, 'update'])->name('soal.fitb.update');
    Route::delete('/soal/fitb/{id}', [SoalFitbController::class, 'destroy'])->name('soal.fitb.destroy');

    // Jadwal Jaga
    Route::post('/jadwal-jaga', [JadwalJagaController::class, 'store'])->name('jadwal_jaga.store');
    Route::delete('/jadwal-jaga', [JadwalJagaController::class, 'delete'])->name('jadwal_jaga.delete');
    Route::delete('/jadwal-jaga/reset', [JadwalJagaController::class, 'destroy'])->name('jadwal_jaga.reset');

    // Praktikum Management
    Route::post('/praktikum/check', [PraktikumController::class, 'index'])->name('praktikum.check');
    Route::post('/praktikum', [PraktikumController::class, 'store'])->name('praktikum.store');

    // Current Praktikum
    Route::post('/praktikum/start', [CurrentPraktikumController::class, 'store'])->name('praktikum.start');
    Route::put('/praktikum/continue/{status}', [CurrentPraktikumController::class, 'update'])->name('praktikum.continue');
    Route::delete('/praktikum/stop', [CurrentPraktikumController::class, 'destroy'])->name('praktikum.stop');

    // Laporan PJ
    Route::post('/laporan-pj', [LaporanPjController::class, 'store'])->name('laporan_pj.store');
    Route::post('/laporan-pj/current', [LaporanPjController::class, 'show'])->name('laporan_pj.current');
    Route::put('/laporan-pj', [LaporanPjController::class, 'update'])->name('laporan_pj.update');
    Route::delete('/laporan-pj/{id}', [LaporanPjController::class, 'destroy'])->name('laporan_pj.destroy');

    // History
    Route::post('/history/jaga', [HistoryJagaController::class, 'store'])->name('history.jaga.store');
    Route::post('/history/jaga/latest-pj', [HistoryJagaController::class, 'show'])->name('history.jaga.latest');
    Route::delete('/history/jaga', [HistoryJagaController::class, 'destroy'])->name('history.jaga.destroy');
    Route::post('/history/izin', [HistoryIzinController::class, 'store'])->name('history.izin.store');

    // Tugas Pendahuluan
    Route::post('/tp/pembahasan', [TugaspendahuluanController::class, 'store'])->name('tp.pembahasan.store');
    Route::post('/tp/activate/{modul_id}', [TugaspendahuluanController::class, 'show'])->name('tp.activate');
    Route::post('/tp/deactivate/{modul_id}', [TugaspendahuluanController::class, 'destroy'])->name('tp.deactivate');

    // Kumpul TP
    Route::post('/tp/kumpul', [KumpulTpController::class, 'store'])->name('tp.kumpul');
    Route::post('/tp/kumpul/{kelas_id}/{modul_id}', [KumpulTpController::class, 'show'])->name('tp.kumpul.show');

    // Nilai Management
    Route::post('/nilai/form/{praktikan_id}/{modul_id}', [NilaiController::class, 'index'])->name('nilai.form');
    Route::post('/nilai/jawaban/{praktikan_id}/{modul_id}', [NilaiController::class, 'list'])->name('nilai.jawaban');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::post('/nilai/{praktikan_id}/{modul_id}', [NilaiController::class, 'show'])->name('nilai.show');

    // Jawaban Details for Asisten
    Route::get('/jawaban/ta/{praktikan_id}/{modul_id}', [JawabanTaController::class, 'getAnswersWithQuestions'])->name('jawaban.ta.details');
    Route::get('/jawaban/tk/{praktikan_id}/{modul_id}', [JawabanTkController::class, 'getAnswersWithQuestions'])->name('jawaban.tk.details');

    // Praktikan Management
    Route::delete('/praktikan/alfa', [PraktikanController::class, 'destroy'])->name('praktikan.alfa');
    Route::post('/praktikan/set/{praktikan_nim}/{asisten_id}/{modul_id}', [NilaiController::class, 'edit'])->name('praktikan.set');
    Route::put('/praktikan/password/{praktikan_nim}/{new_pass}', [PraktikanController::class, 'edit'])->name('praktikan.password');

    // Configuration
    Route::post('/konfigurasi/save', [ConfigurationController::class, 'store'])->name('konfigurasi.save');

    // File Upload
    // Route::get('/upload', [UploadController::class, 'upload'])->name('upload');
    // Route::post('/upload/process', [UploadController::class, 'proses_upload'])->name('upload.process');

    Route::get('/soal-comment/{tipe_soal}/{modul_id}', [SoalCommentController::class, 'showByModul'])->name('soal.comment.show');
});

// Praktikan Routes
Route::middleware('loggedIn:praktikan')->prefix('praktikan')->name('praktikan.')->group(function () {
    // Dashboard
    Route::get('/', [PageController::class, 'praktikan'])->name('dashboard');
    Route::get('/contact-asisten', [PageController::class, 'contactAsisten'])->name('contact_asisten');

    // Feedback
    Route::post('/pesan', [FeedbackController::class, 'store'])->name('pesan.store');

    // Laporan
    Route::post('/laporan', [LaporanPraktikanController::class, 'store'])->name('laporan.store');
    Route::post('/laporan/{praktikan_id}/{modul_id}', [LaporanPraktikanController::class, 'show'])->name('laporan.show');

    // Jawaban
    Route::post('/jawaban/ta', [JawabanTaController::class, 'store'])->name('jawaban.ta');
    Route::post('/jawaban/tk', [JawabanTkController::class, 'store'])->name('jawaban.tk');
    Route::post('/jawaban/jurnal', [JawabanJurnalController::class, 'store'])->name('jawaban.jurnal');
    Route::post('/jawaban/fitb', [JawabanFitbController::class, 'store'])->name('jawaban.fitb');
    Route::post('/jawaban/mandiri', [JawabanMandiriController::class, 'store'])->name('jawaban.mandiri');
    Route::post('/jawaban/jurnal/{praktikan_id}/{modul_id}', PraktikanLihatJawabanController::class)->name('jawaban.jurnal.show');

    // View answers for praktikan
    Route::get('/jawaban/ta/{praktikan_id}/{modul_id}', [JawabanTaController::class, 'getPraktikanAnswers'])->name('jawaban.ta.show');
    Route::get('/jawaban/tk/{praktikan_id}/{modul_id}', [JawabanTkController::class, 'getPraktikanAnswers'])->name('jawaban.tk.show');

    // Tugas Pendahuluan
    Route::post('/tp/temp-jawaban', [TempJawabantpController::class, 'store'])->name('tp.temp_jawaban');
    Route::post('/tp/save-jawaban', [KumpulTpController::class, 'save'])->name('tp.save_jawaban');

    // Polling
    Route::post('/polling/check', [ConfigurationController::class, 'isPollingEnabled'])->name('polling.check');
    Route::post('/polling', [PollingController::class, 'store'])->name('polling.store');

    // Nilai
    Route::post('/nilai/{praktikan_id}', [NilaiController::class, 'showAll'])->name('nilai.all');

    // Reset Password
    Route::post('/reset-password', [PraktikanController::class, 'resetPass'])->name('reset_password');

    // Comments buat TOT
    Route::post('/soal-comment/{praktikan_id}/{tipe_soal}/{soal_id}', [SoalCommentController::class, 'store'])->name('soal.comment.store');

    // Autosave jawaban
    Route::prefix('autosave')->name('autosave.')->group(function () {
        Route::post('/', [JawabanSnapshotController::class, 'store'])->name('store');
        Route::get('/', [JawabanSnapshotController::class, 'index'])->name('index');
        Route::delete('/clear', [JawabanSnapshotController::class, 'clearPraktikanAnswers'])->name('clear');

        // Question ID management to prevent refresh exploitation
        Route::post('/questions', [JawabanSnapshotController::class, 'storeQuestionIds'])->name('questions.store');
        Route::get('/questions', [JawabanSnapshotController::class, 'getQuestionIds'])->name('questions.get');
    });
});

// Shared Routes (Both Asisten and Praktikan)
Route::middleware('loggedIn:all')->group(function () {
    Route::post('/praktikum/check', [CurrentPraktikumController::class, 'show'])->name('praktikum.check');
    Route::post('/modul/{id}', [ModulController::class, 'index'])->name('modul.get');
    Route::post('/tp/pembahasan/{isEnglish}', [TugaspendahuluanController::class, 'index'])->name('tp.pembahasan.get');
});

// Public API Routes (TODO: Secure these routes with authentication/token)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/soal/tp/{isEnglish}/{praktikan_id}', [SoalTpController::class, 'show'])->name('soal.tp');
    Route::get('/soal/ta/{modul_id}/{kelas_id}', [SoalTaController::class, 'show'])->name('soal.ta');
    Route::get('/soal/tk/{modul_id}/{kelas_id}', [SoalTkController::class, 'show'])->name('soal.tk');
    Route::get('/soal/fitb', [SoalFitbController::class, 'show'])->name('soal.fitb');
    Route::get('/soal/jurnal', [SoalJurnalController::class, 'show'])->name('soal.jurnal');
    Route::get('/soal/runmod', [SoalJurnalController::class, 'showRunmod'])->name('soal.runmod');
    Route::get('/soal/mandiri/{modul_id}/{kelas_id}', [SoalMandiriController::class, 'show'])->name('soal.mandiri');
    Route::post('/get-tp/{praktikan_nim}/{modul_id}', [JawabanTpController::class, 'show'])->name('get-tp');

    // Routes for fetching questions by IDs (to prevent refresh exploitation)
    Route::post('/soal/ta/by-ids', [SoalTaController::class, 'getByIds'])->name('soal.ta.by_ids');
    Route::post('/soal/tk/by-ids', [SoalTkController::class, 'getByIds'])->name('soal.tk.by_ids');
    Route::post('/soal/mandiri/by-ids', [SoalMandiriController::class, 'getByIds'])->name('soal.mandiri.by_ids');
});

// Special Routes
Route::get('/lihat_tp', [PageController::class, 'lihatTp'])->name('lihat_tp')->middleware('loggedIn:asisten');