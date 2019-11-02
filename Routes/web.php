<?php

$currentHostname = app(Hyn\Tenancy\Contracts\CurrentHostname::class);

if(is_null($currentHostname)) {
    Route::domain(config('configuration.app_url_base'))->group(function() {

        Route::get('/', 'WelcomeController@index')->name('system.welcome.index');

        Route::get('dashboard', function () {
            return redirect()->route('system.dashboard.index');
        });

//        dd(config('configuration.app_prefix_admin'));

        Route::prefix(config('configuration.app_prefix_admin'))->group(function () {

            Route::get('login', 'LoginController@showLoginForm')->name('login');
            Route::post('login', 'LoginController@login');
            Route::post('logout', 'LoginController@logout')->name('logout');

            Route::middleware('auth:admin')->group(function() {
                Route::redirect('/', '/administrator/dashboard');
                Route::get('dashboard', 'DashboardController@index')->name('system.dashboard.index');
                Route::prefix('clients')->group(function () {
                    Route::get('/', 'ClientController@index')->name('system.clients.index');
                    Route::get('init_data_table', 'ClientController@initTable');
                    Route::get('records', 'ClientController@records');
                    Route::get('create', 'ClientController@create');
                    Route::get('tables', 'ClientController@tables');
                    Route::get('charts', 'ClientController@charts');
                    Route::post('/', 'ClientController@store');
                    Route::delete('{client}', 'ClientController@destroy');
                    Route::post('password/{client}', 'ClientController@password');
                });

                Route::prefix('documents')->group(function () {
                    Route::get('/', 'DocumentController@index')->name('system.documents.index');
                    Route::get('records/{client_id}', 'DocumentController@records');
                    Route::get('tables', 'DocumentController@tables');
                    Route::post('send', 'DocumentController@send');
                });

                Route::prefix('service')->group(function () {
                    Route::get('{type}/{number}', 'ClientController@service');
                });

            });
        });

    });
} else {
    Route::domain($currentHostname->fqdn)->group(function() {
//        Route::get('/login', 'Tenant\LoginController@showLoginForm')->name('login');
//        Route::post('/logout', 'Tenant\LoginController@logout')->name('logout');
//        Route::post('/login', 'Tenant\LoginController@login');

        Route::prefix('core')->group(function () {
            Route::get('session_change/{establishment}/{year}/{soap_type_id}', function ($establishment_id, $year, $soap_type_id) {
                Environment::query()->first()->update([
                    'soap_type_id' => $soap_type_id,
                ]);
                session([
                    'session_soap_type_id' => $soap_type_id,
                    'session_establishment_id' => $establishment_id,
                    'session_year' => $year,
                ]);
            });
        });
    });
}
