<?php

namespace App\Helpers;

use Illuminate\Routing\Route;

class Helper
{
    public static function getSelectedDbName()
    {
        return file_get_contents(public_path('connected_db.txt'));
    }
    public static function setSelectedDbName($db_name)
    {
        $file = public_path('connected_db.txt');
        file_put_contents($file, $db_name);
        return Helper::getSelectedDbName();
    }

    static function isActive($route, $output = 'active')
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
