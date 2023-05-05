<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
//Auth::routes(['register'=>false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::resource('invoices', InvoicesController::class);
Route::get('/InvoicesDetails/{id}',[InvoicesDetailsController::class,'getdetails']);

Route::get('/View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file']);
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file']);
Route::post('/delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::PUT('/invoice/update',[InvoicesController::class,'update'])->name('invoice.update');

Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);

Route::PUT('/section/update',[SectionsController::class,'ModalUpdate'])->name('modal.update');
Route::delete('/section/delete',[SectionsController::class,'ModalDelete'])->name('modal.delete');

Route::resource('sections', SectionsController::class);

Route::PUT('/product/update',[ProductsController::class,'ModalUpdate'])->name('product.update');
Route::delete('/produtc/delete',[ProductsController::class,'ModalDelete'])->name('produtc.delete');

Route::resource('products', ProductsController::class);

Route::get('/section/{id}',[InvoicesController::class,'getproducrs']);
Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit']);

Route::get('/Status_show/{id}',[InvoicesController::class,'show'])->name("Status_show");
Route::post('/Status_update/{id}',[InvoicesController::class,'status_update'])->name("status_update");

Route::get('/Invoice_Paid',[InvoicesController::class,'Invoice_Paid'])->name("Invoice_Paid");
Route::get('/Invoice_UnPaid',[InvoicesController::class,'Invoice_UnPaid'])->name("Invoice_UnPaid");
Route::get('/Invoice_Partial',[InvoicesController::class,'Invoice_Partial'])->name("Invoice_Partial");

Route::resource('Archive', InvoicesArchiveController::class);
Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);

Route::get('invoices_report',[Invoices_Report::class,'index']);
Route::post('Search_invoices',[Invoices_Report::class,'Search_invoices']);

Route::get('customers_report',[Customers_Report::class,'index'])->name("customers_report");
Route::post('Search_customers',[Customers_Report::class,'Search_customers']);

Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');
Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');
Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');

Route::get('/{page}', [AdminController::class,'index' ]);
