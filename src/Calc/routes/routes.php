<?php

Route::pattern('id', '\d+');
Route::pattern('all', 'all');

/**
 * Default routes
 */
Route::group(['before' => 'guest'], function ()
{
    Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    Route::post('/login', 'AuthController@postLogin');
});

Route::group(['prefix' => '/', 'before' => 'auth'], function ()
{
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
    Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@getIndex']);
    Route::post('profile', 'ProfileController@update');


    if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isHeadManager()))
    {
        Route::get('managers', 'ManagersController@index');
        Route::get('managers/{id}', 'ManagersController@show');
        Route::get('parts', 'PartsController@index');
        Route::get('coefficients', 'CoefficientsController@index');
        Route::get('elements', 'ElementsController@index');
    }

    Route::get('calculation', 'CalculationController@index');
    Route::get('calculation/order/{id}', 'MakeOrderController@show');
    Route::get('calculation/create', 'CalculationController@create');
    Route::get('calculation/{id}', 'CalculationController@show');
    Route::get('calculation/{id}/edit', 'CalculationController@edit');
    Route::put('calculation/{id}', 'CalculationController@update');

    Route::get('orders', 'OrdersController@index');
    Route::get('orders/edit/{id}', 'OrdersController@edit');
    Route::get('orders/{id}', 'OrdersController@show');
    Route::get('contractors', 'ContractorsController@index');
    Route::get('contractors/{id}', 'ContractorsController@show');
    Route::get('clients', 'ClientsController@index');
    Route::get('clients/{id}', 'ClientsController@show');

    Route::get('/', ['as' => 'root', 'uses' => 'DashboardController@getIndex']);
});

/**
 * API
 *
 * Инициализируем роуты только для авторизованных
 */
if (Auth::check())
{
    Route::group(['prefix' => 'api', 'before' => 'api'], function ()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isHeadManager())
        {
            /** Менеджеры */
            Route::get('managers', 'Api\ManagersController@index');
        }

        if (Auth::user()->isAdmin())
        {
            Route::post('managers', 'Api\ManagersController@store');
            Route::get('managers/create', 'Api\ManagersController@create');
            Route::get('managers/{id}', 'Api\ManagersController@show');
            Route::put('managers/{id}', 'Api\ManagersController@update');
            Route::get('managers/{id}/edit', 'Api\ManagersController@edit');
            Route::delete('managers/{id}', 'Api\ManagersController@destroy');

            /** Ставки конструкторов */
            Route::get('constructors-rates', 'Api\ConstructorsRatesController@index');
            Route::post('constructors-rates', 'Api\ConstructorsRatesController@store');

            /** Коэффициенты */
            Route::get('coefficients', 'Api\CoefficientsController@index');
            Route::post('coefficients', 'Api\CoefficientsController@store');

            /** Дополнительные коэффициенты */
            Route::get('additional-coefficients', 'Api\AdditionalCoefficientsController@index');
            Route::post('additional-coefficients', 'Api\AdditionalCoefficientsController@store');

            /** Переменные */
            Route::put('variables/{name}', 'Api\VariablesController@update');

            /** Материалы / Комплектующие */
            Route::get('parts/{id}/edit', 'Api\PartsController@edit');
            Route::put('parts/{id}', 'Api\PartsController@update');
            Route::delete('parts/{id}', 'Api\PartsController@destroy');
            Route::get('parts/duplicate/{id}', 'Api\PartsController@duplicate');
            Route::post('parts', 'Api\PartsController@store');

            /** Элементы / Категории */
            Route::get('elements', 'Api\ElementsController@index');
            Route::post('elements/category', 'Api\ElementsController@category');
            Route::post('elements/element', 'Api\ElementsController@element');
            Route::post('elements', 'Api\ElementsController@store');
            Route::delete('elements/category/{id}', 'Api\ElementsController@deleteCategory');
            Route::delete('elements/element/{id}', 'Api\ElementsController@deleteElement');
        }

        /** Расчеты */
        Route::get('calculations', 'Api\CalculationsController@index');
        //Route::get('calculations/create', 'Api\CalculationsController@create');
        Route::post('calculations', 'Api\CalculationsController@create');
        Route::get('calculations/duplicate/{id}', 'Api\CalculationsController@duplicate');
        Route::delete('calculations/income/{id}', 'Api\CalculationsController@destroyIncome');
        Route::post('calculations/{id}/income', 'Api\CalculationsController@createIncome');
        Route::get('calculations/{id}', 'Api\CalculationsController@show');
        //Route::get('calculations/{id}/edit', 'Api\CalculationsController@edit');
        Route::put('calculations/order/{id}', 'Api\CalculationsController@updateFromOrders');
        Route::put('calculations/{id}', 'Api\CalculationsController@update');
        Route::delete('calculations/{id}', 'Api\CalculationsController@destroy');

        /** Подрядчики */
        Route::get('contractors', 'Api\ContractorsController@index');
        Route::get('contractors/create', 'Api\ContractorsController@create');
        Route::post('contractors', 'Api\ContractorsController@store');
        Route::get('contractors/{id}', 'Api\ContractorsController@show');
        Route::get('contractors/{id}/edit', 'Api\ContractorsController@edit');
        Route::put('contractors/{id}', 'Api\ContractorsController@update');
        Route::delete('contractors/{id}', 'Api\ContractorsController@destroy');

        /** Переменные */
        Route::get('variables', 'Api\VariablesController@index');
        Route::get('variables/{name}', 'Api\VariablesController@show');

        /** Заказы / Подряды */
        Route::get('orders', 'Api\OrdersController@index');
        Route::get('orders/create', 'Api\OrdersController@create');
        Route::post('orders', 'Api\OrdersController@store');
        Route::get('orders/{id}', 'Api\OrdersController@show');
        Route::post('orders/{id}/outlay/{type}', 'Api\OrdersController@createOutlay')
            ->where('type', 'contractor_outlay|constructor_outlay');
        Route::get('orders/{id}/edit', 'Api\OrdersController@edit');
        Route::put('orders/{id}', 'Api\OrdersController@updateFromOrders');
        Route::delete('orders/outlay/{id}/{type}', 'Api\OrdersController@destroyOutlay');
        Route::delete('orders/{id}', 'Api\OrdersController@destroy');

        /** Клиенты */
        Route::get('clients', 'Api\ClientsController@index');
        Route::get('clients/create', 'Api\ClientsController@create');
        Route::post('clients', 'Api\ClientsController@store');
        Route::get('clients/{id}', 'Api\ClientsController@show');
        Route::get('clients/{id}/edit', 'Api\ClientsController@edit');
        Route::put('clients/{id}', 'Api\ClientsController@update');
        Route::delete('clients/{id}', 'Api\ClientsController@destroy');

        /** Материалы / Комплектующие */
        Route::get('parts', 'Api\PartsController@index');
        Route::get('parts/create', 'Api\PartsController@create');
        Route::get('parts/{id}', 'Api\PartsController@show');

        Route::get('groups-parts', 'Api\GroupsPartsController@index');

        Route::get('managers-roles/{all?}', 'Api\HelpersController@managersRoles');
        Route::get('clients-statuses/{all?}', 'Api\HelpersController@clientsStatuses');
        Route::get('clients-types/{all?}', 'Api\HelpersController@clientsTypes');
        Route::get('contractors-statuses/{all?}', 'Api\HelpersController@contractorsStatuses');
        Route::get('orders-statuses/{all?}', 'Api\HelpersController@ordersStatuses');
        Route::get('calculations-statuses/{all?}', 'Api\HelpersController@calculationsStatuses');
        Route::get('managers-statuses/{all?}', 'Api\HelpersController@managersStatuses');

        /** Списки клиентов, менеджеров, подрядчиков, комплектующих */
        Route::get('clients-list/{all?}', 'Api\HelpersController@clients');
        Route::get('managers-list/{all?}', 'Api\HelpersController@managers');
        Route::get('contractors-list/{all?}', 'Api\HelpersController@contractors');
        Route::get('parts-list/{all?}', 'Api\HelpersController@parts');

        /** Работа с файлами */
        Route::post('files/upload/{fileable_type}/{fileable_id}', 'Api\FilesController@upload')
            ->where('fileable_type', 'calculation|order')
            ->where('fileable_id', '\d+');
        Route::delete('files/{id}', 'Api\FilesController@destroy');
    });
}

