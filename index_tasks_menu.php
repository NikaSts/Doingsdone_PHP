<?
$tasks_menu = [
    [
        'name' => 'Все задачи',
        'code' => '',
        'active' => false
    ],
    [
        'name' => 'Повестка дня',
        'code' => 'today',
        'active' => false
    ],
    [
        'name' => 'Завтра',
        'code' => 'tomorrow',
        'active' => false
    ],
    [
        'name' => 'Просроченные',
        'code' => 'overdue',
        'active' => false
    ]
];

foreach($tasks_menu as &$menu) {
    $tasks_switch = '';
    if (isset($_GET['tasks_switch'])) {
        $tasks_switch = $_GET['tasks_switch'];
    }

    if ($tasks_switch === $menu['code']) {
        $menu['active'] = true;
    }

    $query_data = [];
    if ($menu['code']) {
        $query_data = ['tasks_switch' => $menu['code']];
    }
    if (isset($_GET['project_id'])) {
        $query_data['project_id'] = intval($_GET['project_id']);
    }
    if (isset($_GET['show_completed'])) {
        if ($_GET['show_completed'] === '1') {
            $query_data['show_completed'] = '1';
        }
    }
    if (isset($_GET['search'])) {
        $query_data['search'] = esc($_GET['search']);
    }

    if (count($query_data)) {
        $menu['url'] = '/index.php?' . http_build_query($query_data);
    } else {
        $menu['url'] = '/';
    }
}

return $tasks_menu;
