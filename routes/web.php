<?php

// use VehicleController;

use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\BillingController;
use Illuminate\Routing\RouteAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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



// public url
// dd('2');
// Route::get('collection_public_view' , 'CollectionPublicViewController@index');

Route::get('document/{pagename}/{id}', 'ClientController@document');

// this is not related to synergy


// added by pankaj
// Route::get('getroutedata/{id}','RouteWiseBillController@GET_ROUTE_DATA')->name('GET_ROUTE_DATA');


Route::resource('Registration', 'RegistrationController');
Route::resource('RegistrationSecond', 'RegistrationSecondController');
Route::get('finalsubmit/{id}', 'RegistrationController@finalsubmit');
Route::get('finalsubmit2/{id}', 'RegistrationSecondController@finalsubmit');
Route::get('syncBank', 'SyncClientController@syncBank');
Route::get('get_client_option_public', 'CommonController@clientoptionspublic');
Route::get('jobMailScheduler', 'jobMailSchedulerController@jobMailScheduler');
Route::get('client_view_ledger_webview', 'ClientController@client_view_ledger_webview');

// dd('1');

// dd($_SERVER[]);

// original routing starts from here
Route::any('/', function () {
    // dd('1');
    return redirect('login');
});

Auth::routes();
Route::post('/is_user_blocked', 'EmployeeControllerNew@check_blocked');

Route::group(['middleware' => ['auth', 'module_assign']], function () {


    // Route::any('layout-set-side', 'LayoutController@setting_side')->name('layout-set-side');
    Route::any('layout-set', 'LayoutController@setting_menu')->name('layout-set');
    Route::any('layout-set-auth', 'LayoutController@setting_auth')->name('layout-set-auth');
    Route::get('/home', 'HomeController@index')->name('home');
    // Route::resource('/', 'MenuController');
    Route::resource('Vehicle', 'VehicleController');


    Route::resource('Plant', 'PlantController');
    Route::get('setPlant/{plant}', 'PlantController@setPlant');



    Route::resource('Billing', 'BillingController');
    Route::resource('PharmaBill', 'PharmaBillController');

    Route::resource('Users', 'UserController');

    Route::resource('UserAccSetting', "UserAccSettingController");


    Route::get('Notifications/create', 'NotificationController@create');
    Route::post('Notifications/store', 'NotificationController@store');
    Route::get('get_district_by_plant', 'CommonController@get_district_by_plant')->name('get_district_by_plant');
    Route::get('get_child_modules', 'DesignationModuleController@getChildModules');
    Route::get('get_module_prev_access', 'DesignationModuleController@getModulePrevAccess');



    Route::any('/exportcsv/{id}', 'ClientController@exportCsv');





// Route::get('/barcode2','BarcodeController@index' );
Route::resource('Barcode' , 'BarCodeController');
Route::get('barcode20','BarController@zero');

    // Mail with visitor' account (by ved)
    Route::get('/getmail', 'MailController@cancelindex');
    Route::post('/getmail', 'MailController@store');

//credit/Debit Routes added by ved

Route::resource('/creditdebit','CreditDebitNoteController2');

//client_routes backup routes by ved
//Testing routes for database table creation inside controller 
Route::get('/backup', 'BackupController@index');
Route::get('backup/clone' , 'BackupController@firstclick');
Route::get('backup/reverse/{id}','BackupController@secondclick');
Route::get('/backup/delete/{id}' , 'BackupController@delete');

//Whatsapp api  Routes added by ved
Route::get('whatsapp_bill' , 'BillingController@whatsapp_bill');


//Client Mailer list ROutes

Route::resource('Clientmailerlist' , 'ClientMailerListController');


//added by krishnan
    //Item
    Route::resource('ItemMast', 'ItemController');
    Route::post('ItemMast_delete', 'ItemController@destroy');

    //Plant
    Route::resource('PlantMast', 'PlantController');

    //Transport

    Route::resource('TransporterMast', 'TransporterController');

    //Vehicle

    Route::resource('VehicleMast', 'VehicleController');
    Route::post('VehicleMast_delete', 'VehicleController@destroy');

    //Vendor

    Route::resource('VendorMast', 'VendorController');

    //Supervisor

    Route::resource('SupervisorMast', 'SupervisorController');




    // always add routes on above this line 

    // Route::resource('Form', 'FormController');

    // // Route::get('Form/{id}', 'FormController@destroy');

    // Route::get('/{url}', 'CommonController@index');

    // Route::get('/{url}/create', 'CommonController@create');

    // Route::post('/{url}/store', 'CommonController@store');

    // Route::get('/{url}/{id}/edit', 'CommonController@edit');

    // Route::post('/{url}/update/{id}', 'CommonController@update');

    // Route::get('/{url}/{id}', 'CommonController@destroy');
     

});
