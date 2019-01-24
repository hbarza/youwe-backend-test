<?php

return [
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>',
        'route' => '<module>/index/index',
    ],
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>',
        'route' => '<module>/<controller>/index',
    ],
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>',
        'route' => '<module>/<controller>/<action>',
    ],
];
