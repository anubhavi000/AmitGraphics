<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('collection_public_view' , 'CollectionPublicViewController@index');

Route::post('check_user_company', 'API\LoginController@check_user_company');
Route::post('login_demo', 'API\LoginController@login_demo');
Route::post('user_daily_attendance_report', 'API\CommonController@user_daily_attendance_report');
Route::get('clientoptions', 'API\CommonController@clientoptions');
Route::get('groupoptions', 'API\CommonController@groupoptions');
Route::post('dashboard_attendacnce_api', 'API\CommonController@dashboard_attendacnce_api');
Route::post('no_attendance_report', 'API\CommonController@no_attendance_report');
Route::post('submit_bulk_credit', 'API\CommonController@submit_bulk_credit');
Route::post('submit_bulk_debit', 'API\CommonController@submit_bulk_debit');
Route::post('get_client_collection', 'API\CommonController@get_client_collection');
Route::post('get_client_payment_details', 'API\CommonController@get_client_payment_details');
Route::post('getclientlocation', 'API\CommonController@getclientlocation');
Route::post('DepartmentAndSubType', 'API\CommonController@DepartmentAndSubType');
Route::post('client_bill_details', 'API\CommonController@client_bill_details');
Route::post('client_outstanding_details', 'API\CommonController@client_outstanding_details');
Route::post('client_wise_ledger_details', 'API\CommonController@client_wise_ledger_details');
Route::post('store_api_data', 'API\CommonController@store_api_data');
Route::post('image_sync', 'API\SyncImagesControllers@image_sync');
Route::post('daily_reporting_pagination', 'API\CommonController@daily_reporting_pagination');
Route::any('checkbarcodekey', 'API\CommonController@checkbarcodekey');
Route::any('barcode_check', 'API\CommonController@barcode_check');
Route::post('wastecontainersubmit', 'API\CommonController@wastecontainersubmit');
Route::post('hcfCollectiontempReport', 'API\CommonController@hcfCollectiontempReport');
Route::post('wastecontainersubmit_temp', 'API\CommonController@wastecontainersubmit_temp');
Route::post('agreementpdf', 'API\CommonController@agreementpdf');
Route::post('update_hcf_client', 'API\CommonController@update_hcf_client');
Route::post('master_dropdown_api', 'API\CommonController@master_dropdown_api');
Route::post('syncClientClosingBalance', 'API\CommonController@syncClientClosingBalance');
Route::post('notification_list', 'API\CommonController@notification_list');
Route::post('agree_disagree_collection_details', 'API\CommonController@agree_disagree_collection_details');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
