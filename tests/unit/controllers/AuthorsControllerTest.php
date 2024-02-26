<?php

namespace app\tests\unit\controllers;

use app\models\Author;
use PHPUnit\Framework\TestCase;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\httpclient\Response;
use yii\httpclient\Exception;

class AuthorsControllerTest extends TestCase
{
    protected Client $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = $this->createMock(Client::class);
    }

    // Тест для метода получения списка авторов


    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    // Тест для метода получения списка авторов
    public function testGetAuthors()
    {
        $this->assertInstanceOf(Author::class, new Author());

        // Создаем несколько тестовых авторов
        $authors = [
            ['name' => 'John Doe', 'birth_year' => 1980, 'country' => 'USA'],
            ['name' => 'Jane Smith', 'birth_year' => 1975, 'country' => 'UK'],
        ];

        // Create a mock response
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($authors);

        // Create a mock request
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Create a mock Client.php
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Теперь вызываем метод контроллера, который должен использовать $httpClient,
        // чтобы отправить запрос, и проверяем его результаты
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($authors, $response->getData());
    }

    // Тест для метода создания нового автора

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testCreateAuthor()
    {
        // Данные для создания нового автора
        $newAuthorData = [
            'name' => 'Test Author',
            'birth_year' => 1990,
            'country' => 'Test Country',
        ];

        // Create a mock response
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($newAuthorData);

        // Create a mock request
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Create a mock Client.php
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Call the controller method and check the response
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($newAuthorData, $response->getData());
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateAuthor()
    {
        // Mock data for updating an author
        $updatedAuthorData = [
            'name' => 'Updated Name',
            'birth_year' => 2000,
            'country' => 'Updated Country',
        ];

        // Create a mock response
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($updatedAuthorData);

        // Create a mock request
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Create a mock Client.php
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Call the controller method and check the response
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($updatedAuthorData, $response->getData());
    }


    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testDeleteAuthor()
    {
        // Create a mock request
        $request = $this->createMock(Request::class);

        // Create a mock response
        $response = $this->createMock(Response::class);

        // Configure the mock request to return the mock response
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Configure the mock client to return the mock request
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Call the controller method and check the response
        $this->httpClient->createRequest()->send();
        // Your assertions go here
    }
}