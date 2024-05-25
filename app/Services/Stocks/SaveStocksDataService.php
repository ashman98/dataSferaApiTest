<?php

namespace App\Services\Stocks;

use App\Interfaces\SaveIntegrationDataInterface;
use App\Interfaces\Stocks\SaveStocksDataInterface;
use App\Services\AbstractServices\SaveIntegrationDataAbstract;
use Exception;
use Illuminate\Support\Facades\DB;

class SaveStocksDataService extends SaveIntegrationDataAbstract implements SaveStocksDataInterface, SaveIntegrationDataInterface
{
    /**
     * @return void
     * @throws Exception
     */
    public function save(): void
    {
        $this->validate();

        foreach ($this->dataList as $data) {
            $this->dataToInsert[] = [
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'is_supply' => $data['is_supply'],
                'is_realization' => $data['is_realization'],
                'quantity_full' => $data['quantity_full'],
                'in_way_to_client' => $data['in_way_to_client'],
                'in_way_from_client' => $data['in_way_from_client'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'sc_code' => $data['sc_code'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'warehouse_name' => $data['warehouse_name'],
                'nm_id' => $data['nm_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('stocks')->insert($this->dataToInsert);
    }
}
