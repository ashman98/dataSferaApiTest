<?php

namespace App\Providers;

use App\Interfaces\DataSferaCallApiInterface;
use App\Interfaces\Incomes\SaveIncomesDataInterface;
use App\Interfaces\Orders\SaveOrdersDataInterface;
use App\Interfaces\Sales\SaveSalesDataInterface;
use App\Interfaces\SaveExternalDataInterface;
use App\Interfaces\SaveIntegrationDataInterface;
use App\Interfaces\Stocks\SaveStocksDataInterface;
use App\Services\DataSferaCallApiService;
use App\Services\Incomes\SaveIncomesDataService;
use App\Services\Orders\SaveOrdersDataService;
use App\Services\Sales\SaveSalesDataService;
use App\Services\SaveExternalDataService;
use App\Services\Stocks\SaveStocksDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DataSferaCallApiInterface::class, DataSferaCallApiService::class);
        $this->app->bind(SaveSalesDataInterface::class, SaveSalesDataService::class);
        $this->app->bind(SaveOrdersDataInterface::class, SaveOrdersDataService::class);
        $this->app->bind(SaveStocksDataInterface::class, SaveStocksDataService::class);
        $this->app->bind(SaveIncomesDataInterface::class, SaveIncomesDataService::class);
        $this->app->bind(SaveExternalDataInterface::class, SaveExternalDataService::class);
        $this->app->bind(SaveIntegrationDataInterface::class, SaveOrdersDataService::class);
        $this->app->bind(SaveIntegrationDataInterface::class, SaveStocksDataService::class);
        $this->app->bind(SaveIntegrationDataInterface::class, SaveIncomesDataService::class);
        $this->app->bind(SaveIntegrationDataInterface::class, SaveSalesDataService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
