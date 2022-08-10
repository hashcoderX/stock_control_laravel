<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FreeIssueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
});


// Route::get('/product', function () {
//     return view('product');
// });

Route::get('/product', [ProductController::class, 'index']);

// save Product route 
Route::post('/saveProduct', [ProductController::class, 'addProduct']);

// fetch product data   
Route::get('/getProductsData', [ProductController::class, 'viewAll']);

// get product data route 
Route::get('/getProductData/{id}', [ProductController::class, 'viewProduct']);

// edit product data 

Route::get('/editProduct', [ProductController::class, 'edit']);

// link customer 
Route::get('/customer', [CustomerController::class, 'index']);

// save customer  saveCustomer
Route::post('/saveCustomer', [CustomerController::class, 'store']);

// get customer data route 
Route::get('/getCustomerData/{id}', [CustomerController::class, 'viewCustomer']);

// edit customer data 
Route::get('/editCustomer', [CustomerController::class, 'edit']);

// free issue definning 
Route::get('/freeissuedefining', [FreeIssueController::class, 'index']);

// save free issue 

Route::post('/saveFreeIssue', [FreeIssueController::class, 'store']);

// get free define data   getFreedefineData
Route::get('/getFreedefineData/{id}', [FreeIssueController::class, 'viewFreedefine']);

// edit free issue data 

Route::get('/editfreeIssue', [FreeIssueController::class, 'editfreeissue']);

// order route 

Route::get('/order', [OrderController::class, 'index']);

// get product data getProductDataviaprcode 

Route::get('/getProductDataviaprcode/{id}', [ProductController::class, 'viewProductprcode']);
Route::get('/getProductfreeissue/{id}', [ProductController::class, 'viewProductfreeissue']);


// order place 

Route::post('/placeOrder', [OrderController::class, 'placeOrder']);

// view order 
Route::get('/orderview', [OrderController::class, 'viewOrder']);

// view order details 

Route::get('/getOrderData/{id}', [OrderController::class, 'orderDetails']);  
Route::get('/getOrderDataroduct/{id}', [OrderController::class, 'orderProductDetails']);
Route::get('/generate-pdf', [OrderController::class, 'generatePDF']);