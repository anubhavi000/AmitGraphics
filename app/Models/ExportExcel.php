<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Exception;

class ExportExcel extends Model
{

	public static function export_dynamically($thead_array, $tbody_array, $file_name)
	{

		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';

		foreach ($thead_array as $key => $value) {
			// code...
			$output .= $value . ',';
		}

		$output .= "\n";
		$i = 1;


		if ($file_name == 'gst_report') {
			// dd('fghj');

			$export_name = 'GstReport.csv';
			// dd($tbody_array);
			foreach ($tbody_array as $body_key => $body_value) {

				$output .= !empty($body_value['billing_date']) ? date('d-m-Y', strtotime($body_value['billing_date'])) . ',' : ',';
				$output .= !empty($body_value['bill_no']) ? preg_replace('/,/', ' ', $body_value['bill_no']) . ',' : ',';
				$output .= !empty($body_value['client_char_id']) ? preg_replace('/,/', ' ', $body_value['client_char_id']) . ',' : ',';
				$output .= !empty($body_value['client_name']) ? preg_replace('/,/', ' ', $body_value['client_name']) . ',' : ',';
				$output .= !empty($body_value['state']) ? preg_replace('/,/', ' ', $body_value['state']) . ',' : ',';
				$output .= !empty($body_value['district']) ? preg_replace('/,/', ' ', $body_value['district']) . ',' : ',';
				$output .= !empty($body_value['city']) ? preg_replace('/,/', ' ', $body_value['city']) . ',' : ',';
				$output .= !empty($body_value['gst_no']) ? preg_replace('/,/', ' ', $body_value['gst_no']) . ',' : ',';
				if ($body_value['igst_perc'] > 0) {
					$tax_type = 'IGST';
				} elseif ($body_value['sgst_perc'] > 0 && $body_value['cgst_perc'] > 0) {
					$tax_type = 'CGST+SGST';
				} else {
					$tax_type = 'No';
				}
				$output .= $tax_type . ',';
				$output .= !empty($body_value['amount']) ? $body_value['amount'] . ',' : ',';
				$output .= !empty($body_value['after_gst_amount']) ? $body_value['after_gst_amount'] . ',' : ',';
				$output .= !empty($body_value['after_gst_amount']) ? $body_value['after_gst_amount'] + $body_value['amount'] . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'plant_wise_agreement_end') {
			// dd($file_name);

			$export_name = 'plant_wise_agreement_end.csv';
			// dd($tbody_array);

			foreach ($tbody_array as $body_key => $body_value) {
				$activitystatus = '';
				if ($body_value->status == 0) {
					$activitystatus = 'inactive';
				} else {
					if ($body_value->status == 1) {
						$activitystatus = 'active';
					}
				}
				$security_deposit = Client::partyCurrentOutstanding($body_value->client_char_id, 'sec');
				$main_balance = Client::partyCurrentOutstanding($body_value->client_char_id, 'normal');
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value['client_char_id']) ? preg_replace('/,/', ' ', $body_value['client_char_id']) . ',' : ',';
				$output .= !empty($body_value['business_name']) ? preg_replace('/,/', ' ', $body_value['business_name']) . ',' : ',';
				$output .= !empty($body_value['file_no']) ? preg_replace('/,/', ' ', $body_value['file_no']) . ',' : ',';
				$output .= !empty($body_value['district_name']) ? preg_replace('/,/', ' ', $body_value['district_name']) . ',' : ',';
				$output .= !empty($body_value['name_of_person']) ? preg_replace('/,/', ' ', $body_value['name_of_person']) . ',' : ',';
				$output .= !empty($body_value['person_contact']) ? preg_replace('/,/', ' ', $body_value['person_contact']) . ',' : ',';
				$output .= !empty($body_value['person_email']) ? preg_replace('/[^A-Za-z0-9@.\-]/', ' ', $body_value['person_email']) . ',' : ',';
				$output .= !empty($body_value['agreement_end_date']) ? date('d-m-Y', strtotime($body_value['agreement_end_date'])) . ',' : ',';
				$output .= !empty($body_value['service_start_date']) ? date('d-m-Y', strtotime($body_value['service_start_date'])) . ',' : ',';

				if ($body_value['billing_type'] == 1) {
					$output .= !empty($body_value['fixed_amount_total_beds']) ? preg_replace('/,/', ' ', $body_value['fixed_amount_total_beds']) . ',' : ',';
					$output .= !empty($body_value['maximum_weight']) ? preg_replace('/,/', ' ', $body_value['maximum_weight']) . ',' : ',';
					$output .= !empty($body_value['minimum_amount']) ? preg_replace('/,/', ' ', $body_value['minimum_amount']) . ',' : ',';
				} elseif ($body_value['billing_type'] == 2) {
					$output .= !empty($body_value['per_bed_total_beds']) ? preg_replace('/,/', ' ', $body_value['per_bed_total_beds']) . ',' : ',';
					$output .= !empty($body_value['per_bed_maximum_weight']) ? preg_replace('/,/', ' ', $body_value['per_bed_maximum_weight']) . ',' : ',';
					$output .= !empty($body_value['per_bed_amount']) ? preg_replace('/,/', ' ', $body_value['per_bed_amount']) . ',' : ',';
				} elseif ($body_value['billing_type'] == 3) {
					$output .= !empty($body_value['per_kg_total_beds']) ? preg_replace('/,/', ' ', $body_value['per_kg_total_beds']) . ',' : ',';
					$output .= !empty($body_value['per_kg_maximum_weight']) ? preg_replace('/,/', ' ', $body_value['per_kg_maximum_weight']) . ',' : ',';
					$output .= !empty($body_value['per_kg_amount']) ? preg_replace('/,/', ' ', $body_value['per_kg_amount']) . ',' : ',';
				} else {
					$output .= ',';
					$output .= ',';
					$output .= ',';
				}
				$output .= !empty($security_deposit) ? preg_replace('/,/', ' ', $security_deposit) . ',' : ',';
				$output .= !empty($main_balance) ? preg_replace('/,/', ' ', $main_balance) . ',' : ',';
				$output .= !empty($activitystatus) ? preg_replace('/,/', ' ', $activitystatus) . ',' : ',';
				$output .= !empty($body_value['client_renewal_re']['renewal_date']) ? date('d-m-Y', strtotime($body_value['client_renewal_re']['renewal_date'])) . ',' : ',';
				$output .= !empty($body_value['client_renewal_re']['approved']) ? preg_replace('/,/', ' ', $body_value['client_renewal_re']['approved']) . ',' : '0,';


				$output .= "\n";
				$i++;
			}
			// dd($output);
		}
		if ($file_name == 'bed_count') {
			$export_name = 'bedCount.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->business_name) ? preg_replace('/,/', ' ', $value->business_name) . ',' : ',';

				if (!empty($value->is_govt_client) && $value->is_govt_client == 1) {
					$output .= 'Govt.,';
				} else if ($value->is_govt_client == 0) {
					$output .= 'Pvt.,';
				} else {
					$output .= '-,';
				}

				$output .= !empty($value->state_name) ? preg_replace('/,/', ' ', $value->state_name) . ',' : ',';
				$output .= !empty($value->district_name) ? preg_replace('/,/', ' ', $value->district_name) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';

				/*
				$output .= !empty($value->name_of_person) ? preg_replace('/,/', ' ', $value->name_of_person) . ',' : ',';
				$output .= !empty($value->person_contact) ? preg_replace('/,/', ' ', $value->person_contact) . ',' : ',';
				$output .= !empty($value->person_email) ? preg_replace('/,/', ' ', $value->person_email) . ',' : ',';
				*/


				if ($value->billing_type == 1) {

					$output .= !empty($value->fixed_amount_total_beds) ? preg_replace('/,/', ' ', $value->fixed_amount_total_beds) . ',' : ',';
				} else if ($value->billing_type == 2) {

					$output .= !empty($value->per_bed_total_beds) ? preg_replace('/,/', ' ', $value->per_bed_total_beds) . ',' : ',';
				} else if ($value->billing_type == 3) {

					$output .= !empty($value->per_kg_total_beds) ? preg_replace('/,/', ' ', $value->per_kg_total_beds) . ',' : ',';
				} else {
					$output .= ',';
				}
				if (!empty($value->status) && $value->status == 1) {
					$output .= 'Active ,';
				} else {

					$output .= 'In Active ,';
				}






				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'new_connected_client') {
			$export_name = 'NewConnectedClientReport.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->business_name) ? preg_replace('/,/', ' ', $value->business_name) . ',' : ',';
				$output .= !empty($value->state_name) ? preg_replace('/,/', ' ', $value->state_name) . ',' : ',';
				$output .= !empty($value->district_name) ? preg_replace('/,/', ' ', $value->district_name) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->route_name) ? preg_replace('/,/', ' ', $value->route_name) . ',' : ',';
				if ($value->billing_type == 1) {

					$output .= !empty($value->fixed_amount_total_beds) ? preg_replace('/,/', ' ', $value->fixed_amount_total_beds) . ',' : '0,';
					$output .= !empty($value->minimum_amount) ? preg_replace('/,/', ' ', $value->minimum_amount) . ',' : '0,';
				} else if ($value->billing_type == 2) {

					$output .= !empty($value->per_bed_total_beds) ? preg_replace('/,/', ' ', $value->per_bed_total_beds) . ',' : '0,';
					$output .= !empty($value->per_bed_amount) ? preg_replace('/,/', ' ', $value->per_bed_amount) . ',' : '0,';
				} else if ($value->billing_type == 3) {

					$output .= !empty($value->per_kg_total_beds) ? preg_replace('/,/', ' ', $value->per_kg_total_beds) . ',' : '0,';
					$output .= !empty($value->per_kg_amount) ? preg_replace('/,/', ' ', $value->per_kg_amount) . ',' : '0,';
				} else {
					$output .= '0,';
					$output .= '0,';
				}

				$output .= !empty($value->agreement_start_date) ? date('d-m-Y', strtotime($value->agreement_start_date)) . ',' : ',';
				$output .= !empty($value->agreement_end_date) ? date('d-m-Y', strtotime($value->agreement_end_date)) . ',' : ',';
				$output .= !empty($value->service_start_date) ? date('d-m-Y', strtotime($value->service_start_date)) . ',' : ',';
				$output .= !empty($value->created_at) ? date('d-m-Y', strtotime($value->created_at)) . ',' : ',';

				$activitystatus = '';
				if ($value->status == 1) {
					$activitystatus = 'active';
				} else {
					if ($value->status == 0) {
						$activitystatus = 'inactive';
					}
				}
				$output .= !empty($activitystatus) ? preg_replace('/,/', ' ', $activitystatus) . ',' : ',';







				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'route_wise_bill_summary') {


			$export_name = 'route_wise_bill_summary.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				// $security_deposit = Client::partyCurrentOutstanding($body_value->client_char_id, 'sec');
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->total_beds) ? preg_replace('/,/', ' ', $body_value->total_beds) . ',' : ',';
				$output .= !empty($body_value->BillCount) ? preg_replace('/,/', ' ', $body_value->BillCount) . ',' : ',';
				$output .= !empty(ConstantHelper::cus_number_format($body_value->bill_amount)) ? preg_replace('/,/', ' ', ConstantHelper::cus_number_format($body_value->bill_amount)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'pharma_bill_summary') {


			$export_name = 'pharma_bill_summary.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				// $security_deposit = Client::partyCurrentOutstanding($body_value->client_char_id, 'sec');
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->BillCount) ? preg_replace('/,/', ' ', $body_value->BillCount) . ',' : ',';
				$output .= !empty(ConstantHelper::cus_number_format($body_value->bill_amount)) ? preg_replace('/,/', ' ', ConstantHelper::cus_number_format($body_value->bill_amount)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'district_wise_bill_summary') {

			// dd($tbody_array);

			$export_name = 'district_wise_bill_summary.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				// $security_deposit = Client::partyCurrentOutstanding($body_value->client_char_id, 'sec');


				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->total_beds) ? preg_replace('/,/', ' ', $body_value->total_beds) . ',' : ',';
				$output .= !empty($body_value->BillCount) ? preg_replace('/,/', ' ', $body_value->BillCount) . ',' : ',';
				$output .= !empty(ConstantHelper::cus_number_format($body_value->bill_amount)) ? preg_replace('/,/', ' ', ConstantHelper::cus_number_format($body_value->bill_amount)) . ',' : ',';


				$output .= "\n";
			}
		}

		if ($file_name == 'early_bill_genration') {
			// dd("excle");

			$export_name = 'Early Bill Generation.csv';

			foreach ($tbody_array as $body_key => $body_value) {

				$check_collc = $body_value['total_collection'] - $body_value['weight_limit'];

				$output .= !empty($body_value['client_char_id']) ? preg_replace('/,/', ' ', $body_value['client_char_id']) . ',' : ',';
				$output .= !empty($body_value['client_name']) ? preg_replace('/,/', ' ', $body_value['client_name']) . ',' : ',';
				$output .= !empty($body_value['client_govt_pvt']) ? preg_replace('/,/', ' ', $body_value['client_govt_pvt']) . ',' : ',';
				$output .= !empty($body_value['billing_type']) ? preg_replace('/,/', ' ', $body_value['billing_type']) . ',' : ',';
				$output .= !empty($body_value['po_number']) ? preg_replace('/,/', ' ', $body_value['po_number']) . ',' : '0,';
				$output .= !empty($body_value['route_name']) ? preg_replace('/,/', ' ', $body_value['route_name']) . ',' : ',';
				$output .= !empty($body_value['master_fixed_amount']) ? preg_replace('/,/', ' ', $body_value['master_fixed_amount']) . ',' : ',';
				$output .= !empty($body_value['bill_fixed_amount']) ? preg_replace('/,/', ' ', $body_value['bill_fixed_amount']) . ',' : ',';
				$output .= !empty($body_value['master_weight_limit']) ? preg_replace('/,/', ' ', $body_value['master_weight_limit']) . ',' : ',';
				$output .= !empty($body_value['weight_limit']) ? preg_replace('/,/', ' ', $body_value['weight_limit']) . ',' : ',';
				$output .= !empty($body_value['total_collection']) ? preg_replace('/,/', ' ', $body_value['total_collection']) . ',' : '0,';
				if ($check_collc > 0) {
					$output .= $check_collc . ',';
				} else {
					$output .= "0" . ',';
				}
				$output .= !empty($body_value['is_excess_billed']) ? preg_replace('/,/', ' ', $body_value['is_excess_billed']) . ',' : ',';
				$output .= !empty($body_value['rate']) ? preg_replace('/,/', ' ', $body_value['rate']) . ',' : '0,';
				$output .= !empty($body_value['excess_rate']) ? preg_replace('/,/', ' ', $body_value['excess_rate']) . ',' : '0,';
				$output .= !empty($body_value['total_beds']) ? preg_replace('/,/', ' ', $body_value['total_beds']) . ',' : '0,';
				$output .= !empty($body_value['fixed_bed']) ? preg_replace('/,/', ' ', $body_value['fixed_bed']) . ',' : '0,';
				$output .= $body_value['total_beds'] - $body_value['fixed_bed'] . ',';
				$output .= !empty($body_value['total_amount']) ? preg_replace('/,/', ' ', $body_value['total_amount']) . ',' : ',';
				$output .= !empty($body_value['gst_amt']) ? preg_replace('/,/', ' ', $body_value['gst_amt']) . ',' : '0,';
				$output .= !empty($body_value['amount_after_gst']) ? preg_replace('/,/', ' ', $body_value['amount_after_gst']) . ',' : '0,';
				$output .= !empty($body_value['billing_date']) ? preg_replace('/,/', ' ', $body_value['billing_date']) . ',' : '0,';
				$output .= !empty($body_value['is_arrears_applied']) ? preg_replace('/,/', ' ', $body_value['is_arrears_applied']) . ',' : ',';
				$output .= !empty($body_value['out_standing']) ? preg_replace('/,/', ' ', $body_value['out_standing']) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}


		if ($file_name == 'plant_and_route_wise_bill_summary_report') {
			$export_name = 'plant_and_route_wise_bill_summary_report.csv';
			foreach ($tbody_array as $body_key => $body_value) {

				$output .= $body_key + 1 . ',';

				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';

				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				if ($body_value->is_govt_client == 1) {
					$output .= "Govt" . ',';
				} else {
					$output .= "Pvt" . ',';
				}

				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : '0,';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';

				if ($body_value->is_gst_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				$output .= !empty($body_value->billing_date) ? date('d-m-Y', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'not_billed_client_report') {
			$export_name = 'Not Billed Client.csv';
			foreach ($tbody_array as $body_key => $body_value) {

				$output .= $body_key + 1 . ',';

				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';

				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';

				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';

				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';

				if ($body_value->billing_type == 1) {
					$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
				} elseif ($body_value->billing_type == 2) {
					$output .= !empty($body_value->per_bed_amount) ? preg_replace('/,/', ' ', $body_value->per_bed_amount) . ',' : ',';
				} elseif ($body_value->billing_type == 3) {
					$output .= !empty($body_value->per_kg_amount) ? preg_replace('/,/', ' ', $body_value->per_kg_amount) . ',' : ',';
				} else {
					$output .= '0,';
				}

				if ($body_value->is_govt_client == 1) {

					$output .= "Govt" . ',';
				} elseif ($body_value->is_govt_client == 0 &&  $body_value->is_govt_client != null) {
					$output .= "Pvt" . ',';
				} else {
					$output .= "-" . ',';
				}
				if ($body_value->occupancy_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "Inactive" . ',';
				}


				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'excess_waste_report') {

			// dd($tbody_array);

			$export_name = 'excess_waste_report.csv';
			foreach ($tbody_array as $body_key => $body_value) {

				$check_collc = $body_value['total_collection'] - $body_value['weight_limit'];
				if ($check_collc > 0) {
					$i = 1;

					$output .= $i . ',';
					$output .= !empty($body_value['client_char_id']) ? preg_replace('/,/', ' ', $body_value['client_char_id']) . ',' : ',';
					$output .= !empty($body_value['client_govt_pvt']) ? preg_replace('/,/', ' ', $body_value['client_govt_pvt']) . ',' : ',';
					$output .= !empty($body_value['client_name']) ? preg_replace('/,/', ' ', $body_value['client_name']) . ',' : ',';
					$output .= (!empty($value['address1']) ? $value['address1'] . ',' : '') . (!empty($value['address2']) ? $value['address2'] . ',' : '') . (!empty($value['city']) ? $value['city'] . ',' : '') . (!empty($value['district']) ? $value['district'] . ',' : '') . (!empty($value['state']) ? $value['state'] . '-' : '') . (!empty($value['pincode']) ? $value['pincode'] . ',' : '') . ',';
					$output .= !empty($body_value['file_no']) ? preg_replace('/,/', ' ', $body_value['file_no']) . ',' : ',';
					$output .= !empty($body_value['district']) ? preg_replace('/,/', ' ', $body_value['district']) . ',' : '0,';
					$output .= !empty($body_value['route_name']) ? preg_replace('/,/', ' ', $body_value['route_name']) . ',' : ',';
					$output .= !empty($body_value['total_beds']) ? preg_replace('/,/', ' ', $body_value['total_beds']) . ',' : ',';
					$output .= !empty($body_value['bill_fixed_amount']) ? preg_replace('/,/', ' ', $body_value['bill_fixed_amount']) . ',' : ',';
					$output .= !empty($body_value['weight_limit']) ? preg_replace('/,/', ' ', $body_value['weight_limit']) . ',' : ',';
					$output .= !empty($body_value['total_collection']) ? preg_replace('/,/', ' ', $body_value['total_collection']) . ',' : ',';
					$output .= ($check_collc > 0) ? round($check_collc) . ',' : ',';
					$output .= !empty($body_value['is_excess_billed']) ? preg_replace('/,/', ' ', $body_value['is_excess_billed']) . ',' : ',';
					$output .= !empty($body_value['excess_rate']) ? preg_replace('/,/', ' ', $body_value['excess_rate']) . ',' : '0,';
					$output .= !empty($body_value['total_amount']) ? preg_replace('/,/', ' ', $body_value['total_amount']) . ',' : ',';
					$output .= "\n";
					$i++;
				}
			}
		}

		if ($file_name == 'state_wise_closing') {

			// dd($tbody_array);

			$export_name = 'state_wise_closing.csv';
			foreach ($tbody_array as $body_key => $body_value) {



				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value['client_char_id']) ? preg_replace('/,/', ' ', $body_value['client_char_id']) . ',' : ',';
				$output .= !empty($body_value['business_name']) ? preg_replace('/,/', ' ', $body_value['business_name']) . ',' : ',';
				$output .= !empty($body_value['state_name']) ? preg_replace('/,/', ' ', $body_value['state_name']) . ',' : ',';
				$output .= !empty($body_value['district_name']) ? preg_replace('/,/', ' ', $body_value['district_name']) . ',' : ',';
				$output .= !empty($body_value['route_name']) ? preg_replace('/,/', ' ', $body_value['route_name']) . ',' : '0,';

				if (!empty($body_value['opening_balance'])) {
					if (stripos($body_value['opening_balance'], 'dr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['opening_balance']) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}
				if (!empty($body_value['opening_balance'])) {
					if (stripos($body_value['opening_balance'], 'cr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['opening_balance'] * -1) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}
				if (!empty($body_value['closing_balance'])) {
					if (stripos($body_value['closing_balance'], 'dr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['closing_balance']) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}
				if (!empty($body_value['closing_balance'])) {
					if (stripos($body_value['closing_balance'], 'cr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['closing_balance'] * -1) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}
				if (!empty($body_value['balance'])) {
					if (stripos($body_value['balance'], 'dr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['balance']) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}
				if (!empty($body_value['balance'])) {
					if (stripos($body_value['balance'], 'cr'))
						$output .= preg_replace('/,/', ' ', (float)$body_value['balance'] * -1) . ',';
					else
						$output .= '0,';
				} else {
					$output .= '0,';
				}


				if (!empty($body_value->is_govt_client) && $body_value->is_govt_client == 1) {
					$output .= "Govt" . ',';
				} else {
					$output .= "Pvt" . ',';
				}
				if (!empty($body_value->status) && $body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'agreement_end_state_wise') {

			// dd($tbody_array);

			$export_name = 'agreement_end_state_wise.csv';
			foreach ($tbody_array as $body_key => $body_value) {



				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
				$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : '0,';
				$output .= !empty($body_value->person_email) ? preg_replace('/,/', ' ', $body_value->person_email) . ',' : '0,';
				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				$output .= "\n";
				$i++;
			}
		}


		if ($file_name == 'client_route_details_state_wise') {

			// dd($tbody_array);

			$export_name = 'client_route_details_state_wise.csv';
			foreach ($tbody_array as $body_key => $body_value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->client_address) ? preg_replace('/,/', ' ', $body_value->client_address) . ',' : ',';
				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				if ($body_value->billing_type == 1) {
					$output .= !empty($body_value->fixed_amount_total_beds) ? preg_replace('/,/', ' ', $body_value->fixed_amount_total_beds) . ',' : '0,';
					$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : '0,';
					$output .= !empty($body_value->maximum_weight) ? preg_replace('/,/', ' ', $body_value->maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 2) {
					$output .= !empty($body_value->per_bed_total_beds) ? preg_replace('/,/', ' ', $body_value->per_bed_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_bed_amount) ? preg_replace('/,/', ' ', $body_value->per_bed_amount) . ',' : '0,';
					$output .= !empty($body_value->per_bed_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_bed_maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 3) {
					$output .= !empty($body_value->per_kg_total_beds) ? preg_replace('/,/', ' ', $body_value->per_kg_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_kg_amount) ? preg_replace('/,/', ' ', $body_value->per_kg_amount) . ',' : '0,';
					$output .= !empty($body_value->per_kg_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_kg_maximum_weight) . ',' : '0,';
				} else {
					$output .= "" . ',';
					$output .= "" . ',';
					$output .= "" . ',';
				}
				$output .= !empty($body_value->excess_rate) ? preg_replace('/,/', ' ', $body_value->excess_rate) . ',' : '0,';
				if ($body_value->is_excess_billed == 1) {

					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				if ($body_value->is_arrears_applied == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				if ($body_value->is_gst_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				if ($body_value->occupancy_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				$output .= !empty($body_value->supply_charges) ? preg_replace('/,/', ' ', $body_value->supply_charges) . ',' : '0,';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->service_start_date) ? date('d-m-Y', strtotime($body_value->service_start_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'inactive_clients_on_route') {

			$export_name = 'inactive_clients_on_route.csv';
			foreach ($tbody_array as $body_key => $body_value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				if ($body_value->enabled == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				if ($body_value->billing_type == 1) {
					$output .= !empty($body_value->fixed_amount_total_beds) ? preg_replace('/,/', ' ', $body_value->fixed_amount_total_beds) . ',' : '0,';
					$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : '0,';
					$output .= !empty($body_value->maximum_weight) ? preg_replace('/,/', ' ', $body_value->maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 2) {
					$output .= !empty($body_value->per_bed_total_beds) ? preg_replace('/,/', ' ', $body_value->per_bed_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_bed_amount) ? preg_replace('/,/', ' ', $body_value->per_bed_amount) . ',' : '0,';
					$output .= !empty($body_value->per_bed_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_bed_maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 3) {
					$output .= !empty($body_value->per_kg_total_beds) ? preg_replace('/,/', ' ', $body_value->per_kg_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_kg_amount) ? preg_replace('/,/', ' ', $body_value->per_kg_amount) . ',' : '0,';
					$output .= !empty($body_value->per_kg_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_kg_maximum_weight) . ',' : '0,';
				} else {
					$output .= "" . ',';
					$output .= "" . ',';
					$output .= "" . ',';
				}
				$output .= !empty($body_value->registration_fee) ? preg_replace('/,/', ' ', $body_value->registration_fee) . ',' : '0,';
				$output .= !empty($body_value->security_deposit) ? preg_replace('/,/', ' ', $body_value->security_deposit) . ',' : '0,';
				$output .= !empty($body_value->excess_rate) ? preg_replace('/,/', ' ', $body_value->excess_rate) . ',' : '0,';
				if ($body_value->is_excess_billed == 1) {
					$output .= "Yes" . ',';
				} elseif ($body_value->is_excess_billed == 0) {
					$output .= "No" . ',';
				} else {
					$output .= "" . ',';
				}
				$output .= !empty($body_value->occupancy_applicable) ? preg_replace('/,/', ' ', $body_value->occupancy_applicable) . ',' : '0,';
				$output .= !empty($body_value->supply_charges) ? preg_replace('/,/', ' ', $body_value->supply_charges) . ',' : '0,';
				$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : '0,';
				$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : '0,';
				$output .= !empty($body_value->person_email) ? preg_replace('/,/', ' ', $body_value->person_email) . ',' : '0,';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->service_start_date) ? date('d-m-Y', strtotime($body_value->service_start_date)) . ',' : ',';
				$output .= !empty($body_value->address1) ? preg_replace('/,/', ' ', $body_value->address1) . ',' : '0,';
				$output .= !empty($body_value->remark) ? preg_replace('/,/', ' ', $body_value->remark) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'active_client_not_on_route') {

			$export_name = 'active_client_not_on_route.csv';
			foreach ($tbody_array as $body_key => $body_value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				if ($body_value->billing_type == 1) {
					$output .= !empty($body_value->fixed_amount_total_beds) ? preg_replace('/,/', ' ', $body_value->fixed_amount_total_beds) . ',' : '0,';
					$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : '0,';
					$output .= !empty($body_value->maximum_weight) ? preg_replace('/,/', ' ', $body_value->maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 2) {
					$output .= !empty($body_value->per_bed_total_beds) ? preg_replace('/,/', ' ', $body_value->per_bed_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_bed_amount) ? preg_replace('/,/', ' ', $body_value->per_bed_amount) . ',' : '0,';
					$output .= !empty($body_value->per_bed_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_bed_maximum_weight) . ',' : '0,';
				} elseif ($body_value->billing_type == 3) {
					$output .= !empty($body_value->per_kg_total_beds) ? preg_replace('/,/', ' ', $body_value->per_kg_total_beds) . ',' : '0,';
					$output .= !empty($body_value->per_kg_amount) ? preg_replace('/,/', ' ', $body_value->per_kg_amount) . ',' : '0,';
					$output .= !empty($body_value->per_kg_maximum_weight) ? preg_replace('/,/', ' ', $body_value->per_kg_maximum_weight) . ',' : '0,';
				} else {
					$output .= "" . ',';
					$output .= "" . ',';
					$output .= "" . ',';
				}
				$output .= !empty($body_value->registration_fee) ? preg_replace('/,/', ' ', $body_value->registration_fee) . ',' : '0,';
				$output .= !empty($body_value->security_deposit) ? preg_replace('/,/', ' ', $body_value->security_deposit) . ',' : '0,';
				$output .= !empty($body_value->excess_rate) ? preg_replace('/,/', ' ', $body_value->excess_rate) . ',' : '0,';
				if ($body_value->is_excess_billed == 1) {
					$output .= "Yes" . ',';
				} elseif ($body_value->is_excess_billed == 0) {
					$output .= "No" . ',';
				} else {
					$output .= "" . ',';
				}
				$output .= !empty($body_value->occupancy_applicable) ? preg_replace('/,/', ' ', $body_value->occupancy_applicable) . ',' : '0,';
				$output .= !empty($body_value->supply_charges) ? preg_replace('/,/', ' ', $body_value->supply_charges) . ',' : '0,';
				$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : '0,';
				$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : '0,';
				$output .= !empty($body_value->person_email) ? preg_replace('/,/', ' ', $body_value->person_email) . ',' : '0,';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->service_start_date) ? date('d-m-Y', strtotime($body_value->service_start_date)) . ',' : ',';
				$output .= !empty($body_value->address1) ? preg_replace('/,/', ' ', $body_value->address1) . ',' : '0,';
				$output .= !empty($body_value->remark) ? preg_replace('/,/', ' ', $body_value->remark) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'renewel_client') {

			$export_name = 'renewel_client.csv';
			foreach ($tbody_array as $body_key => $body_value) {


				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->contact_person_name) ? preg_replace('/,/', ' ', $body_value->contact_person_name) . ',' : ',';
				$output .= !empty($body_value->contact_person_phone) ? preg_replace('/,/', ' ', $body_value->contact_person_phone) . ',' : ',';
				$output .= !empty($body_value->last_agreement_start_date) ? date('d-m-Y', strtotime($body_value->last_agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->last_agreement_end_date) ? date('d-m-Y', strtotime($body_value->last_agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->old_minimum_amount) ? preg_replace('/,/', ' ', $body_value->old_minimum_amount) . ',' : '0,';
				if ($body_value->billing_type == 1) {
					$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : '0,';
				} elseif ($body_value->billing_type == 2) {
					$output .= !empty($body_value->per_bed_amount) ? preg_replace('/,/', ' ', $body_value->per_bed_amount) . ',' : '0,';
				} elseif ($body_value->billing_type == 3) {
					$output .= !empty($body_value->per_kg_amount) ? preg_replace('/,/', ' ', $body_value->per_kg_amount) . ',' : '0,';
				} else {
					$output .= "" . ',';
				}

				$output .= !empty($body_value->remark) ? preg_replace('/,/', ' ', $body_value->remark) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'route_changes_report') {

			// dd($tbody_array);
			// dd("inside" , $thead_array);

			$export_name = 'route_changes_report.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->old_route_name) ? preg_replace('/,/', ' ', $body_value->old_route_name) . ',' : ',';
				$output .= !empty($body_value->narration) ? preg_replace('/,/', ' ', $body_value->narration) . ',' : ',';
				$output .= !empty($body_value->created_at) ? date('d-m-Y  H:i:s', strtotime($body_value->created_at)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'client_index') {



			$export_name = 'client_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
				$output .= !empty($body_value->client_group_name) ? preg_replace('/,/', ' ', $body_value->client_group_name) . ',' : ',';
				$output .= !empty($body_value->client_type_name) ? preg_replace('/,/', ' ', $body_value->client_type_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';

				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
				$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
				$output .= !empty($body_value->person_email) ? preg_replace('/,/', ' ', $body_value->person_email) . ',' : ',';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->created_at) ? date('d-m-Y', strtotime($body_value->created_at)) . ',' : ',';
				$output .= !empty($body_value->emp1_full_name) ? preg_replace('/,/', ' ', $body_value->emp1_full_name) . ',' : ',';
				$output .= !empty($body_value->updated_at) ? date('d-m-Y', strtotime($body_value->updated_at)) . ',' : ',';
				$output .= !empty($body_value->emp2_full_name) ? preg_replace('/,/', ' ', $body_value->emp2_full_name) . ',' : ',';

				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'client_logs_report') {



			$export_name = 'Clients Logs report.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
				$output .= !empty($body_value->client_group_name) ? preg_replace('/,/', ' ', $body_value->client_group_name) . ',' : ',';
				$output .= !empty($body_value->client_type_name) ? preg_replace('/,/', ' ', $body_value->client_type_name) . ',' : ',';
				$output .= !empty($body_value->state_name) ? preg_replace('/,/', ' ', $body_value->state_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';

				if ($body_value->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "In Active" . ',';
				}
				$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
				$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
				$output .= !empty($body_value->person_email) ? preg_replace('/,/', ' ', $body_value->person_email) . ',' : ',';
				$output .= !empty($body_value->agreement_start_date) ? date('d-m-Y', strtotime($body_value->agreement_start_date)) . ',' : ',';
				$output .= !empty($body_value->agreement_end_date) ? date('d-m-Y', strtotime($body_value->agreement_end_date)) . ',' : ',';
				$output .= !empty($body_value->created_at) ? date('d-m-Y', strtotime($body_value->created_at)) . ',' : ',';
				$output .= !empty($body_value->emp1_full_name) ? preg_replace('/,/', ' ', $body_value->emp1_full_name) . ',' : ',';
				$output .= !empty($body_value->updated_at) ? date('d-m-Y', strtotime($body_value->updated_at)) . ',' : ',';
				$output .= !empty($body_value->emp2_full_name) ? preg_replace('/,/', ' ', $body_value->emp2_full_name) . ',' : ',';

				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'billing_index') {



			$export_name = 'billing_index.csv';


			foreach ($tbody_array as $body_key => $body_value) {
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->month) ? $body_value->month . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : '0,';

				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', $body_value->paid_amount) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', $body_value->pending_amount) . ',' : '0,';
				$output .= !empty($body_value->created_at) ? date('d-m-Y H:i:s', strtotime($body_value->created_at)) . ',' : ',';
				$output .= !empty($body_value->emp1_full_name) ? preg_replace('/,/', ' ', $body_value->emp1_full_name) . ',' : ',';
				$output .= !empty($body_value->updated_at) ? date('d-m-Y H:i:s', strtotime($body_value->updated_at)) . ',' : ',';
				$output .= !empty($body_value->emp2_full_name) ? preg_replace('/,/', ' ', $body_value->emp2_full_name) . ',' : ',';
				$output .= "\n";
			}



			$i++;
		}


		// added by ved

		if ($file_name == 'cancelled_bill_report') {
			$export_name = 'CancelledBillsReport.csv';
			foreach ($tbody_array['bill_nos'] as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($tbody_array['bill_series']) ? preg_replace('/,/', ' ', $tbody_array['bill_series']) . ',' : ',';
				$output .= !empty($value) ? preg_replace('/,/', ' ', $value) . ',' : ',';

				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'pharma_waste_report') {
			$export_name = 'pharma_waste.csv';

			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->pharma_client_name) ? preg_replace('/,/', ' ', $value->pharma_client_name) . ',' : ',';
				$output .= !empty($value->bill_no) ? preg_replace('/,/', ' ', $value->bill_no) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->date) ? preg_replace('/,/', ' ', $value->date) . ',' : ',';
				$output .= !empty($value->number_of_bags) ? preg_replace('/,/', ' ', $value->number_of_bags) . ',' : ',';

				$output .= !empty($value->transporter_name) ? preg_replace('/,/', ' ', $value->transporter_name) . ',' : ',';
				$output .= !empty($value->gr_number) ? preg_replace('/,/', ' ', $value->gr_number) . ',' : ',';
				$output .= !empty($value->lr_number) ? preg_replace('/,/', ' ', $value->lr_number) . ',' : ',';


				$output .= "\n";
				$i++;
			}

			// Master dropdown reports excel added by ved

		}
		if ($file_name == 'Consumable') {
			$export_name = 'consumable.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->measured_name) ? preg_replace('/,/', ' ', $value->measured_name) . ',' : ',';

				$output .= !empty($value->description) ? preg_replace('/,/', ' ', $value->description) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'Department') {
			$export_name = 'department.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->description) ? preg_replace('/,/', ' ', $value->description) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'Designation') {
			$export_name = 'designation.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->description) ? preg_replace('/,/', ' ', $value->description) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'Bank') {
			$export_name = 'bank.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->code) ? preg_replace('/,/', ' ', $value->code) . ',' : ',';
				$output .= !empty($value->type) ? preg_replace('/,/', ' ', $value->type) . ',' : ',';



				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'Vendordetails') {
			$export_name = 'vendordetails.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';

				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->email) ? preg_replace('/,/', ' ', $value->email) . ',' : ',';
				$output .= !empty($value->phone) ? preg_replace('/,/', ' ', $value->phone) . ',' : ',';
				$output .= !empty($value->remarks) ? preg_replace('/,/', ' ', $value->remarks) . ',' : ',';



				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'Wastecontainer') {
			$export_name = 'Wastecontainer.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';

				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->volume) ? preg_replace('/,/', ' ', $value->volume) . ',' : ',';
				$output .= !empty($value->price) ? preg_replace('/,/', ' ', $value->price) . ',' : ',';
				$output .= !empty($value->description) ? preg_replace('/,/', ' ', $value->description) . ',' : ',';



				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'Vehicle') {
			$export_name = 'vehicle.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->vehicle_char_id) ? preg_replace('/,/', ' ', $value->vehicle_char_id) . ',' : ',';

				$output .= !empty($value->number) ? preg_replace('/,/', ' ', $value->number) . ',' : ',';
				$output .= !empty($value->fuel_type) ? preg_replace('/,/', ' ', $value->fuel_type) . ',' : ',';
				$output .= !empty($value->manufacturername) ? preg_replace('/,/', ' ', $value->manufacturername) . ',' : ',';
				$output .= !empty($value->ownername) ? preg_replace('/,/', ' ', $value->ownername) . ',' : ',';
				$output .= !empty($value->drivername) ? preg_replace('/,/', ' ', $value->drivername) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->gps_device_imei_number) ? preg_replace('/,/', ' ', $value->gps_device_imei_number) . ',' : ',';
				if ($value->onBoard == 1) {
					$output .= "Active,";
				} else {
					$output .= "In Active,";
				}



				$output .= "\n";
				$i++;
			}
		}


		if ($file_name == 'Plant') {
			$export_name = 'plant.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->name) ? preg_replace('/,/', ' ', $value->name) . ',' : ',';
				$output .= !empty($value->plant_certificate_number) ? preg_replace('/,/', ' ', $value->plant_certificate_number) . ',' : ',';
				$output .= !empty($value->email) ? preg_replace('/,/', ' ', $value->email) . ',' : ',';
				$output .= !empty($value->telephone) ? preg_replace('/,/', ' ', $value->telephone) . ',' : ',';
				$output .= !empty($value->landline) ? preg_replace('/,/', ' ', $value->landline) . ',' : ',';
				$output .= !empty($value->contact_person) ? preg_replace('/,/', ' ', $value->contact_person) . ',' : ',';
				$output .= !empty($value->description) ? preg_replace('/,/', ' ', $value->description) . ',' : ',';

				$output .= "\n";
				$i++;
			}
		}



		if ($file_name == 'pharma_client_report') {
			$export_name = 'pharma_client.csv';
			foreach ($tbody_array as $body_key => $value) {

				$status = '';
				if ($value->enabled == 0) {
					$status = 'inactive';
				} else {
					$status = 'active';
				}

				$output .= $body_key + 1 . ',';
				$output .= !empty($value->char_id) ? preg_replace('/,/', ' ', $value->char_id) . ',' : ',';
				$output .= !empty($value->business_name) ? preg_replace('/,/', ' ', $value->business_name) . ',' : ',';
				$output .= !empty($value->file_number) ? preg_replace('/,/', ' ', $value->file_number) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->phone_number) ? preg_replace('/,/', ' ', $value->phone_number) . ',' : ',';
				$output .= !empty($value->landline) ? preg_replace('/,/', ' ', $value->landline) . ',' : ',';
				$output .= !empty($status) ? preg_replace('/,/', ' ', $status) . ',' : ',';

				$output .= !empty($value->agreement_start_date) ? preg_replace('/,/', ' ', date('d-m-y', strtotime($value->agreement_start_date))) . ',' : ',';
				$output .= !empty($value->agreement_end_date) ? preg_replace('/,/', ' ', date('d-m-Y', strtotime($value->agreement_end_date))) . ',' : ',';
				$output .= !empty($value->service_start_date) ? preg_replace('/,/', ' ', date('d-m-y', strtotime($value->service_start_date))) . ',' : ',';
				$output .= !empty($value->created_at) ? preg_replace('/,/', ' ', date('d-m-y', strtotime($value->created_at))) . ',' : ',';
				$output .= !empty($value->emp1_full_name) ? preg_replace('/,/', ' ', $value->emp1_full_name) . ',' : ',';
				$output .= !empty($value->updated_at) ? preg_replace('/,/', ' ', date('d-m-y', strtotime($value->updated_at))) . ',' : ',';
				$output .= !empty($value->emp2_full_name) ? preg_replace('/,/', ' ', $value->emp2_full_name) . ',' : ',';

				$output .= "\n";
				$i++;
			}
		}

		// 

		if ($file_name == 'hcfcollection') {


			$export_name = 'hcfcollection.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->date) ? date('d-m-Y  ', strtotime($body_value->date)) . ',' : ',';
				$output .= !empty($body_value->total_collection_1) ? preg_replace('/,/', ' ', $body_value->total_collection_1) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}




		// OnlinePayment_index
		if ($file_name == 'OnlinePayment_index') {


			$export_name = 'OnlinePayment_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bulk_payment_id) ? preg_replace('/,/', ' ', $body_value->bulk_payment_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->bank_name) ? preg_replace('/,/', ' ', $body_value->bank_data) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('d-m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// Payment_index

		if ($file_name == 'Payment_index') {

			$export_name = 'Payment_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bulk_payment_id) ? preg_replace('/,/', ' ', $body_value->bulk_payment_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->bank_name) ? preg_replace('/,/', ' ', $body_value->bank_name) . ',' : ',';
				$output .= !empty($body_value->cheque_no) ? preg_replace('/,/', ' ', $body_value->cheque_no) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('d-m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// OnlinePharmaPayment_index

		if ($file_name == 'OnlinePharmaPayment_index') {

			$export_name = 'OnlinePharmaPayment_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bulk_payment_id) ? preg_replace('/,/', ' ', $body_value->bulk_payment_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->bank_data) ? preg_replace('/,/', ' ', $body_value->bank_data) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('d-m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// PharmaPayment_index

		if ($file_name == 'PharmaPayment_index') {

			$export_name = 'PharmaPayment_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bulk_payment_id) ? preg_replace('/,/', ' ', $body_value->bulk_payment_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->bank_data) ? preg_replace('/,/', ' ', $body_value->bank_data) . ',' : ',';
				$output .= !empty($body_value->cheque_no) ? preg_replace('/,/', ' ', $body_value->cheque_no) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('d-m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// PaymentLists_index
		if ($file_name == 'PaymentLists') {


			$export_name = 'PaymentLists.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->cheque_no) ? preg_replace('/,/', ' ', $body_value->cheque_no) . ',' : ',';
				$output .= !empty($body_value->transaction_no) ? preg_replace('/,/', ' ', $body_value->transaction_no) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('d-m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// BillingOccupancy_index
		if ($file_name == 'BillingOccupancy_index') {


			$export_name = 'BillingOccupancy_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->bulk_id) ? preg_replace('/,/', ' ', $body_value->bulk_id) . ',' : ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->month_year) ? date('m-Y  ', strtotime($body_value->month_year)) . ',' : ',';

				$output .= !empty($body_value->total_beds) ? preg_replace('/,/', ' ', $body_value->total_beds) . ',' : '0,';
				$output .= !empty($body_value->occupancy) ? preg_replace('/,/', ' ', $body_value->occupancy) . ',' : '0,';
				$output .= !empty($body_value->supply_charge) ? preg_replace('/,/', ' ', $body_value->supply_charge) . ',' : '0,';
				$output .= !empty($body_value->service_charge) ? preg_replace('/,/', ' ', $body_value->service_charge) . ',' : '0,';
				$output .= "\n";
				$i++;
			}
		}

		// ChequeReceipt

		if ($file_name == 'ChequeReceipt') {


			$export_name = 'ChequeReceipt.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bank_name) ? preg_replace('/,/', ' ', $body_value->bank_name) . ',' : ',';
				$output .= !empty($body_value->cheque_no) ? preg_replace('/,/', ' ', $body_value->cheque_no) . ',' : ',';
				$output .= !empty($body_value->clearing_date) ? date('m-Y  ', strtotime($body_value->clearing_date)) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// BillDetail_index
		if ($file_name == 'BillDetail_index') {


			$export_name = 'BillDetail_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y  ', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->month) ? preg_replace('/,/', ' ', $body_value->month) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', round($body_value->amount)) . ',' : '0,';
				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', round($body_value->paid_amount)) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', ($body_value->pending_amount)) . ',' : '0,';
				$output .= !empty($body_value->created_at) ? date('d-m-Y H:i:s', strtotime($body_value->created_at)) . ',' : ',';
				$output .= !empty($body_value->emp1_full_name) ? preg_replace('/,/', ' ', $body_value->emp1_full_name) . ',' : ',';
				$output .= !empty($body_value->updated_at) ? date('d-m-Y H:i:s', strtotime($body_value->updated_at)) . ',' : ',';
				$output .= !empty($body_value->emp2_full_name) ? preg_replace('/,/', ' ', $body_value->emp2_full_name) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'credit') {


			$export_name = 'CreditNote.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y  ', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->month) ? preg_replace('/,/', ' ', $body_value->month) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', round($body_value->amount)) . ',' : '0,';
				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', round($body_value->paid_amount)) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', ($body_value->pending_amount)) . ',' : '0,';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'debit_note') {


			$export_name = 'DebitNote.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y  ', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->month) ? preg_replace('/,/', ' ', $body_value->month) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', round($body_value->amount)) . ',' : '0,';
				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', round($body_value->paid_amount)) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', ($body_value->pending_amount)) . ',' : '0,';
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'Debitnote') {


			$export_name = 'Debitnote.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y  ', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->month) ? preg_replace('/,/', ' ', $body_value->month) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', round($body_value->amount)) . ',' : '0,';
				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', round($body_value->paid_amount)) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', ($body_value->pending_amount)) . ',' : '0,';
				$output .= "\n";
				$i++;
			}
		}


		// ClientType_table

		if ($file_name == 'ClientType_table') {


			$export_name = 'ClientType_table.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->client_Type) ? preg_replace('/,/', ' ', $body_value->client_Type) . ',' : ',';
				$output .= !empty($body_value->description) ? preg_replace('/,/', ' ', $body_value->description) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}

		// ClientGroup_data

		if ($file_name == 'ClientGroup_data') {


			$export_name = 'ClientGroup_data.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->group_Name) ? preg_replace('/,/', ' ', $body_value->group_Name) . ',' : ',';
				$output .= !empty($body_value->email) ? preg_replace('/,/', ' ', $body_value->email) . ',' : ',';
				$output .= !empty($body_value->telephone) ? preg_replace('/,/', ' ', $body_value->telephone) . ',' : ',';
				$output .= !empty($body_value->description) ? preg_replace('/,/', ' ', $body_value->description) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'employee') {


			$export_name = 'Employee.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->f_name) ? preg_replace('/,/', ' ', $body_value->f_name . ' ' . $body_value->l_name) . ',' : ',';
				$output .= !empty($body_value->father_name) ? preg_replace('/,/', ' ', $body_value->father_name) . ',' : ',';
				$output .= !empty($body_value->contact_no) ? preg_replace('/,/', ' ', $body_value->contact_no) . ',' : ',';
				$output .= !empty($body_value->e_mail) ? preg_replace('/,/', ' ', $body_value->e_mail) . ',' : ',';
				$output .= !empty($body_value->department_name) ? preg_replace('/,/', ' ', $body_value->department_name) . ',' : ',';
				$output .= !empty($body_value->designation_name) ? preg_replace('/,/', ' ', $body_value->designation_name) . ',' : ',';
				$output .= !empty($body_value->aadhar_no) ? preg_replace('/,/', ' ', $body_value->aadhar_no) . ',' : ',';
				$output .= !empty($body_value->pancard_no) ? preg_replace('/,/', ' ', $body_value->pancard_no) . ',' : ',';
				$output .= !empty($body_value->esi_no) ? preg_replace('/,/', ' ', $body_value->esi_no) . ',' : ',';
				$output .= !empty($body_value->pf_no) ? preg_replace('/,/', ' ', $body_value->pf_no) . ',' : ',';
				$output .= !empty($body_value->doj) ? date('d-m-Y', strtotime($body_value->doj)) . ',' : ',';
				$output .= "\n";
			}
		}

		// PharmaBill_index

		if ($file_name == 'PharmaBill_index') {


			$export_name = 'PharmaBill_index.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->bill_no) ? preg_replace('/,/', ' ', $body_value->bill_no) . ',' : ',';
				$output .= !empty($body_value->billing_date) ? date('d-m-Y  ', strtotime($body_value->billing_date)) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->paid_amount) ? preg_replace('/,/', ' ', $body_value->paid_amount) . ',' : '0,';
				$output .= !empty($body_value->pending_amount) ? preg_replace('/,/', ' ', $body_value->pending_amount) . ',' : ',';
				$output .= !empty($body_value->created_at) ? date('d-m-Y H:i:s', strtotime($body_value->created_at)) . ',' : ',';
				$output .= !empty($body_value->emp1_full_name) ? preg_replace('/,/', ' ', $body_value->emp1_full_name) . ',' : ',';
				$output .= !empty($body_value->updated_at) ? date('d-m-Y H:i:s', strtotime($body_value->updated_at)) . ',' : ',';
				$output .= !empty($body_value->emp2_full_name) ? preg_replace('/,/', ' ', $body_value->emp2_full_name) . ',' : ',';
				$output .= "\n";
				$i++;
			}
		}


		// payment Received summary

		if ($file_name == 'Payment_Received') {


			$export_name = 'Payment_Received.csv';
			foreach ($tbody_array as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client_name) ? preg_replace('/,/', ' ', $body_value->client_name) . ',' : ',';
				$output .= !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';
				$output .= !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';
				$output .= !empty($body_value->district_name) ? preg_replace('/,/', ' ', $body_value->district_name) . ',' : ',';
				$output .= !empty($body_value->amount) ? preg_replace('/,/', ' ', $body_value->amount) . ',' : ',';
				$output .= !empty($body_value->payment_type) ? preg_replace('/,/', ' ', $body_value->payment_type) . ',' : ',';

				$output .= !empty($body_value->clearing_date) ? date('d-m-Y H:i:s', strtotime($body_value->clearing_date)) . ',' : ',';

				if ($body_value->client_type == 1) {
					$output .= "Govt" . ',';
				} elseif ($body_value->client_type == 0 && $body_value->client_type != null) {
					$output .= "Pvt" . ',';
				} else {
					$output .= ',';
				}

				if ($body_value->occupancy_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'bill_mailed_report') {
			$export_name = 'bill mailed report.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->client_name) ? preg_replace('/,/', ' ', $value->client_name) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->bill_no) ? preg_replace('/,/', ' ', $value->bill_no) . ',' : ',';
				$output .= !empty($value->mail_send_date_time) ? date('d-m-Y H:i:s', strtotime($value->mail_send_date_time)) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'whatsapp_sent_report') {
			$export_name = 'Whatsapp Sent Report.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->client_name) ? preg_replace('/,/', ' ', $value->client_name) . ',' : ',';
				$output .= !empty($value->client_contact) ? preg_replace('/,/', ' ', $value->client_contact) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->bill_no) ? preg_replace('/,/', ' ', $value->bill_no) . ',' : ',';
				$output .= !empty($value->whatsapp_send_date_time) ? date('d-m-Y H:i:s', strtotime($value->whatsapp_send_date_time)) . ',' : ',';
				$output .= !empty($value->whatspp_response) ? preg_replace('/,/', ' ', $value->whatspp_response) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'whatsapp_sent_client_report') {
			$export_name = 'Whatsapp Sent Report.csv';
			foreach ($tbody_array as $body_key => $value) {


				$output .= $body_key + 1 . ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->business_name) ? preg_replace('/,/', ' ', $value->business_name) . ',' : ',';
				$output .= !empty($value->file_no) ? preg_replace('/,/', ' ', $value->file_no) . ',' : ',';
				$output .= !empty($value->state_name) ? preg_replace('/,/', ' ', $value->state_name) . ',' : ',';
				$output .= !empty($value->district_name) ? preg_replace('/,/', ' ', $value->district_name) . ',' : ',';
				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->person_contact) ? preg_replace('/,/', ' ', $value->person_contact) . ',' : ',';
				if ($value->is_govt_client == 1) {
					$output .= 'Govt,';
				} else {
					$output .= 'Pvt,';
				}
				if ($value->occupancy_applicable == 1) {
					$output .= 'Yes,';
				} else {
					$output .= 'No,';
				}
				if ($value->status == 1) {
					$output .= 'Active,';
				} else {
					$output .= 'Inactive,';
				}
				$output .= !empty($value->whatsapp_send_date_time) ? date('d-m-Y H:i:s', strtotime($value->whatsapp_send_date_time)) . ',' : ',';


				$output .= "\n";
				$i++;
			}
		}
		if ($file_name == 'early_bill_client_changes') {
			$export_name = 'Early Bill Client Changes Report.csv';
			// dd($tbody_array);
			foreach ($tbody_array as $body_key => $value) {



				$output .= !empty($value->plant_name) ? preg_replace('/,/', ' ', $value->plant_name) . ',' : ',';
				$output .= !empty($value->client_char_id) ? preg_replace('/,/', ' ', $value->client_char_id) . ',' : ',';
				$output .= !empty($value->client_name) ? preg_replace('/,/', ' ', $value->client_name) . ',' : ',';
				$output .= !empty($value->route_name) ? preg_replace('/,/', ' ', $value->route_name) . ',' : ',';
				$output .= !empty($value->executive_name) ? preg_replace('/,/', ' ', $value->executive_name) . ',' : ',';
				$output .= !empty($value->client_address) ? preg_replace('/,/', ' ', $value->client_address) . ',' : ',';
				$output .= !empty($value->fixed_amount) ? preg_replace('/,/', ' ', $value->fixed_amount) . ',' : ',';
				$output .= !empty($value->file_no) ? preg_replace('/,/', ' ', $value->file_no) . ',' : ',';
				$output .= !empty($value->balance) ? preg_replace('/,/', ' ', $value->balance) . ',' : ',';
				$output .= !empty($value->security) ? preg_replace('/,/', ' ', $value->security) . ',' : ',';

				$output .= !empty($value->service_start_date) ? date('d-m-Y H:i:s', strtotime($value->service_start_date)) . ',' : ',';
				$output .= !empty($value->billing_date) ? date('d-m-Y H:i:s', strtotime($value->billing_date)) . ',' : ',';
				$output .= !empty($value->month_year) ? preg_replace('/,/', ' ', $value->month_year) . ',' : ',';
				$output .= !empty($value->remarks) ? preg_replace('/,/', ' ', $value->remarks) . ',' : ',';
				if($value->service_type==1)
				$output.='Service Start List,';
				elseif($value->service_type==2)
				$output.='Service Stop List,';
				elseif($value->service_type==3)
				$output.='Temporary Closed List,';
				else
				$output.=',';



				$output .= "\n";
				$i++;
			}
		}


		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $output;
		// dd('1');

	}

	// export three array report 
	public static function export_two_array_report($file_name, $thead_array, $firstarray, $secondarray)
	{
		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';
		foreach ($thead_array as $key => $value) {
			// code...
			$output .= $value . ',';
		}

		$output .= "\n";
		$i = 1;


		if ($file_name == 'routes_report') {
			$routes = $firstarray;
			$out = $secondarray;
			foreach ($routes as $routes_key => $route) {

				$output .= $routes_key + 1 . ',';
				$output .=  !empty($route->char_id) ? preg_replace('/,/', ' ', $route->char_id) . ',' : ',';
				$output .=  !empty($route->name) ? preg_replace('/,/', ' ', $route->name) . ',' : ',';
				$output .=  !empty($out[$route->id]['occupancy_count']) ? preg_replace('/,/', ' ', $out[$route->id]['occupancy_count']) . ',' : '0,';
				$output .=  !empty($out[$route->id]['gvt_count']) ? preg_replace('/,/', ' ', $out[$route->id]['gvt_count']) . ',' : '0,';
				$output .=  !empty($out[$route->id]['pvt_count']) ? preg_replace('/,/', ' ', $out[$route->id]['pvt_count']) . ',' : '0,';
				$output .=  !empty($out[$route->id]['active_count']) ? preg_replace('/,/', ' ', $out[$route->id]['active_count']) . ',' : '0,';
				$output .=  !empty($route->plant_name) ? preg_replace('/,/', ' ', $route->plant_name) . ',' : ',';
				$output .=  !empty($out[$route->id]['executive_name']) ? preg_replace('/,/', ' ', $out[$route->id]['executive_name']) . ',' : ',';
				$output .=  !empty($route->vehicle_number) ? preg_replace('/,/', ' ', $route->vehicle_number) . ',' : ',';
				$output .=  !empty($route->driver) ? preg_replace('/,/', ' ', $route->driver) . ',' : ',';



				$output .= "\n";
			}

			$export_name = 'Routes.csv';
		}

		if ($file_name == 'Payment_Received_Summary') {
			$export_name = 'Payment received summary.csv';

			foreach ($firstarray as $body_key => $body_value) {
				$output .= $body_key + 1 . ',';
				$output .=  !empty($body_value->plant_name) ? preg_replace('/,/', ' ', $body_value->plant_name) . ',' : ',';

				$output .=  !empty($body_value->route_name) ? preg_replace('/,/', ' ', $body_value->route_name) . ',' : ',';


				// dd($secondarray);
				foreach ($secondarray[$body_value->route_id] as $key => $data) {

					$output .=  !empty($data['count']) ? preg_replace('/,/', ' ', $data['count']) . ',' : '0,';
					$output .=  !empty($data['amount']) ? preg_replace('/,/', ' ', $data['amount']) . ',' : '0,';
				}

				$output .= "\n";
			}
		}


		if ($file_name == 'plant_debtorlist_summary') {
			$client_details = $firstarray;
			$out = $secondarray;
			$pvt_active_columns = [];
			$pvt_inactive_columns = [];
			$govt_active_columns = [];
			$govt_inactive_columns = [];
			$occ_active_columns = [];
			$occ_inactive_columns = [];
			$total_active_columns = [];
			$total_inactive_columns = [];
			foreach ($client_details as $dl_key => $client) {


				$pvt_active = !empty($out[$client->client_route_id]['pvt_active']) ? array_sum($out[$client->client_route_id]['pvt_active']) : 0;
				$pvt_inactive = !empty($out[$client->client_route_id]['pvt_inactive']) ? array_sum($out[$client->client_route_id]['pvt_inactive']) : 0;
				$govt_active = !empty($out[$client->client_route_id]['govt_active']) ? array_sum($out[$client->client_route_id]['govt_active']) : 0;
				$govt_inactive = !empty($out[$client->client_route_id]['govt_inactive']) ? array_sum($out[$client->client_route_id]['govt_inactive']) : 0;
				$occ_active = !empty($out[$client->client_route_id]['occ_active']) ? array_sum($out[$client->client_route_id]['occ_active']) : 0;
				$occ_inactive = !empty($out[$client->client_route_id]['occ_inactive']) ? array_sum($out[$client->client_route_id]['occ_inactive']) : 0;
				$row_inactive_total = [$pvt_inactive, $govt_inactive, $occ_inactive];
				$row_active_total = [$pvt_active, $govt_active, $occ_active];
				$total_active = array_sum($row_active_total);
				$total_inactive = array_sum($row_inactive_total);

				$pvt_active_columns[] = $pvt_active;
				$pvt_inactive_columns[] = $pvt_inactive;
				$govt_active_columns[] = $govt_active;
				$govt_inactive_columns[] = $govt_inactive;
				$occ_active_columns[] = $occ_active;
				$occ_inactive_columns[] = $occ_inactive;
				$total_active_columns[] = $total_active;
				$total_inactive_columns[] = $total_inactive;

				$output .= $dl_key + 1 . ',';
				$output .=  !empty($client->plant_name) ? preg_replace('/,/', ' ', $client->plant_name) . ',' : ',';
				$output .=  !empty($client->route_name) ? preg_replace('/,/', ' ', $client->route_name) . ',' : ',';
				$output .=  !empty($pvt_active) ? preg_replace('/,/', ' ', $pvt_active) . ',' : ',';
				$output .=  !empty($pvt_inactive) ? preg_replace('/,/', ' ', $pvt_inactive) . ',' : '0,';
				$output .=  !empty($govt_active) ? preg_replace('/,/', ' ', $govt_active) . ',' : '0,';
				$output .=  !empty($govt_inactive) ? preg_replace('/,/', ' ', $govt_inactive) . ',' : '0,';
				$output .=  !empty($occ_active) ? preg_replace('/,/', ' ', $occ_active) . ',' : '0,';
				$output .=  !empty($occ_inactive) ? preg_replace('/,/', ' ', $occ_inactive) . ',' : '0,';
				$output .=  !empty($total_active) ? preg_replace('/,/', ' ', $total_active) . ',' : '0,';
				$output .=  !empty($total_inactive) ? preg_replace('/,/', ' ', $total_inactive) . ',' : '0,';



				$output .= "\n";
			}

			$export_name = 'plant wise debtolist summary.csv';
		}



		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $output;
		// dd('1');

	}
	// export three array report 
	public static function export_three_array_report($file_name, $thead_array, $firstarray, $secondarray, $thirdarray)
	{


		// dd($secondarray);
		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';
		foreach ($thead_array as $key => $value) {
			// code...
			$output .= $value . ',';
		}

		$output .= "\n";
		$i = 1;


		if ($file_name == 'sales_collection_report') {
			$bagarray = $firstarray;
			$salessummary = $secondarray;
			$handling_salessummary = $thirdarray;
			foreach ($salessummary as $sales_key => $sales_value) {

				$bag_arr = [];
				$kg_arr = [];

				$output .= $sales_key + 1 . ',';
				$output .=  !empty($sales_value->client_char_id) ? preg_replace('/,/', ' ', $sales_value->client_char_id) . ',' : ',';
				$output .=  !empty($sales_value->business_name) ? preg_replace('/,/', ' ', $sales_value->business_name) . ',' : ',';
				$output .=  !empty($sales_value->address1) ? preg_replace('/,/', ' ', $sales_value->address1) . ',' : ',';

				if ($sales_value->billing_type == 1)
					$output .=  preg_replace('/,/', ' ', $sales_value->fixed_amount_total_beds) . ',';
				elseif ($sales_value->billing_type == 2)
					$output .=  preg_replace('/,/', ' ', $sales_value->excess_rate) . ',';
				elseif ($sales_value->billing_type == 3) {
					$output .=  preg_replace('/,/', ' ', $sales_value->per_bed_total_beds) . ',';
				} else {
					$output .= ',';
				}
				if (!empty($bagarray)) {
					foreach ($bagarray as $key => $value) {

						$bag_arr[] = !empty($handling_salessummary[$sales_value->id][$value->id]['bag']) ? $handling_salessummary[$sales_value->id][$value->id]['bag'] . ',' : '0,';
						$kg_arr[] = !empty($handling_salessummary[$sales_value->id][$value->id]['kg']) ? $handling_salessummary[$sales_value->id][$value->id]['kg'] . ',' : '0,';

						$output .=  !empty($handling_salessummary[$sales_value->id][$value->id]['bag']) ?  preg_replace('/,/', ' ', $handling_salessummary[$sales_value->id][$value->id]['bag']) . ',' : '0,';

						$output .=  !empty($handling_salessummary[$sales_value->id][$value->id]['kg']) ? preg_replace('/,/', ' ', $handling_salessummary[$sales_value->id][$value->id]['kg']) . ',' : '0,';
					}
				}
				$output .= preg_replace('/,/', ' ', array_sum($kg_arr)) . ',';
				$output .= preg_replace('/,/', ' ', array_sum($bag_arr)) . ',';


				$output .= "\n";
			}

			$export_name = 'SalesCollectionReport.csv';
		}

		if ($file_name == 'plant_wise_last_three_month_report') {
			$months = $firstarray;
			$data = $secondarray;
			$all_billing_plants = $thirdarray;
			foreach ($all_billing_plants as $plant_key => $plant) {

				$output .= !empty($plant->plant_id) ? preg_replace('/,/', ' ', $plant->plant_id) . ',' : " ,";
				$output .= !empty($plant->plant_name) ? preg_replace('/,/', ' ', $plant->plant_name) . ',' : " ,";

				foreach ($months as $mon) {

					$output .= !empty($data[$plant->plant_id][$mon]) ? preg_replace('/,/', ' ', $data[$plant->plant_id][$mon]) . ',' : "0,";
				}
				$output .= "\n";
			}

			$export_name = 'Last_three_month_billing_summary_plant_wise.csv';
		}
		if ($file_name == 'route_wise_last_three_month_report') {
			$months = $firstarray;
			$data = $secondarray;
			$all_billing_routes = $thirdarray;
			foreach ($all_billing_routes as $plant_key => $route) {

				$output .= !empty($route->route_id) ? preg_replace('/,/', ' ', $route->route_id) . ',' : " ,";
				$output .= !empty($route->route_name) ? preg_replace('/,/', ' ', $route->route_name) . ',' : " ,";

				foreach ($months as $mon) {

					$output .= !empty($data[$route->route_id][$mon]) ? preg_replace('/,/', ' ', $data[$route->route_id][$mon]) . ',' : "0,";
				}
				$output .= "\n";
			}

			$export_name = 'Last_three_month_billing_summary_route_wise.csv';
		}
		if ($file_name == 'state_wise_last_three_month_report') {
			$months = $firstarray;
			$data = $secondarray;
			$all_billing_states = $thirdarray;
			foreach ($all_billing_states as $plant_key => $state) {

				$output .= $plant_key + 1 . " ,";
				$output .= !empty($state->state_name) ? preg_replace('/,/', ' ', $state->state_name) . ',' : " ,";

				foreach ($months as $mon) {

					$output .= !empty($data[$state->state_id][$mon]) ? preg_replace('/,/', ' ', $data[$state->state_id][$mon]) . ',' : "0,";
				}
				$output .= "\n";
			}

			$export_name = 'Last_three_month_billing_summary_state_wise.csv';
		}
		if ($file_name == 'plant_wise_debtor_list') {
			$clients = $firstarray;
			$out = $secondarray;
			$out_sec = $thirdarray;
			foreach ($clients as $key => $client) {
				$balance = !empty($out[$client->client_char_id]) ? ($out[$client->client_char_id] > 0 ? $out[$client->client_char_id] : 0) : 0;
				$security = !empty($out_sec[$client->client_char_id]) ? ($out_sec[$client->client_char_id] > 0 ? $out_sec[$client->client_char_id] : 0) : 0;
				$output .= $key + 1 . " ,";
				$output .= !empty($client->client_char_id) ? preg_replace('/,/', ' ', $client->client_char_id) . ',' : " ,";
				$output .= !empty($client->business_name) ? preg_replace('/,/', ' ', $client->business_name) . ',' : " ,";
				$output .= !empty($client->file_no) ? preg_replace('/,/', ' ', $client->file_no) . ',' : " ,";
				$output .= !empty($client->route_name) ? preg_replace('/,/', ' ', $client->route_name) . ',' : " ,";
				$output .= !empty($client->plant_name) ? preg_replace('/,/', ' ', $client->plant_name) . ',' : " ,";
				if ($client->billing_type == 1) {
					$output .= $client->minimum_amount . ',';
				} elseif ($client->billing_type == 2) {
					$output .= $client->per_bed_amount . ',';
				} elseif ($client->billing_type == 3) {
					$output .= $client->per_kg_amount . ',';
				} else {
					$output .= '0,';
				}
				$output .= $balance . ',';
				$output .= $security . ',';
				if ($client->status == 1) {
					$output .= "Active,";
				} else {
					$output .= "InActive,";
				}
				if ($client->is_govt_client == 1) {
					$output .= "Govt,";
				} else {
					$output .= "Pvt,";
				}
				if ($client->occupancy_applicable == 1) {
					$output .= "Yes,";
				} else {
					$output .= "No,";
				}
				$output .= "\n";
			}

			$export_name = 'Plant Wise Debtorlist.csv';
		}

	
		if ($file_name == 'collection_summary_report') {

			$export_name = "Collection Summary Report.csv";

			$final_unique_routes = $firstarray;
			$out = $secondarray;
			$plant_details = $thirdarray;

			foreach ($final_unique_routes as $body_key => $route) {

				$yellow_kg = !empty($out[$route->route_id]['yellowkg']) ? array_sum($out[$route->route_id]['yellowkg']) : 0;
				$red_kg = !empty($out[$route->route_id]['redkg']) ? array_sum($out[$route->route_id]['redkg']) : 0;
				$blue_kg = !empty($out[$route->route_id]['bluekg']) ? array_sum($out[$route->route_id]['bluekg']) : 0;
				$white_kg = !empty($out[$route->route_id]['whitekg']) ? array_sum($out[$route->route_id]['whitekg']) : 0;
				$white_bag = !empty($out[$route->route_id]['whitebag']) ? array_sum($out[$route->route_id]['whitebag']) : 0;
				$blue_bag = !empty($out[$route->route_id]['bluebag']) ? array_sum($out[$route->route_id]['bluebag']) : 0;
				$red_bag = !empty($out[$route->route_id]['redbag']) ? array_sum($out[$route->route_id]['redbag']) : 0;
				$yellow_bag = !empty($out[$route->route_id]['yellowbag']) ? array_sum($out[$route->route_id]['yellowbag']) : 0;
				$total_bag = !empty($out[$route->route_id]['totalbag']) ? array_sum($out[$route->route_id]['totalbag']) : 0;
				$total_kg = !empty($out[$route->route_id]['totalkg']) ? array_sum($out[$route->route_id]['totalkg']) : 0;

				$output .= !empty($plant_details->name) ? preg_replace('/,/', ' ', $plant_details->name) . ',' : " ,";
				$output .= !empty($route->route_name) ? preg_replace('/,/', ' ', $route->route_name) . ',' : " ,";
				$output .= !empty($yellow_kg) ? round(preg_replace('/,/', ' ', $yellow_kg), 2) . ',' : " 0,";
				$output .= !empty($yellow_bag) ? preg_replace('/,/', ' ', $yellow_bag) . ',' : " 0,";
				$output .= !empty($red_kg) ? round(preg_replace('/,/', ' ', $red_kg), 2) . ',' : " 0,";
				$output .= !empty($red_bag) ? preg_replace('/,/', ' ', $red_bag) . ',' : " 0,";
				$output .= !empty($blue_kg) ? round(preg_replace('/,/', ' ', $blue_kg), 2) . ',' : " 0,";
				$output .= !empty($blue_bag) ? preg_replace('/,/', ' ', $blue_bag) . ',' : " 0,";
				$output .= !empty($white_kg) ? round(preg_replace('/,/', ' ', $white_kg), 2) . ',' : " 0,";
				$output .= !empty($white_bag) ? preg_replace('/,/', ' ', $white_bag) . ',' : " 0,";
				$output .= !empty($total_kg) ? round(preg_replace('/,/', ' ', $total_kg), 2) . ',' : " 0,";
				$output .= !empty($total_bag) ? preg_replace('/,/', ' ', $total_bag) . ',' : " 0,";

				$output .= "\n";
			}
		}

		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $output;
		// dd('1');

	}

	// export four array report 
	public static function export_four_array_report($file_name, $thead_array, $firstarray, $secondarray, $thirdarray, $fourarray)
	{
		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';
		foreach ($thead_array as $key => $value) {
			// code...

			$output .= $value . ',';
		}

		$output .= "\n";
		$i = 1;

		if ($file_name == 'expense_report') {
			$plantname = $firstarray;
			$data_get = $secondarray;
			$out_set = $thirdarray;
			$ledgerData = $fourarray;
			$plant_total = [];
			$plant_total_blank = [];
			$grand_total = [];
			foreach ($ledgerData as $datakey => $datavalue) {
				$ledger_id = $datavalue->ledger_id;
				$sum_t = [];
				$sum_t_blank = [];
				$output .= $datakey + 1 . ',';
				$output .= !empty($datavalue->name) ? preg_replace('/,/', ' ', $datavalue->name) . ',' : ',';
				$output .= !empty($datavalue->groupname) ? preg_replace('/,/', ' ', $datavalue->groupname) . ',' : ',';

				if (!empty($plantname)) {
					foreach ($plantname as $key => $value) {
						$plant_total[$value->id][] =  !empty($out_set[$datavalue->ledger_id][$value->char_id]) ? preg_replace('/,/', '', $out_set[$datavalue->ledger_id][$value->char_id]) : '0';
						$plant_char_id = $value->char_id;
						$output .= !empty($out_set[$datavalue->ledger_id][$value->char_id]) ? $sum_t[] = preg_replace('/,/', ' ', $out_set[$datavalue->ledger_id][$value->char_id]) . ',' : '0,';
					}

					$plant_total_blank[] =  !empty($out_set[$datavalue->ledger_id][""]) ? $out_set[$datavalue->ledger_id][""] : '0';


					$output .= !empty($out_set[$datavalue->ledger_id][""]) ? $sum_t_blank[] = preg_replace('/,/', '', $out_set[$datavalue->ledger_id][""]) . ',' : '0,';
				}

				$grand_total[] =  array_sum($sum_t) + array_sum($sum_t_blank);

				$output .= array_sum($sum_t) + array_sum($sum_t_blank) . ',';
				$output .= "\n";
			}
			$output .= ' ,';
			$output .= ' ,';
			$output .= 'Grand Total ,';
			if (!empty($plantname)) {
				foreach ($plantname as $key => $value) {

					$output .= array_sum($plant_total[$value->id]) . ' ,';
				}
				$output .= array_sum($plant_total_blank) . ' ,';
			} else {

				$output .= '0 ,';
			}
			$output .= array_sum($grand_total) . ',';

			$export_name = 'ExpenseReport.csv';
		}




		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $output;
		// dd('1');

	}

	// export five array report

	public static function export_five_array_report($file_name, $thead_array, $firstarray, $secondarray, $thirdarray, $fourarray, $fivearray)
	{
		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';
		foreach ($thead_array as $key => $value) {
			// code...

			$output .= $value . ',';
		}

		$output .= "\n";
		$i = 1;


		if ($file_name == 'PharmaDebtor') {

			$export_name = "PharmaDebtor.csv";
			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [$one_month, $two_month, $three_month, 'old'];

			$col_total_outstanding = 0;
			foreach ($array_month as $month_key => $mon_value) {
				$col_total_date_wise[$mon_value] = 0;
			}

			$out_date_wise = 0;
			$final_sum_arr_ine = [];


			foreach ($firstarray as $body_key => $body_value) {

				$outstanding = !empty($thirdarray[$body_value->char_id]) ? $thirdarray[$body_value->char_id] : '';
				$outstanding_sec = !empty($fourarray[$body_value->char_id]) ? $fourarray[$body_value->char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = (float) $outstanding;
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = (float) $outstanding * -1;
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = (float) $outstanding_sec;
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = (float) $outstanding_sec * -1;
				}

				if ($secondarray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($thirdarray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}
				$col_total_outstanding += $outstanding_val;

				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
				$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
				$output .= !empty($body_value->district->district) ? preg_replace('/,/', ' ', $body_value->district->district) . ',' : ',';
				$output .= !empty($body_value->file_number) ? preg_replace('/,/', ' ', $body_value->file_number) . ',' : ',';
				$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
				$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
				foreach ($array_month as $m_key => $m_value) {
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = (float) $outstanding - $out_date_wise;
						$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$col_total_date_wise[$m_value] += $out_date_wise;

					$output .= !empty($out_date_wise) ? preg_replace('/,/', ' ', $out_date_wise) . ',' : '0,';
				}
				$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
				if ($fivearray == 'No' || $fivearray == 'NO') {
				} else {
					$output .= !empty($body_value->contact_person_name) ? preg_replace('/,/', ' ', $body_value->contact_person_name) . ',' : ',';
					$output .= !empty($body_value->contact_person_phone_number) ? preg_replace('/,/', ' ', $body_value->contact_person_phone_number) . ',' : ',';
				}

				$output .= "\n";
				$i++;
			}
		}

		if ($file_name == 'RouteWithoutContact') {

			$export_name = "RouteWithoutContact.csv";
			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}

			$col_pvt_total_outstanding = 0;
			$col_govt_total_outstanding = 0;
			$col_occ_total_outstanding = 0;
			foreach ($array_month as $month_key => $mon_value) {
				$col_pvt_total_date_wise[$mon_value] = 0;
				$col_govt_total_date_wise[$mon_value] = 0;
				$col_occ_total_date_wise[$mon_value] = 0;
			}
			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($secondarray[$body_value->client->client_char_id]) ? $secondarray[$body_value->client->client_char_id] : '';
				$outstanding_sec = !empty($thead_array[$body_value->client->client_char_id]) ? $thead_array[$body_value->client->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = (float) $outstanding;
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = (float) $outstanding * -1;
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = (float) $outstanding_sec;
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = (float) $outstanding_sec * -1;
				}

				if ($fourarray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fourarray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}
				$col_pvt_total_outstanding += $outstanding_val;

				$output .= $body_key + 1 . ',';
				$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
				$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
				$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
				$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
				$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';
				$out_date_wise = 0;
				$final_sum_arr_ine = [];

			  
				foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
				
			}
				$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
				$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
				$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

				if ($body_value->client->is_govt_client == 1) {

					$output .= "Govt" . ',';
				} elseif ($body_value->client->is_govt_client == 0 &&  $body_value->client->is_govt_client != null) {
					$output .= "Pvt" . ',';
				} else {
					$output .= "-" . ',';
				}
				if ($body_value->client->occupancy_applicable == 1) {
					$output .= "Yes" . ',';
				} else {
					$output .= "No" . ',';
				}
				if ($body_value->client->status == 1) {
					$output .= "Active" . ',';
				} else {
					$output .= "Inactive" . ',';
				}

				$output .= "\n";
			}
			$export_name = 'RouteWithoutContact.csv';
		}

		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $output;
	}

	// export sixth array report

	public static function export_six_array_report($file_name, $thead_array, $firstarray, $secondarray, $thirdarray, $fourarray, $fivearray, $sixarray)
	{
		$company_id = Auth::user()->company_id;
		$export_name = 'ExportExcel.csv';
		$output = '';
		foreach ($thead_array as $key => $value) {
			$output .= $value . ',';
		}
		$output .= "\n";
		$i = 1;



		if ($file_name == 'DistrictDebtorList') {
			$export_name = "DistrictDebtorList.csv";

			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}


			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($thirdarray[$body_value->client_char_id]) ? $thirdarray[$body_value->client_char_id] : '';
				$outstanding_sec = !empty($fourarray[$body_value->client_char_id]) ? $fourarray[$body_value->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}

				if ($fivearray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fivearray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}


				if ($fivearray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

								  
				foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fivearray == 'CR' && $outstanding != '0 DR') {


					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {
					if ($skip == "true" && empty($fivearray)) {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				}
			}
		}

		if ($file_name == 'district_debtor_list_without_contact') {
			$export_name = "Without Contact District Debtor List.csv";
			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}


			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($thirdarray[$body_value->client_char_id]) ? $thirdarray[$body_value->client_char_id] : '';
				$outstanding_sec = !empty($fourarray[$body_value->client_char_id]) ? $fourarray[$body_value->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}

				if ($fivearray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fivearray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}


				if ($fivearray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fivearray == 'CR' && $outstanding != '0 DR') {


					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {
					if ($skip == "true" && empty($fivearray)) {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				}
			}
		}
		if ($file_name == 'discontinue_debtor_list') {
			$export_name = "Discontinued Debtor List.csv";

			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}


			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($thirdarray[$body_value->client_char_id]) ? $thirdarray[$body_value->client_char_id] : '';
				$outstanding_sec = !empty($fourarray[$body_value->client_char_id]) ? $fourarray[$body_value->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}

				if ($fivearray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fivearray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}


				if ($fivearray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fivearray == 'CR' && $outstanding != '0 DR') {


					if ($skip == "true") {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {
					if ($skip == "true" && empty($fivearray)) {

						$output .=  !empty($body_value->client_char_id) ? preg_replace('/,/', ' ', $body_value->client_char_id) . ',' : ',';
						$output .=  !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .=  !empty($secondarray[$body_value->district1]) ? preg_replace('/,/', ' ', $secondarray[$body_value->district1]) . ',' : ',';
						$output .=  !empty($body_value->file_no) ? preg_replace('/,/', ' ', $body_value->file_no) . ',' : ',';
						$output .=  !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .=  !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : ',';

						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->name_of_person) ? preg_replace('/,/', ' ', $body_value->name_of_person) . ',' : ',';
							$output .= !empty($body_value->person_contact) ? preg_replace('/,/', ' ', $body_value->person_contact) . ',' : ',';
						}

						if ($body_value->is_govt_client == 1) {
							$output .=  "Govt" . ',';
						} else {
							$output .=  "Pvt" . ',';
						}

						if ($body_value->status == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				}
			}
		}
		if ($file_name == 'pharma_debtor_list') {
			$export_name = "Pharma Debtor List.csv";



			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::pharmaclientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}






			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($thirdarray[$body_value->char_id]) ? $thirdarray[$body_value->char_id] : '';
				$outstanding_sec = !empty($fourarray[$body_value->char_id]) ? $fourarray[$body_value->char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}

				if ($fivearray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fivearray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}


				if ($fivearray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
						$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .= !empty($body_value->district->district) ? preg_replace('/,/', ' ', $body_value->district->district) . ',' : ',';
						$output .= !empty($body_value->file_number) ? preg_replace('/,/', ' ', $body_value->file_number) . ',' : ',';
						$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						
						
						$out_date_wise = 0;
						$final_sum_arr_ine = [];
						$up_outstanding = 0;
			
					foreach ($array_month as $m_key => $m_value)
					
							{
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
							
								$out_date_wise = Client::pharmaclientdebtorlistcal($body_value->char_id, $m_value, $up_outstanding);
							
								if ($out_date_wise == 0) {
									continue;
								}
								if (array_sum($final_sum_arr_ine) >= $outstanding) {
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value . $body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						
						}
					foreach ($array_month as $mp_key => $mp_value)
					{
						$output.= !empty($month_wise_print[$mp_value . $body_value->client_char_id]) ? round($month_wise_print[$mp_value . $body_value->client_char_id]).',' : '0,' ;
					
					}


						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->contact_person_name) ? preg_replace('/,/', ' ', $body_value->contact_person_name) . ',' : ',';
							$output .= !empty($body_value->contact_person_phone_number) ? preg_replace('/,/', ' ', $body_value->contact_person_phone_number) . ',' : ',';
						}


						if ($body_value->enabled == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fivearray == 'CR' && $outstanding != '0 DR') {


					if ($skip == "true") {

						$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
						$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .= !empty($body_value->district->district) ? preg_replace('/,/', ' ', $body_value->district->district) . ',' : ',';
						$output .= !empty($body_value->file_number) ? preg_replace('/,/', ' ', $body_value->file_number) . ',' : ',';
						$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						
						$out_date_wise = 0;
						$final_sum_arr_ine = [];
						$up_outstanding = 0;
			
					foreach ($array_month as $m_key => $m_value)
					
							{
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
							
								$out_date_wise = Client::pharmaclientdebtorlistcal($body_value->char_id, $m_value, $up_outstanding);
							
								if ($out_date_wise == 0) {
									continue;
								}
								if (array_sum($final_sum_arr_ine) >= $outstanding) {
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value . $body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						
						}
					foreach ($array_month as $mp_key => $mp_value)
					{
						$output.= !empty($month_wise_print[$mp_value . $body_value->client_char_id]) ? round($month_wise_print[$mp_value . $body_value->client_char_id]).',' : '0,' ;
					
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->contact_person_name) ? preg_replace('/,/', ' ', $body_value->contact_person_name) . ',' : ',';
							$output .= !empty($body_value->contact_person_phone_number) ? preg_replace('/,/', ' ', $body_value->contact_person_phone_number) . ',' : ',';
						}


						if ($body_value->enabled == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {
					if ($skip == "true" && empty($fivearray)) {

						$output .= !empty($body_value->char_id) ? preg_replace('/,/', ' ', $body_value->char_id) . ',' : ',';
						$output .= !empty($body_value->business_name) ? preg_replace('/,/', ' ', $body_value->business_name) . ',' : ',';
						$output .= !empty($body_value->district->district) ? preg_replace('/,/', ' ', $body_value->district->district) . ',' : ',';
						$output .= !empty($body_value->file_number) ? preg_replace('/,/', ' ', $body_value->file_number) . ',' : ',';
						$output .= !empty($body_value->minimum_amount) ? preg_replace('/,/', ' ', $body_value->minimum_amount) . ',' : ',';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						
						$out_date_wise = 0;
						$final_sum_arr_ine = [];
						$up_outstanding = 0;
			
					foreach ($array_month as $m_key => $m_value)
					
							{
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
							
								$out_date_wise = Client::pharmaclientdebtorlistcal($body_value->char_id, $m_value, $up_outstanding);
							
								if ($out_date_wise == 0) {
									continue;
								}
								if (array_sum($final_sum_arr_ine) >= $outstanding) {
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value . $body_value->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						
						}
					foreach ($array_month as $mp_key => $mp_value)
					{
						$output.= !empty($month_wise_print[$mp_value . $body_value->client_char_id]) ? round($month_wise_print[$mp_value . $body_value->client_char_id]).',' : '0,' ;
					
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->contact_person_name) ? preg_replace('/,/', ' ', $body_value->contact_person_name) . ',' : ',';
							$output .= !empty($body_value->contact_person_phone_number) ? preg_replace('/,/', ' ', $body_value->contact_person_phone_number) . ',' : ',';
						}


						if ($body_value->enabled == 1) {
							$output .=  "Active" . ',';
						} else {
							$output .=  "InActive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				}
			}
		}

		if ($file_name == 'RouteDebtorList') {
			$export_name = 'Route Debtor List.csv';

			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}


			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($secondarray[$body_value->client->client_char_id]) ? $secondarray[$body_value->client->client_char_id] : '';
				$outstanding_sec = !empty($thirdarray[$body_value->client->client_char_id]) ? $thirdarray[$body_value->client->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}
				// dd($fourarray);
				if ($fourarray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fourarray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}
				// dd($fourarray , $outstanding);

				if ($fourarray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';

						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}
						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fourarray == 'CR' && $outstanding != '0 DR') {

					if ($skip == 'true') {


						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';

						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}
						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {


					if ($skip == 'true' && empty($fourarray)) {


						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}

						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}
						$output .= "\n";
						$i++;
					}
				}
			}
		}
		if ($file_name == 'route_debtorlist_without_contact') {
			$export_name = 'Without Contact Route Debtor List.csv';

			$curr_date = date('Y-m-d');
			$three_month = date('Y-m', strtotime('-2 months'));
			$forth_month = date('Y-m', strtotime('-3 months'));
			$two_month = date('Y-m', strtotime('-1 months'));
			$one_month = date('Y-m');
			$array_month = [];
			$array_month_set = [$one_month, $two_month, $three_month, $forth_month, 'old'];

			foreach ($array_month_set as $key_month => $value_month) {
				$check_entry = Client::clientdebtorlistmonthcal($value_month);
				if ($check_entry) {
					$array_month[] = $value_month;
				}
			}


			foreach ($firstarray as $body_key => $body_value) {
				$outstanding = !empty($secondarray[$body_value->client->client_char_id]) ? $secondarray[$body_value->client->client_char_id] : '';
				$outstanding_sec = !empty($thirdarray[$body_value->client->client_char_id]) ? $thirdarray[$body_value->client->client_char_id] : '';
				$outstanding_val = 0;
				$outstanding_sec_val = 0;
				if (stripos($outstanding, 'dr')) {
					$outstanding_val = round((float) $outstanding);
				} elseif (stripos($outstanding, 'cr')) {
					$outstanding_val = round((float) $outstanding * -1);
				}
				if (stripos($outstanding_sec, 'dr')) {
					$outstanding_sec_val = round((float) $outstanding_sec);
				} elseif (stripos($outstanding_sec, 'cr')) {
					$outstanding_sec_val = round((float) $outstanding_sec * -1);
				}
				// dd($fourarray);
				if ($fourarray == 'CR') {
					$skip = str_contains($outstanding, 'DR');
				} elseif ($fourarray == 'DR') {
					$skip = str_contains($outstanding, 'CR');
				} else {
					$skip = 'true';
				}
				// dd($fourarray , $outstanding);

				if ($fourarray == 'DR' && $outstanding != '0 CR') {

					if ($skip == "true") {

						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';

						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}
						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} elseif ($fourarray == 'CR' && $outstanding != '0 DR') {

					if ($skip == 'true') {


						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];
						foreach ($array_month as $m_key => $m_value)
						{
							
							if (str_contains($outstanding, 'CR')) {
								$out_date_wise = 0;
							} elseif ($m_value == 'old') {
								$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
							} else {
								$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
								
								$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
							   
								if($out_date_wise == 0){
									continue;
								}
								if(array_sum($final_sum_arr_ine) >= $outstanding){
									continue;
								}
							}
							$final_sum_arr_ine[] = $out_date_wise;
							$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
							$final_sum_arr_ine1[] = $up_outstanding;
						}
					foreach ($array_month as $mp_key => $mp_value){
						
						$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
						
					}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';

						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}
						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}

						$output .= "\n";
						$i++;
					}
				} else {


					if ($skip == 'true' && empty($fourarray)) {


						$output .= !empty($body_value->client->business_name) ? preg_replace('/,/', ' ', $body_value->client->business_name) . ',' : ',';
						$output .= !empty($body_value->client->client_char_id) ? preg_replace('/,/', ' ', $body_value->client->client_char_id) . ',' : ',';
						$output .= !empty($body_value->client->file_no) ? preg_replace('/,/', ' ', $body_value->client->file_no) . ',' : '0,';
						$output .= !empty($body_value->client->minimum_amount) ? preg_replace('/,/', ' ', $body_value->client->minimum_amount) . ',' : '0,';
						$output .= !empty($outstanding_sec_val) ? preg_replace('/,/', ' ', $outstanding_sec_val) . ',' : '0,';
						$out_date_wise = 0;
						$final_sum_arr_ine = [];

						foreach ($array_month as $m_key => $m_value)
				{
					
					if (str_contains($outstanding, 'CR')) {
						$out_date_wise = 0;
					} elseif ($m_value == 'old') {
						$out_date_wise = (float) $outstanding - array_sum($final_sum_arr_ine) > 0 ? (float) $outstanding - array_sum($final_sum_arr_ine) : '0';
					} else {
						$up_outstanding = round((float) $outstanding - array_sum($final_sum_arr_ine));
						
						$out_date_wise = Client::clientdebtorlistcal($body_value->client->client_char_id, $m_value, $up_outstanding);
					   
						if($out_date_wise == 0){
							continue;
						}
						if(array_sum($final_sum_arr_ine) >= $outstanding){
							continue;
						}
					}
					$final_sum_arr_ine[] = $out_date_wise;
					$month_wise_print[$m_value.$body_value->client->client_char_id] = $out_date_wise;
					$final_sum_arr_ine1[] = $up_outstanding;
				}
			foreach ($array_month as $mp_key => $mp_value){
				
				$output.= !empty($month_wise_print[$mp_value.$body_value->client->client_char_id]) ? round($month_wise_print[$mp_value.$body_value->client->client_char_id]).',' : '0,' ;
				
			}
						$output .= !empty($outstanding_val) ? preg_replace('/,/', ' ', $outstanding_val) . ',' : '0,';
						if ($sixarray == 'No' || $sixarray == 'NO') {
						} else {
							$output .= !empty($body_value->client->name_of_person) ? preg_replace('/,/', ' ', $body_value->client->name_of_person) . ',' : ',';
							$output .= !empty($body_value->client->person_contact) ? preg_replace('/,/', ' ', $body_value->client->person_contact) . ',' : ',';
						}

						$output .= !empty($fivearray[$body_value->client->district1]) ? preg_replace('/,/', ' ', $fivearray[$body_value->client->district1]) . ',' : ',';
						$output .= !empty($body_value->client->agreement_end_date) ? date('d-m-Y  ', strtotime($body_value->client->agreement_end_date)) . ',' : ',';

						if ($body_value->client->is_govt_client == 1) {

							$output .= "Govt" . ',';
						} else {
							$output .= "Pvt" . ',';
						}

						if ($body_value->client->status == 1) {
							$output .= "Active" . ',';
						} else {
							$output .= "Inactive" . ',';
						}
						$output .= "\n";
						$i++;
					}
				}
			}
		}

		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=" . $export_name);
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $output;
	}
}
