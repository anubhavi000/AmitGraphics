<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EntryMast;
use App\Models\VendorMast;
use App\Models\PlantMast;
use App\Models\SupervisorMast;
use App\Models\VehicleMast;
use App\Models\ItemMast;
use App\Models\sites;
use Session;
use PDF;
use Auth;

class ExportData extends Model
{
    use HasFactory;

    public function export($col , $data){
    	
    }
}
