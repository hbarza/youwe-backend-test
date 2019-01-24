<?php

return [
    [
        'pattern' => '<lang:\w{2}>/account/<module:\w+>',
        'route' => '<module>/account/index',
    ],
    [
        'pattern' => '<lang:\w{2}>/account/<module:\w+>/<action:\w+>',
        'route' => '<module>/account/<action>',
    ],
];
