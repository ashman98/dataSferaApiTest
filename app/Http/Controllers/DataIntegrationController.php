<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomApiException;
use App\Interfaces\DataSferaCallApiInterface;
use App\Interfaces\Incomes\SaveIncomesDataInterface;
use App\Interfaces\Orders\SaveOrdersDataInterface;
use App\Interfaces\Sales\SaveSalesDataInterface;
use App\Interfaces\Stocks\SaveStocksDataInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $this->saveSalesDataService->save('api/sales', env('API_DATA_SFERA_TOKEN'),$body);
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
            $this->saveIncomesDataService->save('api/incomes', env('API_DATA_SFERA_TOKEN'),$body);
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
            $this->saveStocksDataService->save('api/stocks', env('API_DATA_SFERA_TOKEN'),$body);
            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Orders Integration
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
            $this->saveOrdersDataService->save('api/orders', env('API_DATA_SFERA_TOKEN'),$body);
            return response()->json(['message' => 'Data fetched and saved successfully']);
        } catch (CustomApiException $e) {
            return $e->render();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
