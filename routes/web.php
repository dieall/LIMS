<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeclController;
use App\Http\Controllers\LogamtimahController;
use App\Http\Controllers\EhtgController;
use App\Http\Controllers\Nh3Controller;
use App\Http\Controllers\LogamtimbalController;
use App\Http\Controllers\SolarController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\MixingController;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\RiController;
use App\Http\Controllers\ReController;
use App\Http\Controllers\FiltrasiController;
use App\Http\Controllers\SirController;
use App\Http\Controllers\FinishController;
use App\Http\Controllers\SolderController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TinstabController;
use App\Http\Controllers\TinchemController;
use App\Http\Controllers\DmtController;

use App\Http\Controllers\ImportController;
use App\Http\Controllers\DashboardController;



//solder
use App\Http\Controllers\CategorySolderController;
use App\Http\Controllers\SncuController;
use App\Http\Controllers\PengajuanSolderController;
use App\Http\Controllers\SnagcuController;
use App\Http\Controllers\SnagController;
use App\Http\Controllers\TinController;

















Route::get('/', function () {
    return view('index');
});
 
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
  
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
 
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::controller(MeclController::class)->prefix('mecl')->group(function () {
    Route::get('', 'index')->name('mecl');
    Route::get('create', 'create')->name('mecl.create');
    Route::post('store', 'store')->name('mecl.store');
    Route::get('show/{id}', 'show')->name('mecl.show');
    Route::get('edit/{id}', 'edit')->name('mecl.edit');
    Route::put('edit/{id}', 'update')->name('mecl.update');
    Route::delete('destroy/{id}', 'destroy')->name('mecl.destroy');
});

Route::controller(LogamtimahController::class)->prefix('logamtimah')->group(function () {
    Route::get('', 'index')->name('logamtimah');
    Route::get('create', 'create')->name('logamtimah.create');
    Route::post('store', 'store')->name('logamtimah.store');
    Route::get('show/{id}', 'show')->name('logamtimah.show');
    Route::get('edit/{id}', 'edit')->name('logamtimah.edit');
    Route::put('edit/{id}', 'update')->name('logamtimah.update');
    Route::delete('destroy/{id}', 'destroy')->name('logamtimah.destroy');
});


Route::controller(EhtgController::class)->prefix('ehtg')->group(function () {
    Route::get('', 'index')->name('ehtg');
    Route::get('create', 'create')->name('ehtg.create');
    Route::post('store', 'store')->name('ehtg.store');
    Route::get('show/{id}', 'show')->name('ehtg.show');
    Route::get('edit/{id}', 'edit')->name('ehtg.edit');
    Route::put('edit/{id}', 'update')->name('ehtg.update');
    Route::delete('destroy/{id}', 'destroy')->name('ehtg.destroy');
});

Route::controller(Nh3Controller::class)->prefix('nh3')->group(function () {
    Route::get('', 'index')->name('nh3');
    Route::get('create', 'create')->name('nh3.create');
    Route::post('store', 'store')->name('nh3.store');
    Route::get('show/{id}', 'show')->name('nh3.show');
    Route::get('edit/{id}', 'edit')->name('nh3.edit');
    Route::put('edit/{id}', 'update')->name('nh3.update');
    Route::delete('destroy/{id}', 'destroy')->name('nh3.destroy');
});

Route::controller(LogamtimbalController::class)->prefix('logamtimbal')->group(function () {
    Route::get('', 'index')->name('logamtimbal');
    Route::get('create', 'create')->name('logamtimbal.create');
    Route::post('store', 'store')->name('logamtimbal.store');
    Route::get('show/{id}', 'show')->name('logamtimbal.show');
    Route::get('edit/{id}', 'edit')->name('logamtimbal.edit');
    Route::put('edit/{id}', 'update')->name('logamtimbal.update');
    Route::delete('destroy/{id}', 'destroy')->name('logamtimbal.destroy');
});

Route::controller(SolarController::class)->prefix('solar')->group(function () {
    Route::get('', 'index')->name('solar');
    Route::get('create', 'create')->name('solar.create');
    Route::post('store', 'store')->name('solar.store');
    Route::get('show/{id}', 'show')->name('solar.show');
    Route::get('edit/{id}', 'edit')->name('solar.edit');
    Route::put('edit/{id}', 'update')->name('solar.update');
    Route::delete('destroy/{id}', 'destroy')->name('solar.destroy');
});

Route::controller(LineController::class)->prefix('line')->group(function () {
    Route::get('', 'index')->name('line');
    Route::get('create', 'create')->name('line.create');
    Route::post('store', 'store')->name('line.store');
    Route::get('show/{id}', 'show')->name('line.show');
    Route::get('edit/{id}', 'edit')->name('line.edit');
    Route::put('edit/{id}', 'update')->name('line.update');
    Route::delete('destroy/{id}', 'destroy')->name('line.destroy');
});

Route::controller(MixingController::class)->prefix('mixing')->group(function () {
    Route::get('', 'index')->name('mixing');
    Route::get('create', 'create')->name('mixing.create');
    Route::post('store', 'store')->name('mixing.store');
    Route::get('show/{id}', 'show')->name('mixing.show');
    Route::get('edit/{id}', 'edit')->name('mixing.edit');
    Route::put('edit/{id}', 'update')->name('mixing.update');
    Route::delete('destroy/{id}', 'destroy')->name('mixing.destroy');
});

Route::controller(TrialController::class)->prefix('trial')->group(function () {
    Route::get('', 'index')->name('trial');
    Route::get('create', 'create')->name('trial.create');
    Route::post('store', 'store')->name('trial.store');
    Route::get('show/{id}', 'show')->name('trial.show');
    Route::get('edit/{id}', 'edit')->name('trial.edit');
    Route::put('edit/{id}', 'update')->name('trial.update');
    Route::delete('destroy/{id}', 'destroy')->name('trial.destroy');
});

Route::controller(RiController::class)->prefix('ri')->group(function () {
    Route::get('', 'index')->name('ri');
    Route::get('create', 'create')->name('ri.create');
    Route::post('store', 'store')->name('ri.store');
    Route::get('show/{id}', 'show')->name('ri.show');
    Route::get('edit/{id}', 'edit')->name('ri.edit');
    Route::put('edit/{id}', 'update')->name('ri.update');
    Route::delete('destroy/{id}', 'destroy')->name('ri.destroy');
});

Route::controller(ReController::class)->prefix('re')->group(function () {
    Route::get('', 'index')->name('re');
    Route::get('create', 'create')->name('re.create');
    Route::post('store', 'store')->name('re.store');
    Route::get('show/{id}', 'show')->name('re.show');
    Route::get('edit/{id}', 'edit')->name('re.edit');
    Route::put('edit/{id}', 'update')->name('re.update');
    Route::delete('destroy/{id}', 'destroy')->name('re.destroy');
});

Route::controller(FiltrasiController::class)->prefix('filtrasi')->group(function () {
    Route::get('', 'index')->name('filtrasi');
    Route::get('create', 'create')->name('filtrasi.create');
    Route::post('store', 'store')->name('filtrasi.store');
    Route::get('show/{id}', 'show')->name('filtrasi.show');
    Route::get('edit/{id}', 'edit')->name('filtrasi.edit');
    Route::put('edit/{id}', 'update')->name('filtrasi.update');
    Route::delete('destroy/{id}', 'destroy')->name('filtrasi.destroy');
});

Route::controller(SirController::class)->prefix('sir')->group(function () {
    Route::get('', 'index')->name('sir');
    Route::get('create', 'create')->name('sir.create');
    Route::post('store', 'store')->name('sir.store');
    Route::get('show/{id}', 'show')->name('sir.show');
    Route::get('edit/{id}', 'edit')->name('sir.edit');
    Route::put('edit/{id}', 'update')->name('sir.update');
    Route::delete('destroy/{id}', 'destroy')->name('sir.destroy');
});

Route::controller(FinishController::class)->prefix('finish')->group(function () {
    Route::get('', 'index')->name('finish');
    Route::get('create', 'create')->name('finish.create');
    Route::post('store', 'store')->name('finish.store');
    Route::get('show/{id}', 'show')->name('finish.show');
    Route::get('edit/{id}', 'edit')->name('finish.edit');
    Route::put('edit/{id}', 'update')->name('finish.update');
    Route::delete('destroy/{id}', 'destroy')->name('finish.destroy');
});

Route::controller(SolderController::class)->prefix('solder')->group(function () {
    Route::get('', 'index')->name('solder');
    Route::get('create', 'create')->name('solder.create');
    Route::post('store', 'store')->name('solder.store');
    Route::get('show/{id}', 'show')->name('solder.show');
    Route::get('edit/{id}', 'edit')->name('solder.edit');
    Route::put('edit/{id}', 'update')->name('solder.update');
    Route::delete('destroy/{id}', 'destroy')->name('solder.destroy');
});

Route::controller(TransaksiController::class)->prefix('transaksi')->group(function () {
    Route::get('', 'index')->name('transaksi');
    Route::get('create', 'create')->name('transaksi.create');
    Route::post('store', 'store')->name('transaksi.store');
    Route::get('show/{id}', 'show')->name('transaksi.show');
    Route::get('edit/{id}', 'edit')->name('transaksi.edit');
    Route::put('edit/{id}', 'update')->name('transaksi.update');
    Route::delete('destroy/{id}', 'destroy')->name('transaksi.destroy');
    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'printPDF'])->name('transaksi.print');
    // Route::get('/transaksi/{id}/print2', [TransaksiController::class, 'print2'])->name('transaksi.print2');
    Route::get('/transaksi/print2/{id}', [TransaksiController::class, 'print2'])->name('transaksi.print2');
    Route::get('/transaksi/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
    

});

Route::controller(LineController::class)->prefix('line')->group(function () {
    Route::get('', 'index')->name('line');
    Route::get('create', 'create')->name('line.create');
    Route::post('store', 'store')->name('line.store');
    Route::get('show/{id}', 'show')->name('line.show');
    Route::get('edit/{id}', 'edit')->name('line.edit');
    Route::put('edit/{id}', 'update')->name('line.update');
    Route::delete('destroy/{id}', 'destroy')->name('line.destroy');
});

Route::controller(CategoryController::class)->prefix('category')->group(function () {
    Route::get('', 'index')->name('category');
    Route::get('create', 'create')->name('category.create');
    Route::post('store', 'store')->name('category.store');
    Route::get('show/{id}', 'show')->name('category.show');
    Route::get('edit/{id}', 'edit')->name('category.edit');
    Route::put('edit/{id}', 'update')->name('category.update');
    Route::delete('destroy/{id}', 'destroy')->name('category.destroy');
});


Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('', 'index')->name('user');
    Route::get('create', 'create')->name('user.create');
    Route::post('store', 'store')->name('user.store');
    Route::get('show/{id}', 'show')->name('user.show');
    Route::get('edit/{id}', 'edit')->name('user.edit');
    Route::put('edit/{id}', 'update')->name('user.update');
    Route::delete('destroy/{id}', 'destroy')->name('user.destroy');
});

//WEB ROUTER UNTUK BQR



// chart
Route::get('/api/pegawai/count', [UserController::class, 'countPegawai']);
Route::get('/get-data/{table}', [TransaksiController::class, 'getDataByTable']);

//Data Tinstab

Route::controller(TinstabController::class)->prefix('tinstab')->group(function () {
    Route::get('', 'index')->name('tinstab');
    Route::get('create', 'create')->name('tinstab.create');
    Route::get('create1', 'create1')->name('tinstab.create1');
    Route::post('store', 'store')->name('tinstab.store');
    Route::get('show/{idx}', 'show')->name('tinstab.show'); 
    Route::get('edit/{idx}', 'edit')->name('tinstab.edit');
    Route::put('edit/{idx}', 'update')->name('tinstab.update');
    Route::delete('destroy/{idx}', 'destroy')->name('tinstab.destroy');
});






Route::controller(DmtController::class)->prefix('dmt')->group(function () {
    Route::get('', 'index')->name('dmt');
    Route::get('create', 'create')->name('dmt.create');
    Route::get('create1', 'create1')->name('dmt.create1');
    Route::get('create2', 'create2')->name('dmt.create2');
    Route::post('store', 'store')->name('dmt.store');
    Route::get('show/{idx}', 'show')->name('dmt.show'); 
    Route::get('edit/{idx}', 'edit')->name('dmt.edit');
    Route::put('edit/{idx}', 'update')->name('dmt.update');
    Route::delete('destroy/{id}', 'destroy')->name('dmt.destroy');
    
});




Route::controller(TinchemController::class)->prefix('tinchem')->group(function () {
    Route::get('', 'index')->name('tinchem');
    Route::get('create', 'create')->name('tinchem.create');
    Route::get('create1', 'create1')->name('tinchem.create1');
    Route::get('create2', 'create2')->name('tinchem.create2');
    Route::get('create3', 'create3')->name('tinchem.create3');
    Route::get('create4', 'create4')->name('tinchem.create4');
    Route::get('create5', 'create5')->name('tinchem.create5');
    Route::get('create6', 'create6')->name('tinchem.create6');
    Route::get('create7', 'create7')->name('tinchem.create7');
    Route::get('create8', 'create8')->name('tinchem.create8');
    Route::get('create9', 'create9')->name('tinchem.create9');
    Route::post('/timchen/store', [TinchemController::class, 'store'])->name('timchen.store');
    Route::get('show/{idx}', 'show')->name('tinchem.show'); 
    Route::get(
        'edit/{id}', 'edit')->name('tinchem.edit');
    Route::put('edit/{id}', 'update')->name('tinchem.update');
    Route::delete('destroy/{id}', 'destroy')->name('tinchem.destroy');
});


Route::controller(ImportController::class)->prefix('import')->group(function () {
    Route::get('', 'index')->name('import');
    Route::get('/export-data', [ImportController::class, 'export'])->name('export.data');
    Route::get('/transaksi/export', [TransaksiController::class, 'export'])->name('transaksi.export');



});



//Data Solder

Route::controller(SncuController::class)->prefix('sncu')->group(function () {
    Route::get('/sncu', [SncuController::class, 'index'])->name('sncu.index');
    Route::get('', 'index')->name('sncu');
    Route::get('create', 'create')->name('sncu.create');
    Route::post('store', 'store')->name('sncu.store');
    Route::get('show/{id}', 'show')->name('sncu.show'); 
    Route::get('edit/{id}', 'edit')->name('sncu.edit');
    Route::put('edit/{id}', 'update')->name('sncu.update');
    Route::delete('destroy/{id}', 'destroy')->name('sncu.destroy');
});



Route::controller(CategorySolderController::class)->prefix('categorysolder')->group(function () {
    Route::get('/categorysolder', [CategorySolderController::class, 'index'])->name('categorysolder.index');
    Route::get('', 'index')->name('categorysolder');
    Route::get('create', 'create')->name('categorysolder.create');
    Route::post('store', 'store')->name('categorysolder.store');
    Route::get('show/{id_category}', 'show')->name('categorysolder.show'); 
    Route::get('edit/{id_category}', 'edit')->name('categorysolder.edit');
    Route::put('edit/{id_category}', 'update')->name('categorysolder.update');
    Route::delete('destroy/{id_category}', 'destroy')->name('categorysolder.destroy');
});


Route::controller(PengajuanSolderController::class)->prefix('pengajuansolder')->group(function () {
    Route::get('/pengajuansolder', [PengajuanSolderController::class, 'index'])->name('pengajuansolder.index');
    Route::get('', 'index')->name('pengajuansolder');
    Route::get('create', 'create')->name('pengajuansolder.create');
    Route::post('store', 'store')->name('pengajuansolder.store');
    Route::get('show/{id}', 'show')->name('pengajuansolder.show'); 
    Route::get('edit/{id}', 'edit')->name('pengajuansolder.edit');
    Route::put('edit/{id}', 'update')->name('pengajuansolder.update');
    Route::delete('destroy/{id}', 'destroy')->name('pengajuansolder.destroy');
    Route::get('/get-sncu/{categoryId}', [SncuController::class, 'getSncuData']);
    Route::get('/get-sncu/{categoryId}', [SnagcuController::class, 'getSnagcuData']);
    
});

Route::controller(SnagcuController::class)->prefix('snagcu')->group(function () {
    Route::get('/snagcu', [SnagcuController::class, 'index'])->name('snagcu.index');
    Route::get('', 'index')->name('snagcu');
    Route::get('create', 'create')->name('snagcu.create');
    Route::post('store', 'store')->name('snagcu.store');
    Route::get('show/{id}', 'show')->name('snagcu.show'); 
    Route::get('edit/{id}', 'edit')->name('snagcu.edit');
    Route::put('edit/{id}', 'update')->name('snagcu.update');
    Route::delete('destroy/{id}', 'destroy')->name('snagcu.destroy');
});

Route::controller(SnagController::class)->prefix('snag')->group(function () {
    Route::get('/snag', [SnagController::class, 'index'])->name('snag.index');
    Route::get('', 'index')->name('snag');
    Route::get('create', 'create')->name('snag.create');
    Route::post('store', 'store')->name('snag.store');
    Route::get('show/{id}', 'show')->name('snag.show'); 
    Route::get('edit/{id}', 'edit')->name('snag.edit');
    Route::put('edit/{id}', 'update')->name('snag.update');
    Route::delete('destroy/{id}', 'destroy')->name('snag.destroy');
});

Route::controller(Tincontroller::class)->prefix('tin')->group(function () {
    Route::get('/tin', [TinController::class, 'index'])->name('tin.index');
    Route::get('', 'index')->name('tin');
    Route::get('create', 'create')->name('tin.create');
    Route::post('store', 'store')->name('tin.store');
    Route::get('show/{id}', 'show')->name('tin.show'); 
    Route::get('edit/{id}', 'edit')->name('tin.edit');
    Route::put('edit/{id}', 'update')->name('tin.update');
    Route::delete('destroy/{id}', 'destroy')->name('tin.destroy');
});
