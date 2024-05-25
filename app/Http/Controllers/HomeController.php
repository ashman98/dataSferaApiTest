<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sales = [];
        $orders = [];
        $stocks = [];
        $incomes = [];

        return view('home.index', [
            'sales' => [
                "count" => DB::table('sales')->count(),
                "stocksData" => $sales,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ],
            'orders' => [
                "count" => DB::table('orders')->count(),
                "stocksData" => $orders,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ],
            'stocks' => [
                "count" => DB::table('stocks')->count(),
                "stocksData" => $stocks,
                "fromDate" =>  date('Y-m-d'),
            ],
            'incomes' => [
                "count" => DB::table('incomes')->count(),
                "stocksData" => $incomes,
                "fromDate" =>  date('Y-m-d'),
                "toDate" => date('Y-m-d'),
            ]
        ]);
    }
}
