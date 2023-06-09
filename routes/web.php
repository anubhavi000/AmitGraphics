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
Route::get('/', function () {
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
    Route::delete('user_delete/{id}' , 'UserController@destroy');

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


//masters added by ved 
    //Item
    Route::resource('ItemMast', 'ItemController');
    Route::delete('Item_delete/{id}', 'ItemController@delete');
    //Plant
    Route::resource('PlantMast', 'PlantController');
    Route::delete('Plant_delete/{id}' , 'PlantController@delete');
    //Transport
    Route::resource('TransporterMast', 'TransporterController');
    Route::delete('Transporter_delete/{id}'  , 'TransporterController@delete');
    //Vehicle
    Route::resource('VehicleMast', 'VehicleController');
    Route::delete('VehicleMast_delete/{id}', 'VehicleController@delete');
    //Vendor
    Route::resource('VendorMast', 'VendorController');
    Route::delete('Vendor_delete/{id}' , 'VendorController@delete');
    //Supervisor
    Route::resource('SupervisorMast', 'SupervisorController');
    Route::delete('Supervisor_delete/{id}' , 'SupervisorController@delete');
    //vendor rate 
    Route::resource('VendorRateMaster' , 'vendorRateController');
    route::delete('vendorrate_delete/{id}' ,  'vendorRateController@destroy');

    // Routes added By ved
    Route::resource('EntryForm'  , 'EntriesController');
    Route::delete('EntryForm_delete/{id}'  , 'EntriesController@destroy');

    Route::get('EntryForm_action/{id}'  , 'EntriesController@action');
    Route::post('return_tranporter' , 'EntriesController@return_tranporter')->name('return_tranporter');
    Route::post('return_tranporter' , 'EntriesController@return_tranporter')->name('return_tranporter');
    Route::post('return_vendor' , 'VehicleController@return_vendor')->name('return_vendor');
    Route::post('check_duplicacy' , 'EntriesController@check_if_duplicate');
    Route::post('SlipGeneration/{id}' , 'EntriesController@SlipGeneration')->name('SlipGeneration');
    Route::get('GeneratedSlips' , 'EntriesController@ShowGeneratedSlips')->name('GeneratedSlips');

    Route::resource('Module', "ModuleController");
    Route::resource('DesignationModule', "DesignationModuleController");   
    Route::get('print_invoice/{plant}/{slip_no}' , 'EntriesController@PrintInvoice'); 
    Route::get('PrintEntrySlip/{slip_no}', 'EntriesController@PrintSlip'); 


    Route::resource('SiteMaster' , 'SiteMastController');
    Route::get('SiteMaster/edit/{id}' , 'SiteMastController@edit');
    Route::delete('delete_site/{id}' , 'SiteMastController@delete');

    Route::resource('Designation' , 'DesignationController');
    Route::delete('designation_delete/{id}' , 'DesignationController@destroy');

    // routes For chalan generation ved
    Route::get('ChalanGeneration' , 'EntriesController@chalanindex');


    //Routes for manual challan entries --ved
    Route::get('ManualChallan' , 'EntriesController@ManualChallan');
    Route::get('ManualChallan/create' , 'EntriesController@ManualChallanCreation');
    Route::get('ManualChallan/edit/{id}' , 'EntriesController@ManualChallanEdition' );
    Route::post('ManualChallanStore' , 'EntriesController@ManualChallanStore')->name('ManualChallanStore');
    Route::post('ManualChallanupdate/{id}' , 'EntriesController@manualupdate');
    Route::post('check_duplicacy_both_slips'  , 'EntriesController@check_duplicacy_orignal_slip');
    Route::post('get_vehicle_pass_wt' , 'VehicleController@get_vehicle_pass_wt');    
    Route::resource('ExcessWeightedSlips' , 'ExcessweightSlipController');
    Route::post('checkslipduplicate' , 'EntriesController@checkslipduplicatemanual');
    Route::get('check_vehicle_Availiblity'  ,   'VehicleController@checkavailiblity');

    Route::get('Reports/{slug}' , 'ReportController@retunrnhnadler');
    //ends

    //payement routes by ved
    Route::resource('PaymentChecking' , 'PaymentCheckingController');
    //ends


    //Average Report Routes Added By Ved
    Route::get('AverageReports/{slug}' , 'AverageReportsController@index');
    Route::get('test' , function(){
        return view('test');
    });

    //paymentform routes by veds
    Route::resource('PaymentForm' , 'PaymentFormController');
    Route::delete('PaymentForm_delete/{id}' , 'PaymentFormController@destroy');
    Route::post('PaymentForm_update/{id}' , 'PaymentFormController@update');
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
