<?php

return [
    'global' => [
        'default_image' => [
            'avatar' => 'assets/img/no-pict.jpeg'
        ]
    ],
    'sys' => [
        'sidebar' => [
            [
                'name' => 'Dashboard',
                'icon' => 'bx bx-home-alt',
                'route' => 'sys.index',
                'is_header' => false,
                'state' => 'dashboard',
                'sub' => []
            ], [
                'name' => 'Service',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Budget',
                'icon' => 'bx bx-money',
                'route' => 'sys.budget.index',
                'is_header' => false,
                'state' => 'budget',
                'sub' => [],
            ], [
                'name' => 'Goals',
                'icon' => 'bx bx-bullseye',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Planned Payment',
                'icon' => 'bx bx-calendar-event',
                'route' => 'sys.planned-payment.index',
                'is_header' => false,
                'state' => 'planned-payment',
                'sub' => []
            ], [
                'name' => 'Record',
                'icon' => 'bx bx-book-content',
                'route' => 'sys.record.index',
                'is_header' => false,
                'state' => 'record',
                'sub' => []
            ], [
                'name' => 'Shopping List',
                'icon' => 'bx bx-cart-alt',
                'route' => 'sys.shopping-list.index',
                'state' => 'shopping-list',
                'sub' => [],
            ], [
                'name' => 'Master Data',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Record Template',
                'icon' => 'bx bxs-book-content',
                'route' => 'sys.record.template.index',
                'is_header' => false,
                'state' => 'record-template',
                'sub' => []
            ], [
                'name' => 'Wallet',
                'icon' => 'bx bx-wallet-alt',
                'route' => null,
                'is_header' => false,
                'state' => 'wallet',
                'sub' => [
                    [
                        'name' => 'List',
                        'route' => 'sys.wallet.list.index',
                        'state' => 'list',
                    ], [
                        'name' => 'Group',
                        'route' => 'sys.wallet.group.index',
                        'state' => 'group',
                    ], [
                        'name' => 'Share',
                        'route' => 'sys.wallet.share.index',
                        'state' => 'share',
                    ]
                ]
            ], [
                'name' => 'MISCELLANEOUS',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ],  [
                'name' => 'Profile',
                'icon' => 'bx bx-user-circle',
                'route' => null,
                'is_header' => false,
                'state' => 'profile',
                'sub' => [
                    [
                        'name' => 'Account',
                        'route' => 'sys.profile.index',
                        'state' => 'account',
                        'icon' => 'bx bx-wallet-alt',
                    ], [
                        'name' => 'Category',
                        'route' => 'sys.category.index',
                        'state' => 'category',
                        'icon' => 'bx bxs-category',
                    ],  [
                        'name' => 'Tags',
                        'route' => 'sys.tag.index',
                        'state' => 'tag',
                        'icon' => 'bx bx-purchase-tag',
                    ], 
                ]
            ], 
        ]
    ]
];