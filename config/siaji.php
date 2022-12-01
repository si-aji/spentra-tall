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
                'route' => null,
                'is_header' => false,
                'state' => 'budget',
                'sub' => [],
                'disabled' => true
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
                'name' => 'Statistic',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Cash Flow',
                'icon' => 'bx bx-stats',
                'route' => null,
                'is_header' => false,
                'state' => 'cash-flow',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Spending',
                'icon' => 'bx bxs-pie-chart-alt',
                'route' => null,
                'is_header' => false,
                'state' => 'spending',
                'sub' => [],
                'disabled' => true
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
                    ], [
                        'name' => 'Tags',
                        'route' => 'sys.tag.index',
                        'state' => 'tag',
                        'icon' => 'bx bx-purchase-tag',
                    ], 
                ]
            ], 
        ]
    ],
    'adm' => [
        'sidebar' => [
            [
                'name' => 'Dashboard',
                'icon' => 'bx bx-home-alt',
                'route' => 'adm.index',
                'is_header' => false,
                'state' => 'dashboard',
                'sub' => []
            ], [
                'name' => 'Content Management',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Category',
                'icon' => 'bx bxs-category',
                'route' => null,
                'is_header' => false,
                'state' => 'content-category',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Page',
                'icon' => 'bx bxs-file',
                'route' => null,
                'is_header' => false,
                'state' => 'content-page',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Post',
                'icon' => 'bx bx-file',
                'route' => null,
                'is_header' => false,
                'state' => 'content-post',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Master Data',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Users',
                'icon' => 'bx bx-user',
                'route' => null,
                'is_header' => false,
                'state' => 'user',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Default Categories',
                'icon' => 'bx bxs-category',
                'route' => null,
                'is_header' => false,
                'state' => 'category',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'FAQ',
                'icon' => 'bx bx-info-circle',
                'route' => null,
                'is_header' => false,
                'state' => 'faq',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Statistic',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Users',
                'icon' => 'bx bx-user',
                'route' => null,
                'is_header' => false,
                'state' => 'stats-user',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Page View',
                'icon' => 'bx bx-fullscreen',
                'route' => null,
                'is_header' => false,
                'state' => 'stats-page_view',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Miscellaneous',
                'icon' => null,
                'route' => null,
                'is_header' => true,
                'state' => null,
                'sub' => []
            ], [
                'name' => 'Profile',
                'icon' => 'bx bx-user-circle',
                'route' => null,
                'is_header' => false,
                'state' => 'profile',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Help Desk',
                'icon' => 'bx bx-help-circle',
                'route' => null,
                'is_header' => false,
                'state' => 'profile',
                'sub' => [],
                'disabled' => true
            ], [
                'name' => 'Log Viewer',
                'icon' => 'bx bx-error',
                'route' => 'adm.log-viewer.index',
                'is_header' => false,
                'state' => 'log-viewer',
                'sub' => [],
            ], [
                'name' => 'Website Configuration',
                'icon' => 'bx bx-cog',
                'route' => null,
                'is_header' => false,
                'state' => 'website-configuration',
                'sub' => [],
                'disabled' => true
            ], 
        ]
    ]
];