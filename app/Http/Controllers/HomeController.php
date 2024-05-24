<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sales = DB::table('sales')
            ->orderBy('id', 'desc')
            ->get();

        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->get();

        $stocks = DB::table('stocks')
            ->orderBy('id', 'desc')
            ->get();

        $incomes = DB::table('incomes')
            ->orderBy('id', 'desc')
            ->get();

        return view('home.index', [
            'sales' => [
                "count" => count($sales),
                "stocksData" => $sales,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ],
            'orders' => [
                "count" => count($orders),
                "stocksData" => $orders,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ],
            'stocks' => [
                "count" => count($stocks),
                "stocksData" => $stocks,
                "fromDate" =>  date('Y-m-d'),
            ],
            'incomes' => [
                "count" => count($incomes),
                "stocksData" => $incomes,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ]
        ]);
    }
}
