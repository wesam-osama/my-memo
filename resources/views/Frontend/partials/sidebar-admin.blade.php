@include('frontend.partials.sidebar-nav', [
    'eyebrow' => __('navigation.admin.eyebrow'),
    'workspaceLabel' => __('navigation.admin.workspace'),
    'items' => [
        [
            'label' => __('navigation.admin.overview'),
            'route' => 'frontend.dashboard',
            'active' => request()->routeIs('frontend.dashboard'),
        ],
        [
            'label' => __('navigation.admin.organizations'),
            'route' => 'frontend.admin.companies.index',
            'active' => request()->routeIs('frontend.admin.companies.*'),
        ],
        [
            'label' => __('navigation.admin.users'),
            'route' => 'frontend.admin.users.index',
            'active' => request()->routeIs('frontend.admin.users.*'),
        ],
        [
            'label' => __('navigation.admin.settings'),
            'route' => 'frontend.admin.audit-logs.index',
            'active' => request()->routeIs('frontend.admin.audit-logs.*'),
        ],
    ],
])
