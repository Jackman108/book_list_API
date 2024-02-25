<?php
//config/db.php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=bookstore',
    'username' => 'postgres',
    'password' => 'postgres',
    'charset' => 'utf8',
];
