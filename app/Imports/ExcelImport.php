<?php

namespace App\Imports;

use App\Models\EarlyBIllChanges;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new EarlyBIllChanges([
            'plant_id'=>!empty($row['plant_id'])?$row['plant_id']:'',
            'client_id'=>!empty($row['client_id'])?$row['client_id']:'',
            'route_id'=>!empty($row['route_id'])?$row['route_id']:'',
            'executive_id'=>!empty($row['executive_id'])?$row['executive_id']:'',
            'service_start_date'=>!empty($row['service_start_date'])?$row['service_start_date']:'',
            'billing_date'=>!empty($row['billing_date'])?$row['billing_date']:'',
            'month_year'=>!empty($row['month_year'])?$row['month_year']:'',
            'client_address'=>!empty($row['client_address'])?$row['client_address']:'',
            'fixed_amount'=>!empty($row['fixed_amount'])?$row['fixed_amount']:'',
            'file_no'=>!empty($row['file_no'])?$row['file_no']:'',
            'balance'=>!empty($row['balance'])?$row['balance']:'',
            'security'=>!empty($row['security'])?$row['security']:'',
            'remarks'=>!empty($row['remarks'])?$row['remarks']:'',
        ]);
    }
}
