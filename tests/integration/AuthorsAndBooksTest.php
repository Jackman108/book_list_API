<?php

declare(strict_types=1);

namespace app\tests\integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/_bootstrap.php';

class AuthorsAndBooksTest extends TestCase
{
    private Client $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        // Инициализация HTTP-клиента для взаимодействия с API
        $this->httpClient = new Client([
            'base_uri' => 'http://localhost:8080', // Базовый URL API
            'http_errors' => false, // Разрешение на получение ошибок HTTP
        ]);
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Выполнить скрипт для создания тестовых данных перед всеми тестами
        require_once __DIR__ . '/create_latest_authors_and_books.php';
    }

    /**
     * @throws GuzzleException
     */
    public function testGetAuthors(): void
    {
        // Выполняем GET запрос к /authors через API
        $response = $this->httpClient->request('GET', '/authors');

        // Проверяем код ответа
        $this->assertEquals(200, $response->getStatusCode());

        // Получаем содержимое тела ответа как строку
        $body = (string)$response->getBody();

        // Парсим JSON-данные из строки
        $authors = json_decode($body, true);

        // Проверяем, что полученный массив не пустой
        $this->assertNotEmpty($authors);
    }

    /**
     * @throws GuzzleException
     */
    public function testGetBooks(): void
    {
        // Выполняем GET запрос к /books через API
        $response = $this->httpClient->request('GET', '/books');

        // Проверяем код ответа
        $this->assertEquals(200, $response->getStatusCode());

        // Получаем содержимое тела ответа как строку
        $body = (string)$response->getBody();

        // Парсим JSON-данные из строки
        $books = json_decode($body, true);

        // Проверяем, что полученный массив не пустой
        $this->assertNotEmpty($books);
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        // Выполнить скрипт для удаления тестовых данных после всех тестов
      //  require_once __DIR__ . '/delete_latest_authors_and_books.php';
    }
}
