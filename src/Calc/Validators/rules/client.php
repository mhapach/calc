<?php

return [
    'create' => [
        'first_name'      => ['required', 'min:3', 'max:255', 'alpha_dash'],
        'last_name'       => ['required', 'min:3', 'max:255', 'alpha_dash'],
        'email'           => ['required', 'email', 'unique:users,email'],
        'phone'           => ['numeric'],
        'status'          => ['required', 'integer', 'min:1'],
        'type'            => ['required', 'integer', 'min:1'],
        'last_contact_at' => ['date_format:d.m.Y'],
        'next_contact_at' => ['date_format:d.m.Y'],
        'description'     => ['min:1', 'max:1000'],
    ],
    'update' => [
        'first_name'      => ['required', 'min:3', 'max:255', 'alpha_dash'],
        'last_name'       => ['required', 'min:3', 'max:255', 'alpha_dash'],
        'email'           => ['required', 'email', 'unique:users,email'],
        'phone'           => ['numeric'],
        'status'          => ['required', 'integer', 'min:1'],
        'type'            => ['required', 'integer', 'min:1'],
        'last_contact_at' => ['date_format:d.m.Y'],
        'next_contact_at' => ['date_format:d.m.Y'],
        'description'     => ['min:1', 'max:1000'],
    ],
];
