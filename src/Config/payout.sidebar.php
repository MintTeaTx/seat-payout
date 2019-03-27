<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/23/2019
 * Time: 11:10 PM
 */

return [
    'payout' => [
        'name'=>'Fleet Payout Calculator',
        'permission' => 'payout.view',
        'route_segment' => 'payout',
        'icon' => 'fa_rocket',
        'entries' =>    [
            [
                'name' => 'Payout Calculator',
                'icon' => 'fa-rocket',
                'route_segment' => 'payout',
                'route' => 'payout.view',
                'permission' => 'payout.view'
            ]
        ]

    ]

];