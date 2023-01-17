<?php

namespace App\Helpers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/

class ConstantHelper
{

    const PROJECT_NAME = 'SYNERGY';
    const DEFAULT_PASSWORD = "ERP#321";

    const SUPER_ADMIN = 'super-admin';
    const ADMIN = 'admin';
    const USER = 'user';
    const CLIENT = 'client';

    const MONDAY = 'Monday';
    const TUESDAY = 'Tuesday';
    const WEDNESDAY = 'Wednesday';
    const THURSDAY = 'Thursday';
    const FRIDAY = 'Friday';
    const SATURDAY = 'Saturday';
    const SUNDAY = 'Sunday';
    const WEEK_DAYS = [self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY];

    const ADDRESS_TYPE = ['primary', 'alternate', 'billing', 'default', 'shipping', 'work', 'home', 'mailing', 'permanent', 'temporary'];

    const ACTIVE = 'active';
    const IN_ACTIVE = 'inactive';
    const PENDING = 'pending';
    const REJECTED = 'rejected';
    const APPROVED = 'approved';
    const DRAFT = 'draft';
    const PUBLISHED = 'published';

    const DATA_STATUS = [self::DRAFT, self::PUBLISHED];

    const READ = 'read';
    const UNREAD = 'unread';
    const TRASHED = 'trashed';
    const MESSAGE_STATUS = [self::READ, self::UNREAD, self::TRASHED];

    const PAID = 'paid';
    const UNPAID = 'unpaid';
    const BILL_PAYMENT_STATUS = [self::PAID, self::UNPAID];


    const CR = 'CR';
    const DR = 'DR';
    const TRANSACTION_TYPE = [self::CR, self::DR];

    const MARRIED = 'married';
    const UNMARRIED = 'unmarried';
    const MARITAL_STATUS = [self::MARRIED, self::UNMARRIED];


    const YES = 'Yes';
    const NO = 'No';
    const BOOLEAN_STATUS = [self::YES, self::NO];

    const MALE = 'male';
    const FEMALE = 'female';
    const TRANSGENDER = 'transgender';
    const GENDER = [self::MALE, self::FEMALE, self::TRANSGENDER];

    // OTP based validations:
    const OTP_EXPIRE_LIMT = 600;   //in seconds
    const OTP_EXPIRE_MINUTE = 10;   //in minutes

    const OTP_MIN_SIZE = 5;
    const OTP_MAX_SIZE = 6;


    const AUTH_TOKEN_EXPIRE_LIMT = 86400;   //in seconds

    const INITIATED = 'initiated';
    const SUCCESS = 'success';
    const FAILED = 'failed';
    const DECLINE = 'decline';

    const PAYMENT_STATUS = [self::INITIATED, self::SUCCESS, self::PENDING, self::DECLINE];

    // LEDGER TYPE
    const CGST = 'CGST';
    const SGST = 'SGST';
    const IGST = 'IGST';
    const ROUND_OFF = 'Round-Off';
    const REGISTRATION_FEE = 'Registration Fee';
    const TDS_RECEIVABLE = 'TDS (Receivable)';
    const INCOME_ACCOUNT_TAXABLE_SERVICE = 'Income Account Taxable Service';
    const INCOME_ACCOUNT_NON_TAXABLE_SERVICE = 'Income Account Non-Taxable Service';
    const INCOME_ACCOUNT_TAXABLE_SUPPLY = 'Income Account Taxable Supply';
    const INCOME_ACCOUNT_NON_TAXABLE_SUPPLY = 'Income Account Non-Taxable Supply';
    const SUNDRY_DEBTORS = 'Sundry Debtors';
    const ONE_MONTH_ADVANCE = 'One Month Advance';

    const LEDGER_TYPES = [
        self::CGST, self::SGST,
        self::IGST, self::ROUND_OFF,
        self::REGISTRATION_FEE, self::TDS_RECEIVABLE,
        self::SUNDRY_DEBTORS, self::ONE_MONTH_ADVANCE,
        self::INCOME_ACCOUNT_TAXABLE_SERVICE, self::INCOME_ACCOUNT_NON_TAXABLE_SERVICE,
        self::INCOME_ACCOUNT_TAXABLE_SUPPLY, self::INCOME_ACCOUNT_NON_TAXABLE_SUPPLY,
    ];

    //crons status
    const CRON_IDLE = 'idle';
    const CRON_RUNING = 'running';
    const CRON_STOPPED = 'stopped';
    const CRON_SUCCESS = 'success';
    const CRON_SKIPPED = 'skipped';

    const CRON_UPDATE_LIMIT = 100;
    const PLAN_VALIDITY_IN_DAYS = 30;
    const DEFAUTLT_DIAL_CODE = '+91';

    /* L E N G T H */
    const NAME_MAX_LENGTH = 40;
    const ALIAS_MAX_LENGTH = 40;
    const FULLNAME_MAX_LENGTH = 100;
    const EMAIL_MAX_LENGTH = 100;
    const MOBILE_MIN_LENGTH = 8;
    const MOBILE_MAX_LENGTH = 15;
    const PASSWORD_MIN_LENGTH = 6;
    const POSTAL_MIN_LENGTH = 5;
    const POSTAL_MAX_LENGTH = 6;
    const PAN_NUMBER_SIZE = 10;
    const GSTIN_MAX_LENGTH = 15;
    const HSN_MAX_LENGTH = 6;
    const GST_PERCENTAGE = 18;
    const AADHAR_MAX_LENGTH = 12;
    const DESCRIPTION_LENGTH = 5000;
    const PRODUCT_NAME_MAX_LENGTH = 299;
    const LANDMARK_MAX_LENGTH = 599;



    /*L I M I T*/
    const AGE_LIMIT = 14;
    const DOUBLE_TOTAL_DIGITS = 16;
    const DOUBLE_DECIMAL_PLACES = 4;
    const PAGE_LIMIT = 10;
    const PAGE_LIMIT_20 = 20;


    /* E M A I L */
    const MAIL_STATUS = [
        'pending',
        'success',
        'failed'
    ];

    /* A M O U N T S*/
    const AMOUNT = 'amount';
    const PERCENTAGE = 'percentage';
    const DEDUCTION_TYPES = [
        self::AMOUNT,
        self::PERCENTAGE
    ];

    const MONTHS = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    const ALPHABATES = [
        1 => 'a',
        2 => 'b',
        3 => 'c',
        4 => 'd',
        5 => 'e',
        6 => 'f',
        7 => 'g',
        8 => 'h',
        9 => 'i',
        10 => 'j',
        11 => 'k',
        12 => 'l',
        13 => 'm',
        14 => 'n',
        15 => 'o',
        16 => 'p',
        17 => 'q',
        18 => 'r',
        19 => 's',
        20 => 't',
        21 => 'u',
        22 => 'v',
        23 => 'w',
        24 => 'x',
        25 => 'y',
        26 => 'z'
    ];

    const ROMAN_NUMBERS = [
        1 => 'i',
        2 => 'ii',
        3 => 'iii',
        4 => 'iv',
        5 => 'v',
        6 => 'vi',
        7 => 'vii',
        8 => 'viii',
        9 => 'ix',
        10 => 'x',
        11 => 'xi',
        12 => 'xii',
        13 => 'xiii',
        14 => 'xiv',
        15 => 'xv'
    ];

    const DECIMAL_PLACES = [
        0 => '0',
        1 => '1',
        2 => '2',
        3 => '3',
        // 4 => '4',
    ];

    public static function cus_number_format($val){
        return number_format((float)$val, 2, '.', '');
    }
    public static function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Forteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . 'Only';
    }
}
