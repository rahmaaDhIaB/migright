<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssistanceDemandController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CancellationReasonController;
use App\Http\Controllers\CancelledDemandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\PrivacyPolicyController;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

//
//Route::get('/', function () {
//    return view('home');
//});

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('login', [AuthenticationController::class, 'login'])->name('login');
    Route::get('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('login', [AuthenticationController::class, 'authenticate'])->name('authenticate');
    Route::post('register', [AuthenticationController::class, 'performRegister'])->name('perform.registration');
});

Route::prefix('auth')->middleware('auth')->group(function () {
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});


Route::middleware('auth')->group(function () {
    Route::get('/',[HomeController::class,'index'])->name('home');


});

Route::prefix('admins')->middleware('auth')->group(function () {
    Route::get('/',[AdminController::class,'index'])->name('admins.index');
    Route::get('/create',[AdminController::class,'create'])->name('admins.create');
    Route::post('/create',[AdminController::class,'store'])->name('admins.store');
    Route::get('/{id}',[AdminController::class,'show'])->name('admins.show');
    Route::get('/{id}/edit',[AdminController::class,'edit'])->name('admins.edit');
    Route::post('/{id}/edit',[AdminController::class,'update'])->name('admins.update');
    Route::delete('/{id}',[AdminController::class,'destroy'])->name('admins.destroy');
}) ;




//news router
Route::prefix('news')->middleware('auth')->group(function () {
    Route::get('/',[\App\Http\Controllers\NewsController::class,'index'])->name('news.index');
    Route::get('/create',[\App\Http\Controllers\NewsController::class,'create'])->name('news.create');
    Route::post('/create',[\App\Http\Controllers\NewsController::class,'store'])->name('news.store');
    Route::patch('/{id}/archive', [\App\Http\Controllers\NewsController::class, 'archive'])->name('news.archive');
    Route::get('/news/archives', [\App\Http\Controllers\NewsController::class, 'archives'])->name('news.archives');
    Route::patch('/{id}/restore', [\App\Http\Controllers\NewsController::class, 'restore'])->name('news.restore');
    Route::get('/t/{id}',[\App\Http\Controllers\NewsController::class,'show'])->name('news.show');
    Route::get('/t/{id}/edit',[\App\Http\Controllers\NewsController::class,'edit'])->name('news.edit');
    Route::post('/t/{id}/edit',[\App\Http\Controllers\NewsController::class,'update'])->name('news.update');
    Route::delete('/t/{id}',[\App\Http\Controllers\NewsController::class,'destroy'])->name('news.destroy');

}) ;


//testimony router
Route::prefix('testimony')->middleware('auth')->group(function () {
    Route::get('/',[\App\Http\Controllers\TestimonyDemandController::class,'index'])->name('testimony.index');
    Route::get('/create',[\App\Http\Controllers\TestimonyDemandController::class,'create'])->name('testimony.create');
    Route::post('/create',[\App\Http\Controllers\TestimonyDemandController::class,'store'])->name('testimony.store');
    Route::get('/{id}',[\App\Http\Controllers\TestimonyDemandController::class,'show'])->name('testimony.show');
    Route::get('/{id}/edit',[\App\Http\Controllers\TestimonyDemandController::class,'edit'])->name('testimony.edit');
    Route::post('/{id}/edit',[\App\Http\Controllers\TestimonyDemandController::class,'update'])->name('testimony.update');
    Route::delete('/{id}',[\App\Http\Controllers\TestimonyDemandController::class,'destroy'])->name('testimony.destroy');

    Route::patch('/{id}/pending', [\App\Http\Controllers\TestimonyDemandController::class, 'pending'])->name('testimony.pending');
    Route::get('/testimony/pending', [\App\Http\Controllers\TestimonyDemandController::class, 'pending_page'])->name('testimony.pending_page');

    Route::patch('/{id}/refused', [\App\Http\Controllers\TestimonyDemandController::class, 'refused'])->name('testimony.refused');
    Route::get('/testimony/refuse', [\App\Http\Controllers\TestimonyDemandController::class, 'refuse'])->name('testimony.refuse_page');

    Route::patch('/{id}/accept', [\App\Http\Controllers\TestimonyDemandController::class, 'accept'])->name('testimony.accept');

    Route::get('/{id}/assign-demand',[AssistanceDemandController::class,'assignTestimonyDemandCreate'])->name('testimony.assignTestimonyDemandToUser.create');
    Route::post('/{id}/assign-demand',[AssistanceDemandController::class,'assignTestimonyDemandStore'])->name('testimony.assignTestimonyDemandToUser.store');


    Route::patch('/admin-decision/{id}/cloture', [\App\Http\Controllers\TestimonyDemandController::class, 'cloture'])->name('testimony.cloture');


    //    router for partner
    Route::patch('/partner-decision/{id}/treated', [\App\Http\Controllers\TestimonyDemandController::class, 'treated'])->name('testimony.treated');
    Route::patch('/partner-decision/{id}/notreated', [\App\Http\Controllers\TestimonyDemandController::class, 'notreated'])->name('testimony.notreated');

}) ;




//Assistance router
Route::prefix('assistance')->middleware('auth')->group(function () {
    Route::get('/',[AssistanceDemandController::class,'index'])->name('assistance.index');
    Route::get('/create',[AssistanceDemandController::class,'create'])->name('assistance.create');
    Route::post('/create',[AssistanceDemandController::class,'store'])->name('assistance.store');
    Route::get('/{id}',[AssistanceDemandController::class,'show'])->name('assistance.show');
    Route::get('/{id}/edit',[AssistanceDemandController::class,'edit'])->name('assistance.edit');
    Route::post('/{id}/edit',[AssistanceDemandController::class,'update'])->name('assistance.update');
    Route::delete('/{id}',[AssistanceDemandController::class,'destroy'])->name('assistance.destroy');
    Route::get('/{id}/assign-demand',[AssistanceDemandController::class,'assignAssistanceDemandCreate'])->name('assistance.assignAssistanceDemandToUser.create');
    Route::post('/{id}/assign-demand',[AssistanceDemandController::class,'assignAssistanceDemandStore'])->name('assistance.assignAssistanceDemandToUser.store');
    Route::patch('/{id}/pending', [AssistanceDemandController::class, 'pending'])->name('assistance.pending');
    Route::get('/assistance/pending', [AssistanceDemandController::class, 'pending_page'])->name('assistance.pending_page');
    Route::patch('/{id}/refused', [AssistanceDemandController::class, 'refused'])->name('assistance.refused');
    Route::get('/assistance/refuse', [AssistanceDemandController::class, 'refuse'])->name('assistance.refuse_page');

    Route::patch('/{id}/accept', [AssistanceDemandController::class, 'accept'])->name('assistance.accept');


//    router for partner
    Route::patch('/partner-decision/{id}/treated', [AssistanceDemandController::class, 'treated'])->name('assistance.treated');
    Route::patch('/partner-decision/{id}/notreated', [AssistanceDemandController::class, 'notreated'])->name('assistance.notreated');

//    cloture
    Route::patch('/admin-decision/{id}/cloture', [AssistanceDemandController::class, 'cloture'])->name('assistance.cloture');

}) ;


//lostPerson router
Route::prefix('lostPerson')->middleware('auth')->group(function () {
    Route::get('/',[\App\Http\Controllers\LostPersonDemandController::class,'index'])->name('lostPerson.index');
    Route::get('/create',[\App\Http\Controllers\LostPersonDemandController::class,'create'])->name('lostPerson.create');
    Route::post('/create',[\App\Http\Controllers\LostPersonDemandController::class,'store'])->name('lostPerson.store');
    Route::get('/{id}',[\App\Http\Controllers\LostPersonDemandController::class,'show'])->name('lostPerson.show');
    Route::get('/{id}/edit',[\App\Http\Controllers\LostPersonDemandController::class,'edit'])->name('lostPerson.edit');
    Route::post('/{id}/edit',[\App\Http\Controllers\LostPersonDemandController::class,'update'])->name('lostPerson.update');
    Route::delete('/{id}',[\App\Http\Controllers\LostPersonDemandController::class,'destroy'])->name('lostPerson.destroy');



    Route::patch('/{id}/pending', [\App\Http\Controllers\LostPersonDemandController::class, 'pending'])->name('lostPerson.pending');
    Route::get('/lostPerson/pending', [\App\Http\Controllers\LostPersonDemandController::class, 'pending_page'])->name('lostPerson.pending_page');

    Route::patch('/{id}/refused', [\App\Http\Controllers\LostPersonDemandController::class, 'refused'])->name('lostPerson.refused');
    Route::get('/lostPerson/refuse', [\App\Http\Controllers\LostPersonDemandController::class, 'refuse'])->name('lostPerson.refuse_page');

    Route::patch('/{id}/accept', [\App\Http\Controllers\LostPersonDemandController::class, 'accept'])->name('lostPerson.accept');

    Route::get('/{id}/assign-demand',[AssistanceDemandController::class,'assignLostPersonDemandCreate'])->name('lostPerson.assignLostPersonDemandToUser.create');
    Route::post('/{id}/assign-demand',[AssistanceDemandController::class,'assignLostPersonDemandStore'])->name('lostPerson.assignLostPersonDemandToUser.store');

    //    router for partner
    Route::patch('/partner-decision/{id}/treated', [\App\Http\Controllers\LostPersonDemandController::class, 'treated'])->name('lostPerson.treated');
    Route::patch('/partner-decision/{id}/notreated', [\App\Http\Controllers\LostPersonDemandController::class, 'notreated'])->name('lostPerson.notreated');

//    cloture
    Route::patch('/admin-decision/{id}/cloture', [\App\Http\Controllers\LostPersonDemandController::class, 'cloture'])->name('lostPerson.cloture');

}) ;

//categories router

Route::prefix('categories')->middleware('auth')->group(function (){
    Route::get('/',[CategoryController::class,'index'])->name('categories.index');
    Route::get('/create',[CategoryController::class,'create'])->name('categories.create');
    Route::post('/create',[CategoryController::class,'store'])->name('categories.store');
    Route::get('/{id}',[CategoryController::class,'show'])->name('categories.show');
    Route::get('/{id}/edit',[CategoryController::class,'edit'])->name('categories.edit');
    Route::post('/{id}/edit',[CategoryController::class,'update'])->name('categories.update');
    Route::delete('/{id}',[CategoryController::class,'destroy'])->name('categories.destroy');
}) ;
//services router
Route::prefix('services')->middleware('auth')->group(function (){
    Route::get('/',[ServiceController::class,'index'])->name('services.index');
    Route::get('/create',[ServiceController::class,'create'])->name('services.create');
    Route::post('/create',[ServiceController::class,'store'])->name('services.store');
    Route::get('/{id}',[ServiceController::class,'show'])->name('services.show');
    Route::get('/{id}/edit',[ServiceController::class,'edit'])->name('services.edit');
    Route::post('/{id}/edit',[ServiceController::class,'update'])->name('services.update');
    Route::delete('/{id}',[ServiceController::class,'destroy'])->name('services.destroy');
}) ;
//regions router
Route::prefix('regions')->middleware('auth')->group(function (){
    Route::get('/',[RegionController::class,'index'])->name('regions.index');
    Route::get('/create',[RegionController::class,'create'])->name('regions.create');
    Route::post('/create',[RegionController::class,'store'])->name('regions.store');
    Route::get('/{id}',[RegionController::class,'show'])->name('regions.show');
    Route::get('/{id}/edit',[RegionController::class,'edit'])->name('regions.edit');
    Route::post('/{id}/edit',[RegionController::class,'update'])->name('regions.update');
    Route::delete('/{id}',[RegionController::class,'destroy'])->name('regions.destroy');
}) ;


//types router
Route::prefix('types')->middleware('auth')->group(function (){
    Route::get('/',[TypeController::class,'index'])->name('types.index');
    Route::get('/create',[TypeController::class,'create'])->name('types.create');
    Route::post('/create',[TypeController::class,'store'])->name('types.store');
    Route::get('/{id}',[TypeController::class,'show'])->name('types.show');
    Route::get('/{id}/edit',[TypeController::class,'edit'])->name('types.edit');
    Route::post('/{id}/edit',[TypeController::class,'update'])->name('types.update');
    Route::delete('/{id}',[TypeController::class,'destroy'])->name('types.destroy');
}) ;

Route::prefix('privacy-policy')->middleware('auth')->group(function () {
    Route::get('/', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::get('/create', [PrivacyPolicyController::class, 'create'])->name('privacy-policy.create');
    Route::post('/', [PrivacyPolicyController::class, 'store'])->name('privacy-policy.store');
    Route::get('/{id}/edit', [PrivacyPolicyController::class, 'edit'])->name('privacy-policy.edit');
    Route::put('/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');
    Route::delete('/{id}', [PrivacyPolicyController::class, 'destroy'])->name('privacy-policy.destroy');
    Route::get('/{id}', [PrivacyPolicyController::class, 'show'])->name('privacy-policy.show');
    Route::patch('/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');
});

Route::prefix('cancellation-reasons')->middleware('auth')->group(function () {
    Route::get('/',[CancellationReasonController::class,'index'])->name('cancellation-reasons.index');
    Route::get('/create',[CancellationReasonController::class,'create'])->name('cancellation-reasons.create');
    Route::post('/', [CancellationReasonController::class, 'store'])->name('cancellation-reasons.store');
    Route::get('/{id}/edit', [CancellationReasonController::class, 'edit'])->name('cancellation-reasons.edit');
    Route::put('/{id}', [CancellationReasonController::class, 'update'])->name('cancellation-reasons.update');
    Route::get('/{id}', [CancellationReasonController::class, 'show'])->name('cancellation-reasons.show');
    Route::delete('{id}', [CancellationReasonController::class, 'destroy'])->name('cancellation-reasons.destroy');
});

Route::get('cancelled-demands',[CancelledDemandController::class,'index'])->name('cancelled-demands.index');
Route::get('cancelled-demands/{id}',[CancelledDemandController::class,'show'])->name('cancelled-demands.show');
Route::post('demands/{id}/change-type', [AssistanceDemandController::class, 'changeType'])->name('demand.changeType');



