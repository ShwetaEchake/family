<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyHeadController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('/', function () {
        return redirect()->route('login');
    })->name('/');


    Route::prefix('family')->name('family.')->group(function () {
        Route::get('/',            [FamilyHeadController::class, 'index'])->name('index');
        Route::get('/create',      [FamilyHeadController::class, 'create'])->name('create');
        Route::post('/',           [FamilyHeadController::class, 'store'])->name('store');
        Route::get('/{familyHead}',[FamilyHeadController::class, 'show'])->name('show');
    });

    Route::get('/ajax/cities', [FamilyHeadController::class, 'getCities'])->name('ajax.cities');
    Route::redirect('/', '/family');




    Route::get('/php', function(Request $request){
        if( !auth()->check() )
            return 'Unauthorized request';

        Artisan::call($request->artisan);
        return dd(Artisan::output());
    });
