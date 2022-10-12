<?php

return [
    'global' => [
        'default_image' => [
            'avatar' => 'assets/img/no-pict.jpeg'
        ]
    ],
    'sys' => [
        'sidebar' => collect([
            [
                'name' => 'Dashboard',
                'icon' => 'bx bx-home-alt',
                'route' => 'sys.index',
                'is_header' => false,
                'state' => 'dashboard',
                'sub' => collect([])
            ], [
                'name' => 'Service',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Budget',
                'icon' => 'bx bx-money',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Goals',
                'icon' => 'bx bx-bullseye',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Planned Payment',
                'icon' => 'bx bx-calendar-event',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Record',
                'icon' => 'bx bx-book-content',
                'route' => 'sys.record.index',
                'is_header' => false,
                'state' => 'record',
                'sub' => collect([])
            ], [
                'name' => 'Shopping List',
                'icon' => 'bx bx-cart-alt',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Master Data',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Record Template',
                'icon' => 'bx bxs-book-content',
                'route' => null,
                'is_header' => false,
                'state' => null,
                'sub' => collect([])
            ], [
                'name' => 'Wallet',
                'icon' => 'bx bx-wallet-alt',
                'route' => null,
                'is_header' => false,
                'state' => 'wallet',
                'sub' => collect([
                    [
                        'name' => 'List',
                        'route' => 'sys.wallet.list.index',
                        'state' => 'list',
                    ], [
                        'name' => 'Group',
                        'route' => 'sys.wallet.group.index',
                        'state' => 'group',
                    ]
                ])
            ], [
                'name' => 'MISCELLANEOUS',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => collect([])
            ],  [
                'name' => 'Profile',
                'icon' => 'bx bx-user-circle',
                'route' => null,
                'is_header' => false,
                'state' => 'profile',
                'sub' => collect([
                    [
                        'name' => 'Account',
                        'route' => 'sys.profile.index',
                        'state' => 'account',
                        'icon' => 'bx bx-wallet-alt',
                    ], [
                        'name' => 'Category',
                        'route' => 'sys.category.index',
                        'state' => 'category',
                        'icon' => 'bx bx-wallet-alt',
                    ],  [
                        'name' => 'Tags',
                        'route' => 'sys.tag.index',
                        'state' => 'tag',
                        'icon' => 'bx bx-wallet-alt',
                    ], 
                ])
            ], 
        ])
    ]
];