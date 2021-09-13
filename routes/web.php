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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/get-data', function() {
    dispatch(new \App\Jobs\GetData());
    return redirect('/');
});


Route::get('/test', function() {
    $content = [];
    $content['system_environment_code'] = 'Development'; // Production | Development
    $content['trading_partners_unique_id'] = '1234'; // Trading Partners Unique ID
    $content['essendant_inc_unique_id'] = '007981038'; // Essendant Inc Unique ID
    $content['date_time_created'] = date("Y-m-d\Th:i:s", time()); // Date/Time Created
    $content['document_control_number'] = '00001'; // Document Control Number
    $content['action_code'] = 'R'; // Action Code
    $content['reference_tag'] = 'Reference Tag'; // Reference Tag

    // PurchaseOrderHeader
    $content['purchase_order_number'] = '1111'; // Purchase Order Header
    $content['reference_data'] = 'reference_data'; // Reference Data
    $content['reference_data'] = '';
    $content['essendant_inc_order_number'] = 'Essendant Inc Order Number'; // Essendant Inc Order Number
    $content['essendant_inc_order_number'] = 'Essendant Inc Order Number';

    $processPurchaseOrder = view('ProcessPurchaseOrder', $content)->render();
    echo $processPurchaseOrder;
});