<?php

namespace App\Lib\Setup;

class GetClientOpeningBalance
{

    private $clientId;

    public function __construct($clientId)
    {
        $this->client_id = $clientId;
    }

    public function get()
    {
        $query = "SELECT c.`client_id`,c.`is_govt`,ah.`accounting_head_id`,`ah`.`accounting_head_name`,c.`client_char_id`,c.`active`,c.`minimum_amount`,r.`route_name`,cr.`route_order`,c.`name`,c.`file_no`,c.`dist`, " .
            "(IF(STRCMP(COALESCE(ah.`opening_balance_type`,'DEBIT'),'CREDIT') = 0,ah.`opening_balance`,- 1 * ah.`opening_balance`)+(COALESCE(SUM(COALESCE(av.`credit_amount`, 0)),0) - COALESCE(SUM(COALESCE(av.`debit_amount`, 0)),0))) AS 'closing_balance' " .
            "FROM accounting_head ah " .
            "INNER JOIN group_head gh ON gh.`group_head_id`=ah.`group_head_id` " .
            "LEFT JOIN accounting_voucher av ON av.`accounting_head` = ah.`accounting_head_id` " .
            "INNER JOIN `dbsynergy`.`client` c ON c.`accounting_head`=ah.`accounting_head_id` " .
            "LEFT JOIN client_routes cr ON cr.`client_id`=c.`client_id`" .
            "LEFT JOIN routes r ON r.route_id=cr.`route_id` " .
            "WHERE av.is_discarded IS NULL AND c.`client_id`=$this->client_id " .
            "GROUP BY ah.`accounting_head_id` ORDER BY  r.`route_id`,cr.`route_order` ASC";

        $clientsData = \DB::connection('mysql2')->select(\DB::raw($query));

        return $clientsData;
    }
}
