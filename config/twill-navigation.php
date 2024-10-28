<?php
return [
    'content' => [
        'title' => 'Content',
        'route' => 'twill.products.index',
        'primary_navigation' => [
            'products' => [
                'title' => 'Products',
                'module' => true
            ],
            'services' => [
                'title' => 'Services',
                'module' => true
            ],
            'orders' => [
                'title' => 'Orders',
                'module' => true
            ],
            'comments' => [
                'title' => 'Comments',
                'module' => true
            ]
        ]
    ],
    'revision' => [
        'title' => 'Revision',
        'module' => true,
        'route' => 'twill.revisions.index'
    ],
    'pages' => [
        'title' => 'Pages',
        'module' => true,
    ],
    'menuLinks' => [
        'title' => 'Menu',
        'module' => true,
    ]
];
