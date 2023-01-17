<?php

namespace App\Observers;

use App\Models\Plant;
use App\Models\Client;
use App\Models\AccountingGroup;
use App\Models\AccountingLedger;
use App\Models\AccountingWzaccount;

class ClientLedgerObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function created(Client $client)
    {
        $plant = Plant::find($client->plant);
        if ($plant) {
            $accountingWzaccount = AccountingWzaccount::where('others', $plant->char_id)->first();
            if ($accountingWzaccount) {
                // Security Other Advance Group Head
                $groupHeadAdvance = new AccountingGroup;
                $groupHeadAdvance->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups');
                $groupHeadAdvance->updateOrCreate(
                    [
                        'name' => "ONE MONTH ADVANCE - " . strtoupper($plant->name),
                        'parent_id' => '2'
                    ],
                    [
                        'affects_gross' => '0'
                    ]
                );

                $dataGroupHeadAdvance = $groupHeadAdvance->where('name', "ONE MONTH ADVANCE - " . strtoupper($plant->name))
                    ->where('parent_id', 2)
                    ->first();

                if ($dataGroupHeadAdvance) {
                    // Security Other Advance Ledger
                    $accountingLedger = new AccountingLedger();
                    $accountingLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers');
                    $accountingLedger->updateOrCreate(
                        [
                            'group_id' => $dataGroupHeadAdvance->id,
                            'name' => $client->business_name . ' - SEC',
                            'code' => $client->client_char_id . '-SEC',
                            'op_balance' => $client->closing_balance,
                            'notes' => $client->business_name . ' - ' . strtoupper($plant->name),
                        ]
                    );
                }

                // Sundry Debtors Group Head
                $groupHeadSundry = new AccountingGroup;
                $groupHeadSundry->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups');
                $groupHeadSundry->updateOrCreate(
                    [
                        'name' => 'Sundry Debtors',
                        'parent_id' => '1'
                    ],
                    [
                        'affects_gross' => '0'
                    ]
                );

                $dataGroupHeadSundry = $groupHeadSundry->where('name', 'Sundry Debtors')
                    ->where('parent_id', 1)
                    ->first();

                // Sundry Debtors Ledger
                if ($dataGroupHeadSundry) {
                    $accountingSundryLedger = new AccountingLedger();
                    $accountingSundryLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers');
                    $accountingSundryLedger->updateOrCreate(
                        [
                            'group_id' => $dataGroupHeadSundry->id,
                            'name' =>  $client->business_name,
                            'code' =>  $client->client_char_id,
                            'op_balance' => $client->closing_balance,
                            'notes' => $client->business_name . ' - ' . strtoupper($plant->name),
                        ]
                    );
                }
            } else {
                // dd("No accountingWzaccount found");
            }
        } else {
            // dd("No plant found");
        }
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function updated(Client $client)
    {
        $plant = Plant::find($client->plant);
        if ($plant) {
            $accountingWzaccount = AccountingWzaccount::where('others', $plant->char_id)->first();
            if ($accountingWzaccount) {
                // Security Other Advance Group Head
                $groupHeadAdvance = new AccountingGroup;
                $groupHeadAdvance->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups');
                $groupHeadAdvance->updateOrCreate(
                    [
                        'name' => "ONE MONTH ADVANCE - " . strtoupper($plant->name),
                        'parent_id' => '2'
                    ],
                    [
                        'affects_gross' => '0'
                    ]
                );

                $dataGroupHeadAdvance = $groupHeadAdvance->where('name', "ONE MONTH ADVANCE - " . strtoupper($plant->name))
                    ->where('parent_id', 2)
                    ->first();

                if ($dataGroupHeadAdvance) {
                    // Security Other Advance Ledger
                    $accountingLedger = new AccountingLedger();
                    $accountingLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers');
                    $accountingLedger->updateOrCreate(
                        [
                            'group_id' => $dataGroupHeadAdvance->id,
                            'name' => $client->business_name . ' - SEC',
                            'code' => $client->client_char_id . '-SEC',
                            'op_balance' => $client->closing_balance,
                            'notes' => $client->business_name . ' - ' . strtoupper($plant->name),
                        ]
                    );
                }


                // Sundry Debtors Group Head
                $groupHeadSundry = new AccountingGroup;
                $groupHeadSundry->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups');
                $groupHeadSundry->updateOrCreate(
                    [
                        'name' => 'Sundry Debtors',
                        'parent_id' => '1'
                    ],
                    [
                        'affects_gross' => '0'
                    ]
                );

                $dataGroupHeadSundry = $groupHeadSundry->where('name', 'Sundry Debtors')
                    ->where('parent_id', 1)
                    ->first();

                // Sundry Debtors Ledger
                if ($dataGroupHeadSundry) {
                    $accountingSundryLedger = new AccountingLedger();
                    $accountingSundryLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers');
                    $accountingSundryLedger->updateOrCreate(
                        [
                            'group_id' => $dataGroupHeadSundry->id,
                            'name' =>  $client->business_name,
                            'code' =>  $client->client_char_id,
                            'op_balance' => $client->closing_balance,
                            'notes' => $client->business_name . ' - ' . strtoupper($plant->name),
                        ]
                    );
                }
            } else {
                // dd("No accountingWzaccount found");
            }
        } else {
            // dd("No plant found");
        }
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function deleted(Client $client)
    {
        //
    }

    /**
     * Handle the Client "restored" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function restored(Client $client)
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function forceDeleted(Client $client)
    {
        //
    }
}
