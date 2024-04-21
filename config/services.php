<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'order_status' =>[
        "1" => 'Beklemede',
        "2" => 'Hazırlanıyor',
        "3" => 'Kargoya Verildi',
        "4" => 'Teslim Edildi',
    ],

    'types' => [
'1' =>'Nakit Tahsilat',
'2' =>'Nakit Ödeme',
'3' =>'Borç Dekontu',
'4' =>'Alacak Dekontu',
'5' =>'Virman Işlemi',
'6' =>'Kur Farkı İşlemi',
'12' =>'Özel İşlem',
'20' =>'Gelen Havaleler',
'21' =>'Gönderilen Havaleler',
'31' =>'Satınalma Faturası',
'32' =>'Perakende Satış İade Faturası',
'24' =>'Döviz Alış Belgesi',
'25' =>'Döviz Satış Belgesi',
'33' =>'Toptan Satış İade Faturası',
'34' =>'Alınan Hizmet Faturası',
'35' =>'Alınan Proforma Faturası',
'36' =>'Satınalma İade Faturası',
'37' =>'Perakende Satış Faturası',
'38' =>'Toptan Satış Faturası',
'39' =>'Verilen Hizmet Faturası',
'40' =>'Verilen Proforma Faturası',
'41' =>'Verilen Vade Farkı Faturası',
'42' =>'Alınan Vade Farkı Faturası',
'43' =>'Alınan Fiyat Farkı Faturası',
'44' =>'Verilen Fiyat Farkı Faturası',
'46' =>'Alınan Ser. Mes. Makbuzu',
'28' =>'Banka Alınan Hizmet Faturası',
'56' =>'Müsthsil Makbuzu',
'61' =>'Çek Girişi',
'62' =>'Senet Girişi',
'63' =>'Çek Çıkış Cari Hesaba',
'64' =>'Senet Çıkış Cari Hesaba',
'70' =>'Kredik Kartı Fişi',
'71' =>'Kredik Kartı İade Fişi',
'14' =>'Açılış Fişi',
'81' =>'Ödemeli Satış Siparişi',
'82' =>'Ödemeli Satınalma Siparişi',
    ]

];
