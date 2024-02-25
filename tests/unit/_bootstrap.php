<?php

// add unit testing specific bootstrap code here
$db = require __DIR__ . '/../../config/test_db.php';
try {
    Yii::$app->set('db', $db);
} catch (\yii\base\InvalidConfigException $e) {
}