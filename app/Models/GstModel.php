<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class GstModel extends Model
{
    public static function generateJson($bill_id,$bill_date){


        $get_bill_data = AllBill::where('id',$bill_id)->where('billing_date',$bill_date)->first();
        if(empty($get_bill_data)){
            return false;
        }


        DB::beginTransaction();
        $MAINTAIN_AS_PARENT = 1;
        $SellerDtls = Plant::join('district','district.id','=','plant.district')
                    ->join('master_state','master_state.id','=','plant.state')
                    ->select('plant.*','master_state.states as state','district.district as district','gst_state_code')
                    ->where('plant.id',$get_bill_data->plant_id)
                    ->first();
        if($get_bill_data->is_pharma_bill == 1){
            $BuyerDtls = PharmaClient::join('district','district.id','=','pharma_client.contact_district')
                        ->join('master_state','master_state.id','=','pharma_client.contact_state')
                        ->select('pharma_client.*','pharma_client.gstin as gst_no','master_state.states as state','district.district as district','pharma_client.contact_address1 as address1','pharma_client.contact_address2 as address2','pharma_client.contact_pincode as pincode1','phone_number as phone_no','contact_person_email as email','gst_state_code')
                        ->where('pharma_client.id',$get_bill_data->client_id)
                        ->first();

            $buyer_email_id = !empty($BuyerDtls->email)?$BuyerDtls->email:'';

        }else{

            $BuyerDtls = Client::join('district','district.id','=','client.district1')
                        ->join('master_state','master_state.id','=','client.state1')
                        ->select('client.*','master_state.states as state','district.district as district','gst_state_code')
                        ->where('client.id',$get_bill_data->client_id)
                        ->first();

            $buyer_email_id = $BuyerDtls->person_email;
            if(empty($buyer_email_id)){
                $buyer_email_id = $BuyerDtls->email_id;
            }
        }



        if(empty($BuyerDtls)){
            return false;
        }

        // $strreplacedate = '28/02/2022';

        if($get_bill_data->igst_perc != '0' || $get_bill_data->igst_perc != 0 ){
            $IgstOnIntra = 'N';
            $gst_prec = $get_bill_data->igst_perc;
        }else{
            $IgstOnIntra = 'N';
            $gst_prec = $get_bill_data->sgst_perc+$get_bill_data->cgst_perc;
        }


        $finalArray['Version'] = "1.1";

        $finalArray["TranDtls"]["TaxSch"] ="GST";
        $finalArray["TranDtls"]["SupTyp"] ="B2B";
        $finalArray["TranDtls"]["IgstOnIntra"] =$IgstOnIntra; // N and Y
        $finalArray["TranDtls"]["RegRev"] =NULL;
        $finalArray["TranDtls"]["EcmGstin"] =NULL;

        $finalArray["DocDtls"]["Typ"] ="INV";
        $finalArray["DocDtls"]["No"] =$get_bill_data->bill_no;
        $finalArray["DocDtls"]["Dt"] =date('d/m/Y',strtotime($bill_date));

        $finalArray["SellerDtls"]["Gstin"] =$SellerDtls->gstin;
        $finalArray["SellerDtls"]["LglNm"] ='SYNERGY WASTE MANAGEMENT PRIVATE LIMITED';
        $finalArray["SellerDtls"]["TrdNm"] ='SYNERGY WASTE MANAGEMENT PRIVATE LIMITED';
        $finalArray["SellerDtls"]["Addr1"] =$SellerDtls->address1;
        $finalArray["SellerDtls"]["Addr2"] =!empty($SellerDtls->address2)?$SellerDtls->address2:'';
        $finalArray["SellerDtls"]["Loc"] =$SellerDtls->district;
        $finalArray["SellerDtls"]["Pin"] =(int)$SellerDtls->pincode;
        $finalArray["SellerDtls"]["Stcd"] =$SellerDtls->gst_state_code;
        $finalArray["SellerDtls"]["Ph"] =!empty($SellerDtls->telephone)?$SellerDtls->telephone:null;
        $finalArray["SellerDtls"]["Em"] =!empty($SellerDtls->email)?$SellerDtls->email:null;


        
        $finalArray["BuyerDtls"]["Gstin"] =$BuyerDtls->gst_no;
        $finalArray["BuyerDtls"]["LglNm"] =$BuyerDtls->business_name;
        $finalArray["BuyerDtls"]["TrdNm"] =$BuyerDtls->business_name;
        $finalArray["BuyerDtls"]["Pos"] =$BuyerDtls->gst_state_code;
        $finalArray["BuyerDtls"]["Addr1"] =$BuyerDtls->address1;
        $finalArray["BuyerDtls"]["Addr2"] =$BuyerDtls->address2;
        $finalArray["BuyerDtls"]["Loc"] =$BuyerDtls->district;
        $finalArray["BuyerDtls"]["Pin"] =(int)$BuyerDtls->pincode1;
        $finalArray["BuyerDtls"]["Stcd"] =$BuyerDtls->gst_state_code;
        $finalArray["BuyerDtls"]["Ph"] = !empty($BuyerDtls->phone_no)?$BuyerDtls->phone_no:null;
        $finalArray["BuyerDtls"]["Em"] = !empty($buyer_email_id)?$buyer_email_id:null;

        $assval = [];
        $igstval = [];
        $cgstval = [];
        $sgstval = [];
        $cessval = [];
        $stcessval = [];
        $discount = [];
        $othchrg = [];
        $rndoffamt = [];
        $TotInvVal = [];
        

        $igst = !empty($get_bill_data->igst)?$get_bill_data->igst:0;
        $cgst = !empty($get_bill_data->cgst)?$get_bill_data->cgst:0;
        $sgst = !empty($get_bill_data->sgst)?$get_bill_data->sgst:0;
        $final_amt = $get_bill_data->amount+$igst+$cgst+$sgst;
        // $gst_amt = $igst+$cgst+$sgst;

        $round_off_explode = explode('.', $final_amt);
        $round_off_var = !empty($round_off_explode[1])?$round_off_explode[1]:0;
        if($round_off_var > 0){
            $round_set = '0.'.$round_off_var;
            $round_off_var = $round_set*(-1);
            // dd($round_off_var);
        }
        

        $finalArray["ValDtls"]["AssVal"] = round($get_bill_data->amount,2);
        $finalArray["ValDtls"]["IgstVal"] = round($get_bill_data->igst,2);
        $finalArray["ValDtls"]["CgstVal"] = round($get_bill_data->cgst,2);
        $finalArray["ValDtls"]["SgstVal"] = round($get_bill_data->sgst,2);
        $finalArray["ValDtls"]["CesVal"] = 0;
        $finalArray["ValDtls"]["StCesVal"] = 0;
        $finalArray["ValDtls"]["Discount"] = 0;
        $finalArray["ValDtls"]["OthChrg"] = 0;
        $finalArray["ValDtls"]["RndOffAmt"] = $round_off_var;
        $finalArray["ValDtls"]["TotInvVal"] = round($final_amt);
        $blacnk = array();

        $prDetail['SlNo'] ="1";
        $prDetail['PrdDesc'] =null;
        $prDetail['IsServc'] ="Y";
        $prDetail['HsnCd'] ="999432";
        $prDetail['Qty'] =0;
        $prDetail['Unit'] ="OTH";
        $prDetail['UnitPrice'] =$get_bill_data->rate;
        $prDetail['TotAmt'] =$get_bill_data->amount;
        $prDetail['Discount'] =0;
        $prDetail['PreTaxVal'] =0;
        $prDetail['AssAmt'] =$get_bill_data->amount;
        $prDetail['GstRt'] =(float)$gst_prec;
        $prDetail['IgstAmt'] =(float)$igst;
        $prDetail['CgstAmt'] =(float)$cgst;
        $prDetail['SgstAmt'] =(float)$sgst;
        $prDetail['CesRt'] =(float)0;
        $prDetail['CesAmt'] =(float)0;
        $prDetail['CesNonAdvlAmt'] =(float)0;
        $prDetail['StateCesRt'] =(float)0;
        $prDetail['StateCesAmt'] =(float)0;
        $prDetail['StateCesNonAdvlAmt'] =(float)0;
        $prDetail['OthChrg'] =0;
        $prDetail['TotItemVal'] =round($final_amt,2);

        
        $blacnk[] = $prDetail;

        // $inum++;   
    

        $finalArray["ItemList"] = $blacnk;

        $jsonString = json_encode($finalArray);     

        $checkRes  = str_replace("'","",$jsonString);
        $str_test= str_replace('\"', '', $checkRes);
        $str = str_replace('\\', '', $str_test);

        $finalJson = preg_replace('/[^A-Za-z0-9\s:\/"{},[]]/', '', $str);

        $utf8 = utf8_encode($finalJson);
        $data = json_decode($utf8);

        $set_another_array = array($data);

        $output = json_encode($set_another_array,JSON_PRETTY_PRINT);

        return $output;
        // $dycrypt_str = base64_encode(AES_ENCRYPT($output, "CC4lBbgDB2klBXfNETG83DIqPPPGBDyfqXL0hwId4jM="));
        // DD($output);
    }
    public static function generateJsonforbulkbill($bill_id,$bill_date){


        $get_bill_data = AllBill::where('id',$bill_id)->where('billing_date',$bill_date)->first();
        if(empty($get_bill_data)){
            return false;
        }


        DB::beginTransaction();
        $MAINTAIN_AS_PARENT = 1;
        $SellerDtls = Plant::join('district','district.id','=','plant.district')
                    ->join('master_state','master_state.id','=','plant.state')
                    ->select('plant.*','master_state.states as state','district.district as district','gst_state_code')
                    ->where('plant.id',$get_bill_data->plant_id)
                    ->first();
        if($get_bill_data->is_pharma_bill == 1){
            $BuyerDtls = PharmaClient::join('district','district.id','=','pharma_client.contact_district')
                        ->join('master_state','master_state.id','=','pharma_client.contact_state')
                        ->select('pharma_client.*','pharma_client.gstin as gst_no','master_state.states as state','district.district as district','pharma_client.contact_address1 as address1','pharma_client.contact_address2 as address2','pharma_client.contact_pincode as pincode1','phone_number as phone_no','contact_person_email as email','gst_state_code')
                        ->where('pharma_client.id',$get_bill_data->client_id)
                        ->first();

            $buyer_email_id = !empty($BuyerDtls->email)?$BuyerDtls->email:'';

        }else{

            $BuyerDtls = Client::join('district','district.id','=','client.district1')
                        ->join('master_state','master_state.id','=','client.state1')
                        ->select('client.*','master_state.states as state','district.district as district','gst_state_code')
                        ->where('client.id',$get_bill_data->client_id)
                        ->first();

            $buyer_email_id = $BuyerDtls->person_email;
            if(empty($buyer_email_id)){
                $buyer_email_id = $BuyerDtls->email_id;
            }
        }



        if(empty($BuyerDtls)){
            return false;
        }

        // $strreplacedate = '28/02/2022';

        if($get_bill_data->igst_perc != '0' || $get_bill_data->igst_perc != 0 ){
            $IgstOnIntra = 'N';
            $gst_prec = $get_bill_data->igst_perc;
        }else{
            $IgstOnIntra = 'N';
            $gst_prec = $get_bill_data->sgst_perc+$get_bill_data->cgst_perc;
        }


        $finalArray['Version'] = "1.1";

        $finalArray["TranDtls"]["TaxSch"] ="GST";
        $finalArray["TranDtls"]["SupTyp"] ="B2B";
        $finalArray["TranDtls"]["IgstOnIntra"] =$IgstOnIntra; // N and Y
        $finalArray["TranDtls"]["RegRev"] =NULL;
        $finalArray["TranDtls"]["EcmGstin"] =NULL;

        $finalArray["DocDtls"]["Typ"] ="INV";
        $finalArray["DocDtls"]["No"] =$get_bill_data->bill_no;
        $finalArray["DocDtls"]["Dt"] =date('d/m/Y',strtotime($bill_date));

        $finalArray["SellerDtls"]["Gstin"] =$SellerDtls->gstin;
        $finalArray["SellerDtls"]["LglNm"] ='SYNERGY WASTE MANAGEMENT PRIVATE LIMITED';
        $finalArray["SellerDtls"]["TrdNm"] ='SYNERGY WASTE MANAGEMENT PRIVATE LIMITED';
        $finalArray["SellerDtls"]["Addr1"] =$SellerDtls->address1;
        $finalArray["SellerDtls"]["Addr2"] =!empty($SellerDtls->address2)?$SellerDtls->address2:'';
        $finalArray["SellerDtls"]["Loc"] =$SellerDtls->district;
        $finalArray["SellerDtls"]["Pin"] =(int)$SellerDtls->pincode;
        $finalArray["SellerDtls"]["Stcd"] =$SellerDtls->gst_state_code;
        $finalArray["SellerDtls"]["Ph"] =!empty($SellerDtls->telephone)?$SellerDtls->telephone:null;
        $finalArray["SellerDtls"]["Em"] =!empty($SellerDtls->email)?$SellerDtls->email:null;


        
        $finalArray["BuyerDtls"]["Gstin"] =$BuyerDtls->gst_no;
        $finalArray["BuyerDtls"]["LglNm"] =$BuyerDtls->business_name;
        $finalArray["BuyerDtls"]["TrdNm"] =$BuyerDtls->business_name;
        $finalArray["BuyerDtls"]["Pos"] =$BuyerDtls->gst_state_code;
        $finalArray["BuyerDtls"]["Addr1"] =$BuyerDtls->address1;
        $finalArray["BuyerDtls"]["Addr2"] =$BuyerDtls->address2;
        $finalArray["BuyerDtls"]["Loc"] =$BuyerDtls->district;
        $finalArray["BuyerDtls"]["Pin"] =(int)$BuyerDtls->pincode1;
        $finalArray["BuyerDtls"]["Stcd"] =$BuyerDtls->gst_state_code;
        $finalArray["BuyerDtls"]["Ph"] = !empty($BuyerDtls->phone_no)?$BuyerDtls->phone_no:null;
        $finalArray["BuyerDtls"]["Em"] = !empty($buyer_email_id)?$buyer_email_id:null;

        $assval = [];
        $igstval = [];
        $cgstval = [];
        $sgstval = [];
        $cessval = [];
        $stcessval = [];
        $discount = [];
        $othchrg = [];
        $rndoffamt = [];
        $TotInvVal = [];
        

        $igst = !empty($get_bill_data->igst)?$get_bill_data->igst:0;
        $cgst = !empty($get_bill_data->cgst)?$get_bill_data->cgst:0;
        $sgst = !empty($get_bill_data->sgst)?$get_bill_data->sgst:0;
        $final_amt = $get_bill_data->amount+$igst+$cgst+$sgst;
        // $gst_amt = $igst+$cgst+$sgst;

        $round_off_explode = explode('.', $final_amt);
        $round_off_var = !empty($round_off_explode[1])?$round_off_explode[1]:0;
        if($round_off_var > 0){
            $round_set = '0.'.$round_off_var;
            $round_off_var = $round_set*(-1);
            // dd($round_off_var);
        }
        

        $finalArray["ValDtls"]["AssVal"] = round($get_bill_data->amount,2);
        $finalArray["ValDtls"]["IgstVal"] = round($get_bill_data->igst,2);
        $finalArray["ValDtls"]["CgstVal"] = round($get_bill_data->cgst,2);
        $finalArray["ValDtls"]["SgstVal"] = round($get_bill_data->sgst,2);
        $finalArray["ValDtls"]["CesVal"] = 0;
        $finalArray["ValDtls"]["StCesVal"] = 0;
        $finalArray["ValDtls"]["Discount"] = 0;
        $finalArray["ValDtls"]["OthChrg"] = 0;
        $finalArray["ValDtls"]["RndOffAmt"] = $round_off_var;
        $finalArray["ValDtls"]["TotInvVal"] = round($final_amt);
        $blacnk = array();

        $prDetail['SlNo'] ="1";
        $prDetail['PrdDesc'] =null;
        $prDetail['IsServc'] ="Y";
        $prDetail['HsnCd'] ="999432";
        $prDetail['Qty'] =0;
        $prDetail['Unit'] ="OTH";
        $prDetail['UnitPrice'] =$get_bill_data->rate;
        $prDetail['TotAmt'] =$get_bill_data->amount;
        $prDetail['Discount'] =0;
        $prDetail['PreTaxVal'] =0;
        $prDetail['AssAmt'] =$get_bill_data->amount;
        $prDetail['GstRt'] =(float)$gst_prec;
        $prDetail['IgstAmt'] =(float)$igst;
        $prDetail['CgstAmt'] =(float)$cgst;
        $prDetail['SgstAmt'] =(float)$sgst;
        $prDetail['CesRt'] =(float)0;
        $prDetail['CesAmt'] =(float)0;
        $prDetail['CesNonAdvlAmt'] =(float)0;
        $prDetail['StateCesRt'] =(float)0;
        $prDetail['StateCesAmt'] =(float)0;
        $prDetail['StateCesNonAdvlAmt'] =(float)0;
        $prDetail['OthChrg'] =0;
        $prDetail['TotItemVal'] =round($final_amt,2);

        
        $blacnk[] = $prDetail;

        // $inum++;   
    

        $finalArray["ItemList"] = $blacnk;

        $jsonString = json_encode($finalArray);     

        $checkRes  = str_replace("'","",$jsonString);
        $str_test= str_replace('\"', '', $checkRes);
        $str = str_replace('\\', '', $str_test);

        $finalJson = preg_replace('/[^A-Za-z0-9\s:\/"{},[]]/', '', $str);

        $utf8 = utf8_encode($finalJson);
        $data = json_decode($utf8);

        $set_another_array = $data;

        // $output = json_encode($set_another_array,JSON_PRETTY_PRINT);


        return $set_another_array;
        // $dycrypt_str = base64_encode(AES_ENCRYPT($output, "CC4lBbgDB2klBXfNETG83DIqPPPGBDyfqXL0hwId4jM="));
        // DD($output);
    }

}
