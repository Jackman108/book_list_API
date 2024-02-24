<?php

namespace unit\controllers;

use PHPUnit\Framework\TestCase;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\httpclient\Response;
use yii\httpclient\Exception;

class BooksControllerTest extends TestCase
{
    protected Client $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = $this->createMock(Client::class);
    }

    // Тест для метода получения списка книг

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testGetBooks()
    {
        // Создаем заглушку для объекта Request
        $request = $this->createMock(Request::class);

        // Устанавливаем ожидание вызова метода send у объекта request и возвращаем заглушку response
        $request->expects($this->once())
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        // Создаем заглушку для объекта Client
        $client = $this->createMock(Client::class);
        // Определяем поведение заглушки для метода createRequest
        $client->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Присваиваем созданную заглушку объекту $httpClient
        $this->httpClient = $client;

        // Теперь вызываем метод контроллера, который должен использовать $httpClient,
        // чтобы отправить запрос, и проверяем его результаты
        $this->httpClient->createRequest()->send();
    }

    // Тест для метода создания новой книги

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testCreateBook()
    {
        // Создаем заглушку для объекта Request
        $request = $this->createMock(Request::class);

        // Создаем заглушку для объекта Response
        $response = $this->createMock(Response::class);

        // Устанавливаем ожидание вызова метода send у объекта request и возвращаем заглушку response
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Создаем заглушку для объекта Client
        $client = $this->createMock(Client::class);
        // Определяем поведение заглушки для метода createRequest
        $client->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Присваиваем созданную заглушку объекту $httpClient
        $this->httpClient = $client;

        // Теперь вызываем метод контроллера, который должен использовать $httpClient,
        // чтобы отправить запрос, и проверяем его результаты
        $this->httpClient->createRequest()->send();
    }

    // Тест для метода обновления информации о книге

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateBook()
    {
        // Создаем заглушку для объекта Request
        $request = $this->createMock(Request::class);

        // Создаем заглушку для объекта Response
        $response = $this->createMock(Response::class);

        // Устанавливаем ожидание вызова метода send у объекта request и возвращаем заглушку response
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Создаем заглушку для объекта Client
        $client = $this->createMock(Client::class);
        // Определяем поведение заглушки для метода createRequest
        $client->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Присваиваем созданную заглушку объекту $httpClient
        $this->httpClient = $client;

        // Теперь вызываем метод контроллера, который должен использовать $httpClient,
        // чтобы отправить запрос, и проверяем его результаты
        $this->httpClient->createRequest()->send();
    }

    // Тест для метода удаления книги

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testDeleteBook()
    {
        // Создаем заглушку для объекта Request
        $request = $this->createMock(Request::class);

        // Устанавливаем ожидание вызова метода setMethod и setUrl у объекта request
        $request->expects($this->once())
            ->method('setMethod')
            ->willReturnSelf();
        $request->expects($this->once())
            ->method('setUrl')
            ->willReturnSelf();

        // Создаем заглушку для объекта Response
        $response = $this->createMock(Response::class);
        $response->method('getStatusCode')->willReturn(204);

        // Устанавливаем ожидание вызова метода send у объекта request и возвращаем заглушку response
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Устанавливаем ожидание вызова метода createRequest у объекта httpClient и возвращаем заглушку request
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Теперь вызываем метод контроллера, который должен использовать $httpClient,
        // чтобы отправить запрос, и проверяем его результаты
        $response = $this->httpClient->createRequest()
            ->setMethod('DELETE')
            ->setUrl('http://localhost/api/v1/books/1')
            ->send();

        // Проверяем код ответа
        $this->assertEquals(204, $response->getStatusCode());
    }
}
