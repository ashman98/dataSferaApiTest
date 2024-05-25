<?php

namespace App\Services\Orders;

use App\Interfaces\Orders\SaveOrdersDataInterface;
use App\Interfaces\SaveIntegrationDataInterface;
use App\Services\AbstractServices\SaveIntegrationDataAbstract;
use Exception;
use Illuminate\Support\Facades\DB;

class SaveOrdersDataService extends SaveIntegrationDataAbstract implements SaveOrdersDataInterface, SaveIntegrationDataInterface
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
                'g_number' => $data['g_number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'total_price' => $data['total_price'],
                'discount_percent' => $data['discount_percent'],
                'warehouse_name' => $data['warehouse_name'],
                'oblast' => $data['oblast'],
                'income_id' => $data['income_id'],
                'odid' => $data['odid'],
                'nm_id' => $data['nm_id'],
                'subject' => $data['subject'],
                'category' => $data['category'],
                'brand' => $data['brand'],
                'is_cancel' => $data['is_cancel'],
                'cancel_dt' => $data['cancel_dt'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('orders')->insert($this->dataToInsert);
    }
}
