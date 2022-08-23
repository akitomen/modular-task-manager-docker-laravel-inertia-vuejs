<?php

use Modules\TaskManager\Restrictions\Recurrencable\Monthly;
use Modules\TaskManager\Restrictions\Recurrencable\Weekly;

return [
    'name' => 'TaskManager',
    'table_prefix' => 'task_manager_',
    'recurrencables' => [
        Weekly::TYPE_NAME => Weekly::class,
        Monthly::TYPE_NAME => Monthly::class,
    ]
];
