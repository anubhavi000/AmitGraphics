<?php

namespace App\Lib\Setup;

class GetOriginalPharmaClientSecurityDetail
{

    private $plant_id;

    public function __construct($plant_id)
    {
        $this->plant_id = $plant_id;
    }

    public function get()
    {
        $query = "SELECT c.`pharma_client_id`,p.`plant_name`,p.`plant_id`,ah.accounting_head_id,`ah`.`accounting_head_name`,c.`char_id`,c.`active`,c.`name`, " .
            "(IF(STRCMP(COALESCE(ah.`opening_balance_type`,'DEBIT'),'CREDIT') = 0,ah.`opening_balance`,- 1 * ah.`opening_balance`)+(COALESCE(SUM(COALESCE(av.`credit_amount`, 0)),0) - COALESCE(SUM(COALESCE(av.`debit_amount`, 0)),0 ))) AS 'closing_balance' " .
            "FROM accounting_head ah " .
            "INNER JOIN group_head gh ON gh.`group_head_id`=ah.`group_head_id` " .
            "LEFT JOIN accounting_voucher av  ON av.`accounting_head` = ah.`accounting_head_id` " .
            "INNER JOIN `dbsynergy`.`pharma_client` c ON c.`security_head`=ah.`accounting_head_id` " .
            "INNER JOIN plant p ON p.`plant_id`=c.`plant_id` " .
            "WHERE av.is_discarded IS NULL AND c.`plant_id`=$this->plant_id " .
            "GROUP BY ah.`accounting_head_id` ORDER BY  c.`name` ASC;";

        $pharmaClientsData = \DB::connection('mysql2')->select(\DB::raw($query));

        return $pharmaClientsData;
    }
}
