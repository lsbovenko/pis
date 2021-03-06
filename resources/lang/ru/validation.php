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
        'last_name' => [
            'required' => 'Заполните Фамилию',
        ],
        'reason' => [
            'required' => 'Заполните Причину отклонения',
            'min' => 'Причнина должна содержать не менее :min символов.'
        ],
        'reason_priority' => [
            'required' => 'Заполните Пояснительную записку',
            'min' => 'Пояснительная записка должнa содержать не менее :min символов.'
        ],
        'title' => [
            'required' => 'Заполните Заголовок',
            'min' => 'Заголовок должен быть не менее :min символов.'
        ],
        'description' => [
            'required' => 'Заполните Описание',
            'min' => 'Описание должно быть не менее :min символов.'
        ],
        'role_id' => [
            'required' => 'Заполните Роль',
            'in' => 'Выберите Роль из списка'
        ],
        'department_id' => [
            'required' => 'Заполните Отдел',
            'in' => 'Выберите отдел из списка'
        ],
        'position_id' => [
            'required' => 'Заполните Должность',
            'in' => 'Выберите должность из списка'
        ],
        'core_competency_id' => [
            'required' => 'Заполните Компетенцию',
            'in' => 'Выберите Компетенцию из списка'
        ],
        'operational_goal_id' => [
            'required' => 'Заполните Операционную Цель',
            'in' => 'Выберите Операционнyю Цель из списка'
        ],
        'type_id' => [
            'required' => 'Заполните Тип',
            'in' => 'Выберите Тип из списка'
        ],
        'strategic_objective_id' => [
            'required' => 'Заполните Стратегическую задачу',
            'in' => 'Выберите Стратегическую задачу из списка'
        ],
        'status_id' => [
            'required' => 'Заполните Статус',
            'in' => 'Выберите Статус из списка'
        ],
        'details' => [
            'required' => 'Заполните Подробности',
            'min' => 'Подробности должны быть не менее :min символов.'
        ],
    ],
    'min' => [
        'numeric' => 'Должен быть не менее :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'Должен быть не менее :min символов.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'confirmed' => 'Подтверждение не совпадает',
];
