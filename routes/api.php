<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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

Route::post('ipns/hook', 'PaymentController@stripeWebhook')->name('stripe_hook');

Route::post('vucameds', 'Api\VucamedsController@index');

// Route::post('pioneer-api', 'Api\PioneerController@index');

// Route::post('intakeq-api', 'Api\IntakeQController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('signature', 'SignaturePadController@upload')->name('signaturepad.upload');

    Route::get('analyze/{option}/{key?}/{default?}', 'ReportController@analyze');

    Route::get('settings/{option}/{key?}/{default?}', 'SettingController@single');

    Route::post('sms/{invoice}', 'MiscController@send_sms');
    Route::post('email/{invoice}', 'MiscController@send_email');

    Route::get('pioneer', 'Api\PioneerController@getAll');
    Route::get('intakeq/{type}', 'Api\IntakeQController@getAll');

    // custom
    Route::get('getOrders/{id}', 'PPPController@getOrders');
    Route::get('prescriberHistory/{id}', 'PPPController@getPrescriberOrders');
    Route::get('providerHistory/{id}', 'PPPController@getProviderOrders');
    Route::get('getOrderData/{user_id}/{order_id}', 'PPPController@getOrderData');
    Route::get('archived_orders', 'Api\ArchiveController@orders');

    Route::get('prescribersPremium/{premium}/{non_premium}', 'FormularyController@prescribersPremium');
    Route::get('myFormularies/{status}', 'FormularyController@myFormularies');
    Route::get('userData/{id}', 'UserController@prescriberData');

    Route::get('prescriberOrders/{id}', 'PrescriberController@getOrders');
    Route::get('prescriberInvoices/{id}', 'PrescriberController@getInvoices');
    Route::get('prescriberPatients/{id}', 'PrescriberController@getPatients');
    Route::get('prescriberPatientIds/{id}', 'PrescriberController@getPatientIds');
    Route::get('getPrescriberReports/{id}', 'PrescriberController@prescriberReport');

    Route::post('mirrorLogin', 'AuthController@mirrorLogin');

    // Reports
    Route::get('adminReports', 'ReportsController@admin_reports');
    Route::get('prescriberReports/{id}', 'ReportsController@provider_reports');

    // Pharmacy
    Route::get('getPharmacyPatientIDs/{id}', 'ProviderController@get_patients_ids');
    Route::get('getPharmacyData/{id}', 'ProviderController@get_pharmacy_data');

    Route::get('getPharmacyOrders/{id}', 'ProviderController@get_pharmacy_orders');

    Route::apiResources([
        'users'             => 'UserController',
        'suppliers'         => 'SupplierController',
        'patients'          => 'PatientController',
        'payments'          => 'PaymentController',
        'reports'           => 'ReportController',
        'orders'            => 'OrderController',
        'webhooks'          => 'WebHookController',
        'prescribers'       => 'PrescriberController',
        'products'          => 'ProductController',
        'invoices'          => 'InvoiceController',
        'patientEducation'  => 'PatientEducationController',
        'providers'         => 'ProviderController',
        'ppp'               => 'PPPController',
        'formularies'       => 'FormularyController',
        'stripeAccount'     => 'StripeAccountController',
        'duplicates'        => 'DuplicateController'
    ]);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('otp', 'AuthController@otp');
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@user');
    Route::any('logout', 'AuthController@logout');
});

Route::prefix('dashboard')->group(function () {
    Route::get('admin/{data_type}', 'Api\DashboardController@admin');
    Route::get('admin/paginate/{table_type}', 'Api\DashboardController@admin_paginate');
});
