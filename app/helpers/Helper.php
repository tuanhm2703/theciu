<?php

use App\Models\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

if (!function_exists('isNavActive')) {
    function isNavActive(String $routeName) {
        if (strpos(Route::currentRouteName(), $routeName) === 0) return true;
        return strpos(Request::url(), $routeName) === 0;
    }
}
function stripVN($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);

    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function renderCategory($category) {
    $output = '';
    if ($category->hasProducts()) {
        $route = route('client.product.index', ['category' => $category->slug]);
        $output .= "<li><a href='$route'>$category->name</a>";
        if ($category->categories->count() > 0) {
            $output .= "<ul>";
            foreach ($category->categories as $c) {
                $output .= renderCategory($c);
            }
            $output .= "</ul>";
        }
        $output .= "</li>";
    }
    return $output;
}

function getLocaleWithCountryCode() {
    return [
        'af' => 'ZA',
        'am' => 'ET',
        'ar' => 'AE',
        'ar' => 'BH',
        'ar' => 'DZ',
        'ar' => 'EG',
        'ar' => 'IQ',
        'ar' => 'JO',
        'ar' => 'KW',
        'ar' => 'LB',
        'ar' => 'LY',
        'ar' => 'MA',
        'arn' => 'CL',
        'ar' => 'OM',
        'ar' => 'QA',
        'ar' => 'SA',
        'ar' => 'SD',
        'ar' => 'SY',
        'ar' => 'TN',
        'ar' => 'YE',
        'as' => 'IN',
        'az' => 'az',
        'az' => 'Cyrl-AZ',
        'az' => 'Latn-AZ',
        'ba' => 'RU',
        'be' => 'BY',
        'bg' => 'BG',
        'bn' => 'BD',
        'bn' => 'IN',
        'bo' => 'CN',
        'br' => 'FR',
        'bs' => 'Cyrl-BA',
        'bs' => 'Latn-BA',
        'ca' => 'ES',
        'co' => 'FR',
        'cs' => 'CZ',
        'cy' => 'GB',
        'da' => 'DK',
        'de' => 'AT',
        'de' => 'CH',
        'de' => 'DE',
        'de' => 'LI',
        'de' => 'LU',
        'dsb' => 'DE',
        'dv' => 'MV',
        'el' => 'CY',
        'el' => 'GR',
        'en' => '029',
        'en' => 'AU',
        'en' => 'BZ',
        'en' => 'CA',
        'en' => 'cb',
        'en' => 'GB',
        'en' => 'IE',
        'en' => 'IN',
        'en' => 'JM',
        'en' => 'MT',
        'en' => 'MY',
        'en' => 'NZ',
        'en' => 'PH',
        'en' => 'SG',
        'en' => 'TT',
        'en' => 'US',
        'en' => 'ZA',
        'en' => 'ZW',
        'es' => 'AR',
        'es' => 'BO',
        'es' => 'CL',
        'es' => 'CO',
        'es' => 'CR',
        'es' => 'DO',
        'es' => 'EC',
        'es' => 'ES',
        'es' => 'GT',
        'es' => 'HN',
        'es' => 'MX',
        'es' => 'NI',
        'es' => 'PA',
        'es' => 'PE',
        'es' => 'PR',
        'es' => 'PY',
        'es' => 'SV',
        'es' => 'US',
        'es' => 'UY',
        'es' => 'VE',
        'et' => 'EE',
        'eu' => 'ES',
        'fa' => 'IR',
        'fi' => 'FI',
        'fil' => 'PH',
        'fo' => 'FO',
        'fr' => 'BE',
        'fr' => 'CA',
        'fr' => 'CH',
        'fr' => 'FR',
        'fr' => 'LU',
        'fr' => 'MC',
        'fy' => 'NL',
        'ga' => 'IE',
        'gd' => 'GB',
        'gd' => 'ie',
        'gl' => 'ES',
        'gsw' => 'FR',
        'gu' => 'IN',
        'ha' => 'Latn-NG',
        'he' => 'IL',
        'hi' => 'IN',
        'hr' => 'BA',
        'hr' => 'HR',
        'hsb' => 'DE',
        'hu' => 'HU',
        'hy' => 'AM',
        'id' => 'ID',
        'ig' => 'NG',
        'ii' => 'CN',
        'in' => 'ID',
        'is' => 'IS',
        'it' => 'CH',
        'it' => 'IT',
        'iu' => 'Cans-CA',
        'iu' => 'Latn-CA',
        'iw' => 'IL',
        'ja' => 'JP',
        'ka' => 'GE',
        'kk' => 'KZ',
        'kl' => 'GL',
        'km' => 'KH',
        'kn' => 'IN',
        'kok' => 'IN',
        'ko' => 'KR',
        'ky' => 'KG',
        'lb' => 'LU',
        'lo' => 'LA',
        'lt' => 'LT',
        'lv' => 'LV',
        'mi' => 'NZ',
        'mk' => 'MK',
        'ml' => 'IN',
        'mn' => 'MN',
        'mn' => 'Mong-CN',
        'moh' => 'CA',
        'mr' => 'IN',
        'ms' => 'BN',
        'ms' => 'MY',
        'mt' => 'MT',
        'nb' => 'NO',
        'ne' => 'NP',
        'nl' => 'BE',
        'nl' => 'NL',
        'nn' => 'NO',
        'no' => 'no',
        'nso' => 'ZA',
        'oc' => 'FR',
        'or' => 'IN',
        'pa' => 'IN',
        'pl' => 'PL',
        'prs' => 'AF',
        'ps' => 'AF',
        'pt' => 'BR',
        'pt' => 'PT',
        'qut' => 'GT',
        'quz' => 'BO',
        'quz' => 'EC',
        'quz' => 'PE',
        'rm' => 'CH',
        'ro' => 'mo',
        'ro' => 'RO',
        'ru' => 'mo',
        'ru' => 'RU',
        'rw' => 'RW',
        'sah' => 'RU',
        'sa' => 'IN',
        'se' => 'FI',
        'se' => 'NO',
        'se' => 'SE',
        'si' => 'LK',
        'sk' => 'SK',
        'sl' => 'SI',
        'sma' => 'NO',
        'sma' => 'SE',
        'smj' => 'NO',
        'smj' => 'SE',
        'smn' => 'FI',
        'sms' => 'FI',
        'sq' => 'AL',
        'sr' => 'BA',
        'sr' => 'CS',
        'sr' => 'Cyrl-BA',
        'sr' => 'Cyrl-CS',
        'sr' => 'Cyrl-ME',
        'sr' => 'Cyrl-RS',
        'sr' => 'Latn-BA',
        'sr' => 'Latn-CS',
        'sr' => 'Latn-ME',
        'sr' => 'Latn-RS',
        'sr' => 'ME',
        'sr' => 'RS',
        'sr' => 'sp',
        'sv' => 'FI',
        'sv' => 'SE',
        'sw' => 'KE',
        'syr' => 'SY',
        'ta' => 'IN',
        'te' => 'IN',
        'tg' => 'Cyrl-TJ',
        'th' => 'TH',
        'tk' => 'TM',
        'tlh' => 'QS',
        'tn' => 'ZA',
        'tr' => 'TR',
        'tt' => 'RU',
        'tzm' => 'Latn-DZ',
        'ug' => 'CN',
        'uk' => 'UA',
        'ur' => 'PK',
        'uz' => 'Cyrl-UZ',
        'uz' => 'Latn-UZ',
        'uz' => 'uz',
        'vi' => 'VN',
        'wo' => 'SN',
        'xh' => 'ZA',
        'yo' => 'NG',
        'zh' => 'CN',
        'zh' => 'HK',
        'zh' => 'MO',
        'zh' => 'SG',
        'zh' => 'TW',
        'zu' => 'ZA',
    ];
}
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPhone($phone) {
    return preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $phone) > 0;
}

function format_currency($value) {
    return number_format($value, 0, ',', '.');
}

function isRomanNumber($roman) {
    $roman_characters = [
        'M',
        'CM',
        'D',
        'CD',
        'C',
        'XC',
        'L',
        'XL',
        'X',
        'IX',
        'V',
        'IV',
        'I',
    ];
    for ($i = 0; $i < strlen($roman); $i++) {
        if (!in_array($roman[$i], $roman_characters)) return false;
    }
    return true;
}

function convertRomanToInteger($roman) {
    if (isRomanNumber($roman) == false) return 0;
    $romans = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    );
    $result = 0;
    foreach ($romans as $key => $value) {
        while (strpos($roman, $key) === 0) {
            $result += $value;
            $roman = substr($roman, strlen($key));
        }
    }
    return $result;
}

function pickUpAddressOptions() {
    $config = Config::select('id')->first();
    return $config->pickup_addresses()->pluck('full_address', 'id')->toArray();
}

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

public function getAppName() {
    return env('APP_NAME');
}
