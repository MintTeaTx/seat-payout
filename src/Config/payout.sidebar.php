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
        'icon' => 'fa-calculator',
        'entries' =>    [
            [
                'name' => 'Payout Calculator',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'payout',
                'route' => 'payout.view',
                'permission' => 'payout.view'
            ],
            [
            'name' => 'Configuration',
            'icon' => 'fa-cog',
            'route_segment' => 'payout',
            'route' => 'payout.config',
            'permission' => 'payout.config'
        ]
        ]

    ]

];
