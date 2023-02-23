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

    // to export average item report data
    public static function exportavgitem($data , $total , $from_date , $to_date){
    	$items = ItemMast::pluckactives();
    	$str = '';
    	$str .= ",Average Item Report";
    	$str .= "\n";
    	$str .= "From Date :".','.$from_date.',';
    	$str .= "To Date :".','.$to_date;
    	$str .= "\n";
        $str .= "S.no , Item , Total Weight , percentage";
        $str .= "\n";
    	if(!empty($data)){
    		$row = 1;
    		foreach ($data  as $key => $value) {
    			$str .= $row.',';
    			$str .= $items[$key].',';
    			$str .=	$value.',';
    			if($total != 0){
    				$str .= round(($value/$total)*100 , 2);
    			}
    			else{
    				$str .= 0;
    			}
    			$str .= "\n";
    			$row++;
    		}
    		$str .= "Grand Total ,";
    		$str .= ",".$total;	
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=manualchallans.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $str;
            die();    		
    	}
    }
    static function exportavgsites($data , $total , $from_date , $to_date){
        $sites = sites::activesitespluck();
        $str = '';
        $str .= ",Average Sites Report";
        $str .= "\n";
        $str .= "From Date :".','.$from_date.',';
        $str .= "To Date :".','.$to_date;
        $str .= "\n";
        $str .= "S.no , Site , Total Weight , Percentage";
        $str .= "\n";
        if(!empty($data)){
            $row = 1;
            foreach ($data  as $key => $value) {
                $str .= $row.',';
                $str .= $sites[$key].',';
                $str .= $value.',';
                if($total != 0){
                    $str .= round(($value/$total)*100 , 2);
                }
                else{
                    $str .= 0;
                }
                $str .= "\n";
                $row++;
            }
            $str .= "Grand Total ,";
            $str .= ",".$total; 
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=manualchallans.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $str;
            die();          
        }        
    }
    static function exportavgsitesitems($data  , $total , $from_date , $to_date){
        $sites = sites::activesitespluck();
        $items = ItemMast::pluckactives();
        $str = '';
        $str .= ",Item and Unloading Site Wise";
        $str .= "\n";
        $str .= "From Date :".','.$from_date.',';
        $str .= "To Date :".','.$to_date;
        $str .= "\n";
        $str .= "S.no , Site , Item , Total , Percentage";
        $str .= "\n";
        if(!empty($data)){
            $row = 1;
            foreach ($data  as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $str .= $row.',';
                    $str .= !empty($sites[$key]) ? $sites[$key] : ''; $str .= ',';
                    $str .= !empty($items[$key2]) ? $items[$key2] : '';$str .=',';
                    $str .= !empty($value2) ? $value2 : ''; $str .= ',';
                    if($total != 0){
                        $val  = ($value2/$total)*100;
                        $str .=  round($val , 2);$str .= ',';
                    }
                    else{
                        $str .= ',';
                    }
                    $str .= "\n";
                    $row++;
                }
            }   
        }    
            $str .= "Grand Total ,";
            $str .= ",,".$total; 
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=manualchallans.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $str;
            die();                   
    }
}
