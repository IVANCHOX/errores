<?php

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

// ---- rutas oficiales ------ //
Route::get('/', 'ScrapingController@index');

Route::get('/empresa/{symbol}/resumen', 'CompanyController@resumen');
Route::get('/ajax/save/resumen/{symbol}', 'CompanyController@saveResumen');
Route::get('/ajax/save/history/{symbol}', 'CompanyController@saveHistory');
//-----------------------&/

//Route::get('/generar/excel/{tiker}', 'ScrapingController@generar');
Route::get('/generar/excel/historicos/{tiker}', 'ExcelGenerateController@generarHistoricos');

Route::get('/o', 'ScrapingController@o');

Route::get('/company/{tiker}', 'ScrapingController@getDataCompany');
Route::get('/company/{tiker}/financieros', 'ScrapingController@getDataFinancial');
Route::get('/company/{tiker}/estadisticos', 'ScrapingController@getDataEstadisticos');

Route::post('ajax/send/data', 'ScrapingController@receivedData');

// Ajax routes
Route::get('/ajax/get/all-companies/{searchWord}', 'ScrapingController@getAllCompanies');

//Route Get all Companies
Route::get('/companies','CompanyController@getFirstCompanies');

Route::get('/companies/{cantidad}', 'CompanyController@getRestCompanies');


//rutas ajax provisionales
Route::post('ajax/save/companies', 'CompanyController@saveCompanies');
