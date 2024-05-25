<?php

namespace App\Services\Incomes;

use App\Interfaces\Incomes\SaveIncomesDataInterface;
use App\Interfaces\SaveIntegrationDataInterface;
use App\Services\AbstractServices\SaveIntegrationDataAbstract;
use Exception;
use Illuminate\Support\Facades\DB;

class SaveIncomesDataService extends SaveIntegrationDataAbstract implements SaveIncomesDataInterface, SaveIntegrationDataInterface
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
                'income_id' => $data['income_id'],
                'number' => $data['number'],
                'date' => $data['date'],
                'last_change_date' => $data['last_change_date'],
                'supplier_article' => $data['supplier_article'],
                'tech_size' => $data['tech_size'],
                'barcode' => $data['barcode'],
                'quantity' => $data['quantity'],
                'total_price' => $data['total_price'],
                'date_close' => $data['date_close'],
                'warehouse_name' => $data['warehouse_name'],
                'nm_id' => $data['nm_id'],
                'status' => $data['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('incomes')->insert($this->dataToInsert);
    }
}
