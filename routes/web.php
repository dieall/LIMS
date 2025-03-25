<?php
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstrumentController;


use App\Http\Controllers\MeclController;
use App\Http\Controllers\LogamtimahController;


use App\Http\Controllers\LogamtimbalController;
use App\Http\Controllers\SolarController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\MixingController;


use App\Http\Controllers\FinishController;
use App\Http\Controllers\SolderController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataIntervalController;
use App\Exports\DataIntervalExport;


//Chemical
use App\Http\Controllers\TinstabController;
use App\Http\Controllers\TinchemController;
use App\Http\Controllers\DmtController;
use App\Http\Controllers\PengajuanChemicalController;
use App\Http\Controllers\DataChemicalController;

use App\Http\Controllers\ImportController;
use App\Http\Controllers\DashboardController;



//solder
use App\Http\Controllers\CategorySolderController;
use App\Http\Controllers\SncuController;
use App\Http\Controllers\PengajuanSolderController;
use App\Http\Controllers\SnagcuController;
use App\Http\Controllers\SnagController;
use App\Http\Controllers\TinController;
use App\Http\Controllers\DataSolderController;


//Rawmat

use App\Http\Controllers\RtinchemicalController;
use App\Http\Controllers\DataRawmatController;
use App\Http\Controllers\PengajuanRawmatController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::get('/user-history/{userName}', [DashboardController::class, 'showUserHistory'])->name('user.history');
Route::get('/user-history1/{userName1}', [DashboardController::class, 'showUserHistory1'])->name('user.history1');


// Route untuk menampilkan status history berdasarkan solder_id
Route::get('/getStatusHistory', [DashboardController::class, 'getStatusHistory']);
Route::get('/export-data-interval/{user_id}', [DataIntervalController::class, 'export'])->name('export.data.interval');

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
        // Rute utama untuk halaman 'user', hanya untuk Admin
        Route::get('', function () {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->index();
        })->name('user');

        // Rute untuk halaman 'create', hanya untuk Admin
        Route::get('create', function () {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->create();
        })->name('user.create');

        // Rute untuk menyimpan data user, hanya untuk Admin
        Route::post('store', function () {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->store();
        })->name('user.store');

        // Rute untuk melihat user, hanya untuk Admin
        Route::get('show/{id}', function ($id) {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->show($id);
        })->name('user.show');

        // Rute untuk halaman edit user, hanya untuk Admin
        Route::get('edit/{id}', function ($id) {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->edit($id);
        })->name('user.edit');

        // Rute untuk update data user, hanya untuk Admin
        Route::put('edit/{id}', [UserController::class, 'update'])->name('user.update');

        // Rute untuk menghapus user, hanya untuk Admin
        Route::delete('destroy/{id}', function ($id) {
            if (Auth::user()->level !== 'Admin') {
                return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
            }
            return app(UserController::class)->destroy($id);
        })->name('user.destroy');
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
    Route::get('/dmt', [DmtController::class, 'index'])->name('dmt.index');
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

Route::controller(InstrumentController::class)->prefix('instruments')->group(function () {
    Route::get('/instrument', [TinController::class, 'index'])->name('instrument.index');
    Route::get('', 'index')->name('instruments');
    Route::get('show/{id}', 'show')->name('instrument.show'); 
    Route::get('create', 'create')->name('instrument.create');
    Route::post('store', 'store')->name('instrument.store');

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
    // Rute untuk halaman utama import, hanya untuk Admin
    Route::get('', function () {
        if (Auth::user()->level !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
        }

        return view('import.index'); // Menampilkan view import/index.blade.php untuk admin
    })->name('import');

    // Rute lainnya tetap ada seperti ekspor data
    Route::get('/export-data', 'export')->name('export.data');
    Route::get('/export', 'export')->name('export');

    // Rute ekspor spesifik untuk pengajuan
    Route::get('/export/pengajuan-solder', 'exportPengajuanSolder')->name('export.pengajuan-solder');
    Route::get('/export/pengajuan-chemical', 'exportPengajuanChemical')->name('export.pengajuan-chemical');
    Route::get('/export/pengajuan-rawmat', 'exportPengajuanRawmat')->name('export.pengajuan-rawmat');
    Route::get('/export/data-instrument', 'exportInstrument')->name('export.data-instrument');
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
    Route::get('/get-tipe-solder/{tipe_solder}', [DataSolderController::class, 'getTipeSolderDetail']);
    Route::get('/pengajuan-solder/{id}/print', [PengajuanSolderController::class, 'print'])->name('pengajuansolder.print');   
    Route::get('/pengajuansolder/export-excel', [PengajuanSolderController::class, 'exportToExcel'])->name('pengajuansolder.export-excel');

    //coa
    Route::get('lokal/{id}', 'lokal')->name('pengajuansolder.lokal');
    Route::get('expor/{id}', 'expor')->name('pengajuansolder.expor');
    Route::get('/get-pengajuan-data/{id}', [PengajuanSolderController::class, 'getPengajuanData']);


    Route::post('/pengajuansolder/pengajuan/{id}', [PengajuanSolderController::class, 'pengajuan'])->name('pengajuansolder.pengajuan');
    Route::post('/pengajuansolder/proses-analisa/{id}', [PengajuanSolderController::class, 'prosesAnalisa'])->name('pengajuansolder.proses-analisa');
    Route::post('/pengajuan-solder/analisa-selesai/{id}', [PengajuanSolderController::class, 'analisaSelesai'])->name('pengajuansolder.analisaSelesai');
    Route::post('/pengajuansolder/review-hasil/{id}', [PengajuanSolderController::class, 'reviewHasil'])->name('pengajuansolder.reviewHasil');
    Route::post('/pengajuansolder/tolak/{id}', [PengajuanSolderController::class, 'tolakReviewHasil'])->name('pengajuansolder.tolak');
    Route::post('/pengajuan-solder/approve/{id}', [PengajuanSolderController::class, 'approve'])->name('pengajuansolder.approve');

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

Route::controller(DataSoldercontroller::class)->prefix('datasolder')->group(function () {
    Route::get('/datasolder', [TinController::class, 'index'])->name('datasolder.index');
    Route::get('', 'index')->name('datasolder');
    Route::get('create', 'create')->name('datasolder.create');
    Route::post('store', 'store')->name('datasolder.store');
    Route::get('show/{id}', 'show')->name('datasolder.show'); 
    Route::get('edit/{id}', 'edit')->name('datasolder.edit');
    Route::put('edit/{id}', 'update')->name('datasolder.update');
    Route::delete('destroy/{id}', 'destroy')->name('datasolder.destroy');
    
});

// Rawmat
Route::controller(RtinchemicalController::class)->prefix('rtinchemical')->group(function () {
    Route::get('', 'index')->name('rtinchemical');
    Route::get('create', 'create')->name('rtinchemical.create');
    Route::post('store', 'store')->name('rtinchemical.store');
    Route::get('show/{id}', 'show')->name('rtinchemical.show');
    Route::get('edit/{id}', 'edit')->name('rtinchemical.edit');
    Route::put('edit/{id}', 'update')->name('rtinchemical.update');
    Route::delete('destroy/{id}', 'destroy')->name('rtinchemical.destroy');

});

Route::controller(DataRawmatController::class)->prefix('datarawmat')->group(function () {
    Route::get('', 'index')->name('datarawmat');
    Route::get('create', 'create')->name('datarawmat.create');
    Route::post('store', 'store')->name('datarawmat.store');
    Route::get('show/{id_rawmat}', 'show')->name('datarawmat.show');
    Route::get('edit/{id_rawmat}', 'edit')->name('datarawmat.edit');
    Route::put('edit/{id_rawmat}', 'update')->name('datarawmat.update');
    Route::delete('destroy/{id_rawmat}', 'destroy')->name('datarawmat.destroy');



});


Route::controller(PengajuanRawmatController::class)->prefix('pengajuanrawmat')->group(function () {
    Route::get('/pengajuanrawmat', [PengajuanRawmatController::class, 'index'])->name('pengajuanrawmat.index');
    Route::get('', 'index')->name('pengajuanrawmat');
    Route::get('create', 'create')->name('pengajuanrawmat.create');
    Route::post('store', 'store')->name('pengajuanrawmat.store');
    Route::get('show/{id}', 'show')->name('pengajuanrawmat.show');
    Route::get('edit/{id}', 'edit')->name('pengajuanrawmat.edit');
    Route::put('edit/{id}', 'update')->name('pengajuanrawmat.update');
    Route::delete('destroy/{id}', 'destroy')->name('pengajuanrawmat.destroy');

    Route::get('/pengajuanrawmat/{id}/print', [PengajuanRawmatController::class, 'print'])->name('pengajuanrawmat.print');  



});


// Chemical
Route::controller(PengajuanChemicalController::class)->prefix('pengajuanchemical')->group(function () {
    Route::get('/pengajuanchemical', [PengajuanChemicalController::class, 'index'])->name('pengajuanchemical.index');
    Route::get('', 'index')->name('pengajuanchemical');
    Route::get('create', 'create')->name('pengajuanchemical.create');
    Route::post('store', 'store')->name('pengajuanchemical.store');
    Route::get('show/{id}', 'show')->name('pengajuanchemical.show');
    Route::get('edit/{id}', 'edit')->name('pengajuanchemical.edit');
    Route::put('edit/{id}', 'update')->name('pengajuanchemical.update');
    Route::delete('destroy/{id}', 'destroy')->name('pengajuanchemical.destroy');
    Route::get('/pengajuanchemical/export-excel', [PengajuanChemicalController::class, 'exportToExcel'])->name('pengajuanchemical.export-excel');
    Route::get('print/{id}', 'print')->name('pengajuanchemical.print');
    //coa
    Route::get('lokal/{id}', 'lokal')->name('pengajuanchemical.lokal');
    Route::get('expor/{id}', 'expor')->name('pengajuanchemical.expor');
    Route::get('/pengajuanchemical/printlokal/{id}', [PengajuanChemicalController::class, 'printlokal'])->name('pengajuanchemical.printlokal');



   
    Route::get('/get-names/{kategori}', [PengajuanChemicalController::class, 'getNamesByCategory']);
    Route::post('/pengajuanchemical/pengajuan/{id}', [PengajuanChemicalController::class, 'pengajuan'])->name('pengajuanchemical.pengajuan');
    Route::post('/pengajuanchemical/proses-analisa/{id}', [PengajuanChemicalController::class, 'prosesAnalisa'])->name('pengajuanchemical.proses-analisa');
    Route::post('/pengajuan-chemical/analisa-selesai/{id}', [PengajuanChemicalController::class, 'analisaSelesai'])->name('pengajuanchemical.analisaSelesai');
    Route::post('/pengajuanchemical/review-hasil/{id}', [PengajuanChemicalController::class, 'reviewHasil'])->name('pengajuanchemical.reviewHasil');
    Route::post('/pengajuanchemical/tolak/{id}', [PengajuanChemicalController::class, 'tolakReviewHasil'])->name('pengajuanchemical.tolak');
    Route::post('/pengajuan-chemical/approve/{id}', [PengajuanChemicalController::class, 'approve'])->name('pengajuanchemical.approve');







});

Route::controller(DataChemicalController::class)->prefix('datachemical')->group(function () {
    Route::get('/datachemical', [DataChemicalController::class, 'index'])->name('datachemical.index');
    Route::get('', 'index')->name('datachemical');
    Route::get('create', 'create')->name('datachemical.create');
    Route::post('store', 'store')->name('datachemical.store');
    Route::get('show/{id}', 'show')->name('datachemical.show');
    Route::get('edit/{id}', 'edit')->name('datachemical.edit');
    Route::put('edit/{id}', 'update')->name('datachemical.update');
    Route::delete('destroy/{id}', 'destroy')->name('datachemical.destroy');


});

Route::controller(DataIntervalController::class)->prefix('datainterval')->group(function () {
    // Rute utama untuk halaman 'datainterval', hanya untuk Admin
    Route::get('', function () {
        if (Auth::user()->level !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this page.');
        }
        return app(DataIntervalController::class)->index();
    })->name('datainterval');

    // Rute lainnya yang tidak perlu pengecekan admin
    Route::get('create', 'create')->name('datainterval.create');
    Route::post('store', 'store')->name('datainterval.store');
    Route::get('show/{user_id}', 'show')->name('datainterval.show');
    Route::get('edit/{id}', 'edit')->name('datainterval.edit');
    Route::put('edit/{id}', 'update')->name('datainterval.update');
    Route::delete('destroy/{id}', 'destroy')->name('datainterval.destroy');
});
