<?php
// delete_latest_authors_and_books.php
declare(strict_types=1);

use yii\base\InvalidConfigException;
use yii\db\Exception;

// Подключаем конфигурацию базы данных
$dbConfig = require __DIR__ . '/../../config/test_db.php';

// Создаем подключение к базе данных
try {
    $dbConnection = Yii::createObject($dbConfig);
} catch (InvalidConfigException $e) {
    error_log('Error creating database connection: ');
    echo "Error creating database connection: " . $e->getMessage() . "\n";
    exit(1);
}

// Удаляем тестовых авторов и книги
try {
    $dbConnection->createCommand()->delete('author')->execute();
    $dbConnection->createCommand()->delete('book')->execute();

    echo "Data deleted successfully.\n";
} catch (Exception $e) {
    echo "Error deleting data: " . $e->getMessage() . "\n";
} finally {
    // Закрываем соединение с базой данных
    $dbConnection->close();
}