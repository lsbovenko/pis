<?php

return [
    'custom' => [
        'email' => [
            'required' => 'Заполните Email',
            'email' => 'Введите корректный email',
            'unique' => 'Пользователь с таким email уже существует'
        ],
        'name' => [
            'required' => 'Заполните Имя',
        ],
        'role_id' => [
            'required' => 'Заполните Роль',
            'in' => 'Выберите Роль из списка'
        ],
        'department_id' => [
            'required' => 'Заполните Отдел',
            'in' => 'Выберите отдел из списка'
        ],
    ],
];
