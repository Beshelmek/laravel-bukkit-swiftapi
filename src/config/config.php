<?php

return array(
    'global' => array(
        'host' => 'localhost',
        'port' => 21111,
        'username' => 'admin',
        'password' => 'test',
        'salt' => 'saltines'
    ),
    'my-other-server' => array(
        'host' => '11.11.11.11',
        'username' => 'admin',
        'password' => 'test'
        // If you left out config settings, it will use the global for that setting
    )
);