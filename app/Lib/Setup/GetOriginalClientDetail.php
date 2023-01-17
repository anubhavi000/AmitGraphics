<?php

namespace App\Lib\Setup;

class GetOriginalClientDetail
{

    private $plant_id;

    public function __construct($plant_id)
    {
        $this->plant_id = $plant_id;
    }

    public function get()
    {
        $query = "SELECT c.`client_id`,c.`is_govt`,ah.`accounting_head_id`,`ah`.`accounting_head_name`,c.`client_char_id`,c.`active`,c.`minimum_amount`,c.`name`,c.`file_no`,c.`dist`, " .
            "(IF(STRCMP(COALESCE(ah.`opening_balance_type`,'DEBIT'),'CREDIT') = 0,ah.`opening_balance`,- 1 * ah.`opening_balance`)+(COALESCE(SUM(COALESCE(av.`credit_amount`, 0)),0) - COALESCE(SUM(COALESCE(av.`debit_amount`, 0)),0))) AS 'closing_balance' " .
            "FROM accounting_head ah " .
            "INNER JOIN group_head gh ON gh.`group_head_id`=ah.`group_head_id` " .
            "LEFT JOIN accounting_voucher av ON av.`accounting_head` = ah.`accounting_head_id` " .
            "INNER JOIN `dbsynergy`.`client` c ON c.`accounting_head`=ah.`accounting_head_id` " .
            "LEFT JOIN client_routes cr ON cr.`client_id`=c.`client_id`" .
            // "LEFT JOIN routes r ON r.route_id=cr.`route_id` " .
            "WHERE av.is_discarded IS NULL AND c.`plant_id`=$this->plant_id " .
            "GROUP BY ah.`accounting_head_id` ORDER BY  c.`client_id` ASC";

        $clientsData = \DB::connection('mysql2')->select(\DB::raw($query));

        return $clientsData;
    }
}
