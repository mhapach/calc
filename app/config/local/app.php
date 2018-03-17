<?php

return array(
    'debug' => true,
    'url'   => 'http://calc2/',
    'providers' => append_config([
        'Barryvdh\Debugbar\ServiceProvider',
        'Darsain\Console\ConsoleServiceProvider',
    ])
);
