<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VendorMast;
use App\Models\User;


class VehicleMast extends Model
{
    use HasFactory;
    protected $table = 'vehicle_mast';

    static function pluckactives(){
    	$data =  Self::where('status' , 1)
    			   ->orderBy('vehicle_no' , 'asc')
    			   ->pluck('vehicle_no' , 'id')
    			   ->toArray();
    	$data2 = natsort($data);
    	// dd($data);
    	return $data;
    }
    static function pluckall(){
        $data = Self::orderBy('vehicle_no' , 'asc')
                    ->pluck('vehicle_no' , 'id')
                    ->toArray();
        $data2 = natsort($data);
        return $data;
   }
    static function export($data){
        $vendors = VendorMast::pluckactives();
        $users = User::pluckall();

        $str = '';
        $str .= "S.no , Vehicle No. , Vehicle Type ,  Vehicle Pass Wt. , Description , Transporter , Created By , Created At";
        $str .= "\n";

        foreach ($data as $key => $value) {
            $str .= $key + 1;$str.=",";
            $str .= $value->vehicle_no.',';
            $str .= !empty($value->type) ? $value->type : '';$str .= ",";
            $str .= !empty($value->pass_wt) ? $value->pass_wt : '';$str .= ",";
            $str .= !empty($value->descr) ? $value->descr : '';$str .= ',';
            $str .= !empty($vendors[$value->vendor]) ? $vendors[$value->vendor] : '';$str .= ",";
            $str .= !empty($users[$value->created_by]) ? $users[$value->created_by] : '';$str .= ",";
            $str .= !empty($value->created_at) ? date('d-m-Y' , strtotime($value->created_at)) : '';$str .= ",";
            $str .= "\n";
        }
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=vehicles.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $str;
            die();        
    }
}
