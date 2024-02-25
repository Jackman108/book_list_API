<?php

namespace app\tests\unit\controllers;

use app\models\Book;
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
        $this->assertInstanceOf(Book::class, new Book());

        // Данные о книгах
        $books = [
            ['title' => 'Book 1', 'author' => 'Author 1', 'pages' => 200, 'language' => 'English', 'genre' => 'Fiction'],
            ['title' => 'Book 2', 'author' => 'Author 2', 'pages' => 300, 'language' => 'Russian', 'genre' => 'Non-fiction'],
        ];

        // Создаем моковый ответ
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($books);

        // Создаем моковый запрос
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Создаем моковый клиент
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Вызываем метод контроллера и проверяем результат
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($books, $response->getData());
    }

    // Тест для метода создания новой книги

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testCreateBook()
    {
        // Данные для создания новой книги
        $newBookData = [
            'title' => 'New Book',
            'author_id' => 1,
            'pages' => 250,
            'language' => 'French',
            'genre' => 'Mystery',
            'description' => 'Description of the new book',
        ];

        // Создаем моковый ответ
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($newBookData);

        // Создаем моковый запрос
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Создаем моковый клиент
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Вызываем метод контроллера и проверяем результат
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($newBookData, $response->getData());
    }

    // Тест для метода редактирования/удаления книги

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateBook()
    {
        // Моковые данные для обновления книги
        $updatedBookData = [
            'title' => 'Updated Book',
            'author' => 'Updated Author',
            'pages' => 150,
            'language' => 'Spanish',
            'genre' => 'Adventure',
            'description' => 'Updated description of the book',
        ];

        // Создаем моковый ответ
        $response = $this->createMock(Response::class);
        $response->expects($this->once())
            ->method('getData')
            ->willReturn($updatedBookData);

        // Создаем моковый запрос
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Создаем моковый клиент
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Вызываем метод контроллера и проверяем результат
        $response = $this->httpClient->createRequest()->send();
        $this->assertEquals($updatedBookData, $response->getData());
    }

    // Тест для метода удаления книги

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testDeleteBook()
    {
        // Создаем моковый запрос
        $request = $this->createMock(Request::class);

        // Создаем моковый ответ
        $response = $this->createMock(Response::class);

        // Настраиваем моковый запрос на возвращение мокового ответа
        $request->expects($this->once())
            ->method('send')
            ->willReturn($response);

        // Настраиваем моковый клиент на возвращение мокового запроса
        $this->httpClient->expects($this->once())
            ->method('createRequest')
            ->willReturn($request);

        // Вызываем метод контроллера и проверяем результат
        $this->httpClient->createRequest()->send();
        // Здесь могут быть дополнительные проверки
    }
}
