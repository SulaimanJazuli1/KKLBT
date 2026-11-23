<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\GisController;

Route::get('/', [ViewController::class, 'beranda']);

Route::get('/beranda', [ViewController::class, 'beranda'])->name('beranda');

Route::get('/pemdes', [ViewController::class, 'pemdes'])->name('pemdes');

Route::get('/ppw', [ViewController::class, 'ppw'])->name('ppw');

Route::get('/sig', [ViewController::class, 'sig'])->name('sig');

Route::get('/lmb', [ViewController::class, 'lmb'])->name('lmb');

Route::get('/informasiDesa', [ViewController::class, 'informasiDesa'])->name('informasiDesa');

Route::get('/webGIS', [ViewController::class, 'webGIS'])->name('webGIS');
Route::get('/webGISLama', [ViewController::class, 'webGISLama'])->name('webGISLama');

Route::get('/mitradesa', [ViewController::class, 'mitradesa'])->name('mitradesa');

Route::get('/gis/catalog', [GisController::class, 'catalog'])->name('gis.catalog');
Route::get('gis/data/{id}', [GisController::class, 'geojson'])->where('id', '[A-Za-z0-9_-]+')->name('gis.geojson');
Route::get('/gis/data/{layerName}', [GisController::class, 'getDataLayer']);

Route::get('/loginPage', [ViewController::class, 'loginPage'])->name('loginPage');
