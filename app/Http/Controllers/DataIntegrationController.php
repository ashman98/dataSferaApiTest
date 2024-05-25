<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomApiException;
use App\Interfaces\Incomes\SaveIncomesDataInterface;
use App\Interfaces\Orders\SaveOrdersDataInterface;
use App\Interfaces\Sales\SaveSalesDataInterface;
use App\Interfaces\Stocks\SaveStocksDataInterface;
use App\Jobs\IntegrationProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataIntegrationController extends Controller
{
    /** @var SaveSalesDataInterface */
    private SaveSalesDataInterface $saveSalesDataService;

    /** @var SaveOrdersDataInterface */
    private SaveOrdersDataInterface $saveOrdersDataService;

    /** @var SaveStocksDataInterface */
    private SaveStocksDataInterface $saveStocksDataService;

    /** @var SaveIncomesDataInterface */
    private SaveIncomesDataInterface $saveIncomesDataService;


    /**
     * @param SaveSalesDataInterface $saveSalesDataService
     * @param SaveOrdersDataInterface $saveOrdersDataService
     * @param SaveStocksDataInterface $saveStocksDataService
     * @param SaveIncomesDataInterface $saveIncomesDataService
     */
    public function __construct(
        SaveSalesDataInterface $saveSalesDataService,
        SaveOrdersDataInterface $saveOrdersDataService,
        SaveStocksDataInterface $saveStocksDataService,
        SaveIncomesDataInterface $saveIncomesDataService
    )
    {
        $this->saveSalesDataService = $saveSalesDataService;
        $this->saveOrdersDataService = $saveOrdersDataService;
        $this->saveStocksDataService = $saveStocksDataService;
        $this->saveIncomesDataService = $saveIncomesDataService;
    }

    /** Sales Integration
     * @param Request $request
     * @return JsonResponse
     */
    public function sales(Request $request):JsonResponse
    {
        $body = [
            "dateFrom" => $request->input('from_date'),
            "dateTo" => $request->input('to_date'),
        ];

        try {
            IntegrationProcess::dispatch(
                'api/sales',
                env('API_DATA_SFERA_TOKEN'),
                $body,
                1,
                $this->saveSalesDataService
            )->delay(now()->addSeconds(1));
            Log::channel('integration')->alert('Batch processing initiated');

            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Incomes Integration
     * @param Request $request
     * @return JsonResponse
     */
    public function incomes(Request $request): JsonResponse
    {
        $body = [
            "dateFrom" => $request->input('from_date'),
            "dateTo" => $request->input('to_date'),
        ];

        try {
            IntegrationProcess::dispatch(
                'api/incomes',
                env('API_DATA_SFERA_TOKEN'),
                $body,
                1,
                $this->saveIncomesDataService
            )->delay(now()->addSeconds(1));
            Log::channel('integration')->alert('Batch processing initiated');

            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Stocks Integration
     * @param Request $request
     * @return JsonResponse
     */
    public function stocks(Request $request): JsonResponse
    {
        $body = [
            "dateFrom" => $request->input('from_date'),
            "dateTo" => $request->input('to_date'),
        ];
        try {
            IntegrationProcess::dispatch(
                'api/stocks',
                env('API_DATA_SFERA_TOKEN'),
                $body,
                1,
                $this->saveStocksDataService
            )->delay(now()->addSeconds(1));
            Log::channel('integration')->alert('Batch processing SUCCESS');

            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function orders(Request $request): JsonResponse
    {
        $body = [
            "dateFrom" => $request->input('from_date'),
            "dateTo" => $request->input('to_date'),
        ];
        try {
            IntegrationProcess::dispatch(
                'api/orders',
                env('API_DATA_SFERA_TOKEN'),
                $body,
                1,
                $this->saveOrdersDataService
            )->delay(now()->addSeconds(1));
            Log::channel('integration')->alert('Batch processing initiated');

            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
