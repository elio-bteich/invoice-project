<?php

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
Route::view('/', 'home');
Route::get('/invoice', 'InvoiceController@show')->name('invoice');
Route::view('/add-customer', 'add-customer')->name('add-customer');
Route::post('/add-customer', 'CustomerController@create')->name('add-customer');
Route::get('/fetch-customers/{query}', 'CustomerController@getCustomersByName');
Route::get('/customers', 'CustomerController@index')->name('customers');

Route::post('/pdf', 'PdfController@exportPDF')->name('pdf');

Route::get('/autocomplete/customer/{query}', 'CustomerController@search')->name('search-customer');
Route::get('/autocomplete/item/{query}', 'ItemController@searchByDescription')->name('search-item');
Route::get('/autofill/{customer}', 'CustomerController@fetch')->name('customer-fetch');
