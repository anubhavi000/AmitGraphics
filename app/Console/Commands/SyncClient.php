<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\ClientOriginal;
use Illuminate\Console\Command;


class SyncClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This job will sync clients data from another server everyday in midnight.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [];
        $today = date('Y-m-d');
        $clientOriginals = ClientOriginal::whereDate('created_date', $today)->get();

        foreach ($clientOriginals as $key => $client) {
            array_push($data, [

                'id' => $client->client_id,
                'client_char_id' => $client->client_char_id,
                'business_name' => $client->name,
                'alias_name' => $client->alias_name,
                // 'debit' => $client-> ,
                // 'credit' => $client-> ,
                'address1' => $client->address1,
                'city1' => $client->city,
                'district1' => $client->dist,
                'state1' => $client->state,
                'pincode1' => $client->pincode,
                // 'is_secondary_address' => $client-> ,
                'address2' => $client->secondary_address1,
                'city2' => $client->secondary_city,
                'district2' => $client->secondary_dist,
                'state2' => $client->secondary_state,
                'pincode2' => $client->secondary_pincode,
                'file_no' => $client->file_no,
                'plant' => $client->plant_id,
                'client_group' => $client->client_group_id,
                'client_type' => $client->client_type_id,
                'executive' => $client->executive_name,
                'is_govt_client' => $client->is_govt,
                'show_weights_on_bill' => $client->show_weight,
                'print_alias_name_on_bill' => $client->print_alias_as_billing_name,
                'is_arrears_applied' => $client->is_arrear_applied,
                'secondary_address_on_bill' => $client->print_secondary_as_billing,
                'enabled' => $client->active,
                // 'enabled_no_date' => $client-> ,
                'gst_no' => $client->gstin,
                'vender_code' => $client->vendor_code,
                'phone_no' => $client->phone,
                // 'email_id' => $client-> ,
                'parent_group' => $client->parent_client_id,
                'where_to_send_bill' => $client->bill_send,
                'billing_type' => $client->billing_type,
                // 'billing_cycle' => $client-> ,
                // 'is_supply_applicable' => $client-> ,
                // 'show_occupancy' => $client-> ,
                'fixed_amount_total_beds' => $client->beds,
                'minimum_amount' => $client->minimum_amount,
                'maximum_weight' => $client->max_weight,
                'maximum_weight_gst_applicable' => $client->isgst_applicable,
                'excess_rate' => $client->excess_rate_charges,
                // 'fixed_excess_bill' => $client-> ,
                // 'fixed_excess_bill_gst_applicable' => $client-> ,
                'is_excess_billed' => $client->is_excess_billed,
                'per_bed_total_beds' => $client->beds,
                'per_bed_amount' => $client->per_bed_per_day_amount,
                'per_bed_gst_applicable' => $client->isgst_applicable,
                // 'per_bed_excess_bill' => $client-> ,
                // 'per_bed_excess_bill_gst_applicable' => $client-> ,
                'per_kg_total_beds' => $client->beds,
                'per_kg_amount' => $client->per_kg_amount,
                'per_kg_gst_applicable' => $client->isgst_applicable,
                // 'per_kg_excess_bill' => $client-> ,
                // 'per_kg_excess_bill_gst_applicable' => $client-> ,
                'occupancy_applicable' => $client->occupancy_applicable,
                'supply_charges' => $client->supply_charge,
                // 'is_occupancy_gst_applicable' => $client-> ,
                'is_supply1_applicable' => $client->bihar_vet_client,
                'supply1_charges' => $client->bihar_vet_supply_charge_fixed,
                // 'is_supply1_gst_applicable' => $client-> ,
                'supply1_charge_narration' => $client->bihar_vet_narration,
                'is_supply2_applicable' => $client->bihar_vet_bin_applicable,
                'supply2_charges' => $client->bihar_vet_bin_charge_fixed,
                // 'is_supply2_gst_applicable' => $client-> ,
                'supply2_charge_narration' => $client->bihar_vet_bin_narration,
                'agreement_start_date' => $client->agreement_start_date,
                'agreement_end_date' => $client->agreement_end_date,
                'service_start_date' => $client->service_start_date,
                // 'bill_calculation_date' => $client-> ,
                'is_old_client' => $client->old_client_checkbox,
                'old_client' => $client->old_client_id,
                // 'remark' => $client-> ,
                // 'is_rate_increment' => $client-> ,
                // 'rate_increment' => $client-> ,
                // 'every' => $client-> ,
                // 'duration' => $client-> ,
                // 'amount_renewal_date' => $client-> ,
                // 'print_on_agreement' => $client-> ,
                'constitution' => $client->type_of_concern,
                // 'signing_authority' => $client-> ,
                // 'other_authority' => $client-> ,
                'registration_fee' => $client->reistration_fees,
                'security_deposit' => $client->security_deposit,
                'advance_deposit' => $client->advance_deposit,
                'agreement_execution_date' => $client->aggrement_execution_date,
                'name_of_person' => $client->contact_person_name,
                'person_contact' => $client->contact_person_phone,
                // 'contact_same_as_billing' => $client-> ,
                'person_email' => $client->contact_person_email,
                // 'email_same_as_billing' => $client-> ,
                'designation' => $client->contact_person_designation,
                // 'is_agreement_recieved' => $client-> ,
                // 'is_agreement_sent' => $client-> ,
                'agreement_recieved_date' => $client->client_doc_receive_date,
                'agreement_sent_date' => $client->client_doc_send_date,
                // 'agreement_file' => $client-> ,
                // 'document' => $client-> ,
                // 'uploaded_document' => $client-> ,
                // 'hcf_name' => $client-> ,
                // 'hcf_address' => $client-> ,
                // 'hcf_contact_person' => $client-> ,
                'hcf_person_email' => $client->hcf_email_id,
                'hcf_person_contact' => $client->hcf_phone,
                'hcf_landline' => $client->hcf_telephone,
                // 'hcf_gst_no' => $client-> ,
                // 'pan_no' => $client-> ,
                // 'tan_no' => $client-> ,
                // 'signing_authority_pan_no' => $client-> ,
                // 'aadhar_no' => $client-> ,
                // 'pcb_authorization_no' => $client-> ,
                // 'authorization_date' => $client-> ,
                // 'is_bedded' => $client-> ,
                // 'no_of_beds' => $client-> ,
                // 'bank_name' => $client-> ,
                // 'acc_no' => $client-> ,
                // 'ifsc_code' => $client-> ,
                // 'kyc_file' => $client-> ,
                'status' => $client->active,
                'created_at' => $client->created_date,
                'created_by' => $client->created_by,
                'updated_at' => $client->last_modified_date,
                'updated_by' => $client->last_modified_by,
                'is_pharma_client' => $client->is_pharma_client,
                'notes' => $client->notes,
                'payment_type' => $client->payment_type,
                'total_monthly_charges' => $client->total_monthly_charges,
                'accounting_head' => $client->accounting_head,
                'client_executive' => $client->client_executive,
                'client_route_id' => $client->client_route_id,
                'pharma_gst' => $client->pharma_gst,
                'is_discontinued' => $client->is_discontinued,
                'service_end_date' => $client->service_end_date,
                'alternate_email' => $client->alternate_email,
                'alternate_email_flag' => $client->alternate_email_flag,
                'contact_person_phone_secondary' => $client->contact_person_phone_secondary,
                'old_soft_pk' => $client->old_soft_pk,
                'discontinued_on' => $client->discontinued_on,
                'dis_continue_master_date' => $client->dis_continue_master_date,
                'route_remove_notes' => $client->route_remove_notes,
                'route_wise_executive' => $client->route_wise_executive,
                'client_doc_approve_date' => $client->client_doc_approve_date,
                'client_doc_receive_date' => $client->client_doc_receive_date,
                'client_doc_send_date' => $client->client_doc_send_date,
                'advance_head' => $client->advance_head,
                'security_head' => $client->security_head,
                'doctor_personal_email' => $client->doctor_personal_email
            ]);
        } //End Foreach

        if (count($data) > 0) {
            $storeClient = Client::insert($data);
            if ($storeClient) {
                echo 'Success! Client synced successfully.';
            } else {
                echo 'Error! Something went wrong.';
            }
        } else {
            echo 'Notice! No record found to sync.';
        }
    }
}
