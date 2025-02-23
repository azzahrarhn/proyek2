<?php  
  
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\HomeController;  
use App\Http\Controllers\BiodataSiswaController;  
use App\Http\Controllers\ProfileWaliKelasController;  
use App\Http\Controllers\RegisterController;  
use App\Http\Controllers\LoginController;  
use App\Http\Controllers\DashboardController;  
use App\Http\Controllers\MataPelajaranController;  
use App\Http\Controllers\NilaiController;  
use App\Http\Controllers\TpValueController; // Ensure this is included  
use Illuminate\Support\Facades\Auth;  
use App\Http\Controllers\GradeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\adminController;  
use App\Http\Controllers\GuruController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\RaporController;
  
/*  
|--------------------------------------------------------------------------  
| Web Routes  
|--------------------------------------------------------------------------  
|  
| This is where you can define all of your application's web routes.  
| These routes are loaded by the RouteServiceProvider within a group  
| which is assigned the "web" middleware group. Now create something great!  
|  
*/  
  
// Landing Page - Redirect to register  
Route::get('/', function () {  
    return redirect()->route('login');  
});  

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home'); // Ubah sesuai halaman setelah verifikasi
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
  
// Login and Logout Routes  
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');             // Show login form  
Route::post('/login', [LoginController::class, 'login'])->name('login.post');               // Process login  
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');                 // Logout  
  
// Authenticated Routes  
Route::middleware('auth')->group(function () {  
    // Biodata Siswa Routes  
    Route::prefix('admin/biodata_siswa')->group(function () {  
        Route::get('/create', [BiodataSiswaController::class, 'create'])->name('biodata_siswa.create'); // Form to add student data  
        Route::post('/', [BiodataSiswaController::class, 'store'])->name('biodata_siswa.store');       // Save student data  
        Route::get('/kelola', [BiodataSiswaController::class, 'kelola'])->name('biodata_siswa.kelola'); // Manage student biodata  
        Route::get('/edit/{id}', [BiodataSiswaController::class, 'edit'])->name('biodata_siswa.edit'); 
        Route::put('/update/{id}', [BiodataSiswaController::class, 'update'])->name('biodata_siswa.update');
        Route::delete('/delete/{id}', [BiodataSiswaController::class, 'destroy'])->name('biodata_siswa.destroy');  
    }); 
    
    // guru Routes
    Route::prefix('admin/guru')->group(function () {
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create'); // Form tambah guru
        Route::post('/store', [GuruController::class, 'store'])->name('guru.store'); // Simpan data guru
        Route::get('/kelola', [GuruController::class, 'index'])->name('guru.kelola'); // List guru
        Route::get('/edit/{id}', [GuruController::class, 'edit'])->name('guru.edit'); // Form edit guru
        Route::put('/update/{id}', [GuruController::class, 'update'])->name('guru.update'); // Update data guru
        Route::delete('/delete/{id}', [GuruController::class, 'destroy'])->name('guru.destroy'); // Hapus guru
    });

    // Wali Kelas Routes
    Route::prefix('admin/wali-kelas')->group(function () {
        Route::get('/create', [WaliKelasController::class, 'create'])->name('wali_kelas.create'); // Form tambah wali kelas
        Route::post('/store', [WaliKelasController::class, 'store'])->name('wali_kelas.store'); // Simpan wali kelas
        Route::get('/kelola', [WaliKelasController::class, 'index'])->name('wali_kelas.kelola'); // List wali kelas
        Route::get('/edit/{id}', [WaliKelasController::class, 'edit'])->name('wali_kelas.edit'); // Form edit wali kelas
        Route::put('/update/{id}', [WaliKelasController::class, 'update'])->name('wali_kelas.update'); // Update wali kelas
        Route::delete('/delete/{id}', [WaliKelasController::class, 'destroy'])->name('wali_kelas.destroy'); // Hapus wali kelas
    });

    // Profile Wali Kelas Routes  
    Route::prefix('profile_wali_kelas')->group(function () {  
        Route::get('/', [ProfileWaliKelasController::class, 'index'])->name('profile_wali_kelas.index'); // Display profile index  
        Route::get('/edit', [ProfileWaliKelasController::class, 'edit'])->name('profile_wali_kelas.edit'); // Edit profile  
        Route::post('/update', [ProfileWaliKelasController::class, 'update'])->name('profile_wali_kelas.update'); // Update profile  
        Route::post('/change-password', [ProfileWaliKelasController::class, 'changePassword'])->name('change_password');
    });  
    
  
    // Dashboard Route  
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard'); // Dashboard  
  
    // Mata Pelajaran Routes  
    Route::prefix('admin/mata_pelajaran')->group(function () {  
        Route::get('/create', [MataPelajaranController::class, 'create'])->name('mata_pelajaran.create');
        Route::post('/', [MataPelajaranController::class, 'store'])->name('mata_pelajaran.store');
        Route::get('/sidebar', [MataPelajaranController::class, 'getSubjectsForSidebar'])->name('mata_pelajaran.getSubjects.sidebar');
        Route::get('/table', [MataPelajaranController::class, 'getSubjectsForTable'])->name('mata_pelajaran.getSubjects.table');
        Route::put('/{id}', [MataPelajaranController::class, 'update'])->name('mata_pelajaran.update');
        Route::delete('/{id}', [MataPelajaranController::class, 'destroy'])->name('mata_pelajaran.destroy');
    });    
  
    // Nilai Siswa Routes  
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/update-nilai', [NilaiController::class, 'updateNilai'])->name('update.nilai');
    Route::delete('/nilai/{id}', [NilaiController::class, 'destroy']);
    Route::post('/nilai/update-rapor', [NilaiController::class, 'updateRapor']);
    Route::get('/nilai/get-nilai/{id}', [NilaiController::class, 'getNilai']);

    Route::get('/chart/index', [ChartController::class, 'index']);
    Route::get('/get-nilai-chart', [ChartController::class, 'getPieChartData']);

    Route::get('/cetak-rapor', [RaporController::class, 'cetakRapor'])->name('cetak.rapor');

});  

// Route untuk Kepala Sekolah
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [adminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [adminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.profile.update');
    Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change_password');
    Route::get('/admin/nilai', [AdminController::class, 'nilai'])->name('admin.nilai');
    Route::get('/admin/chart', [AdminController::class, 'chart'])->name('admin.chart'); 
});
  
