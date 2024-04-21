<?php

use App\Models\Setting;

if(!function_exists('roleExist')){
    function roleExist($roleName)
    {
        if (\Spatie\Permission\Models\Role::where('name', $roleName)->count()  > 0){
            return true;
        }
        return false;
    }
}

if (!function_exists('isActive')) {
    function isActive($route, $output = 'active')
    {
        if (is_array($route)) {
            foreach ($route as $r) {
                if (Route::currentRouteName() == $r) {
                    return $output;
                }
            }
        } else {
            if (Route::currentRouteName() == $route) {
                return $output;
            }
        }
    }
}

function stringToDecimal($string)
{
    $string = trim($string, '₺');
    return number_format((float) str_replace(',', '.', str_replace('.', '', $string)), 2, '.', '');
}

/**
 * @param $tax_include_price
 * @param $tax_percent
 * @return array
 */
function taxCalculator($taxIncludedPrice, $taxPercent)
{
    $taxPrice = ($taxIncludedPrice * $taxPercent) / 100;
    $withOutTaxPrice = $taxIncludedPrice - $taxPrice;
    return [
        'tax_price' => $taxPrice,
        'without_tax' => $withOutTaxPrice,
        'included_tax' => $taxIncludedPrice,
        'tax_percent' => $taxPercent ?? 0,
    ];
}

function generateTableName($table_name, $onlyDonem = false) {
    $setting = Setting::first();
    $donem_no = $setting->logo_donem_no;
    $firma_no = $setting->logo_firma_no;

    return 'LG_' . $donem_no . '_'. ($onlyDonem != true ? $firma_no . '_' : '') . $table_name;

}

