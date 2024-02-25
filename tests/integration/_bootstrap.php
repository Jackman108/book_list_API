<?php

namespace app\tests\integration;

// Подключаем автозагрузчик классов Yii2
require_once __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

// Подключаем автозагрузчик классов Composer
require __DIR__ . '/../../vendor/autoload.php';

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Exception;

// Загружаем переменные окружения из файла .env
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$containerBuilder = new ContainerBuilder();

// Добавляем определения зависимостей из файла конфигурации DI
$containerBuilder->addDefinitions(__DIR__ . '/../../config/di.php');

$container = null;

try {
    // Строим контейнер зависимостей
    $container = $containerBuilder->build();
} catch (Exception $e) {
    // Обработка исключения при ошибке построения контейнера
}

// Возвращаем контейнер для использования в тестах
return $container;
