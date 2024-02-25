<?php
/// create_latest_authors_and_books.php
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

// Добавляем тестовых авторов и книги
try {
    $dbConnection->createCommand()->batchInsert('author', ['name', 'birth_year', 'country'], [
        ['Author 1', 1980, 'Country 1'],
        ['Author 2', 1990, 'Country 2'],
        ['Author 3', 1975, 'Country 3'],
    ])->execute();

    $dbConnection->createCommand()->batchInsert('book', ['title', 'author_id', 'pages', 'language', 'genre', 'description'], [
        ['Book 1', 1, 200, 'English', 'Fiction', 'Description 1'],
        ['Book 2', 2, 250, 'Russian', 'Non-Fiction', 'Description 2'],
        ['Book 3', 3, 300, 'Spanish', 'Fantasy', 'Description 3'],
    ])->execute();

    echo "Data inserted successfully.\n";
} catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . "\n";
} finally {
    // Закрываем соединение с базой данных
    $dbConnection->close();
}