<?php

namespace integration;
require_once __DIR__ . '/../../vendor/autoload.php';

use Yii;
use app\models\Book;
use app\models\Author;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Дополнительные настройки
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        // Дополнительные действия по завершению
        parent::tearDown();
    }

    // Тестирование API для книг

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testGetBooks()
    {
        // Тестирование метода GET /books
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['baseUrl'] . '/books')
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $data = $response->getData();
        // Выполнение проверок на данные ответа
        $this->assertNotEmpty($data);
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testCreateBook()
    {
        // Тестирование метода POST /books
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(Yii::$app->params['baseUrl'] . '/books')
            ->setData([
                'title' => 'Новая книга',
                'author_id' => 1,
                'pages' => 200,
                'language' => 'Русский',
                'genre' => 'Фантастика',
                'description' => 'Описание новой книги'
            ])
            ->send();

        $this->assertSame(201, $response->getStatusCode());
        $createdBook = Book::findOne(['title' => 'Новая книга']);
        $this->assertNotNull($createdBook);
        // Выполнение проверок на созданную книгу
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateBook()
    {
        // Тестирование метода PUT /books/:id
        $book = Book::findOne(['title' => 'Новая книга']);
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('PUT')
            ->setUrl(Yii::$app->params['baseUrl'] . '/books/' . $book->id)
            ->setData([
                'title' => 'Обновленное название книги',
                // Другие обновленные поля книги
            ])
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $updatedBook = Book::findOne($book->id);
        // Выполнение проверок на обновленную книгу
        $this->assertEquals('Обновленное название книги', $updatedBook->title);

    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testDeleteBook()
    {
        // Тестирование метода DELETE /books/:id
        $book = Book::findOne(['title' => 'Новая книга']);
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('DELETE')
            ->setUrl(Yii::$app->params['baseUrl'] . '/books/' . $book->id)
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $deletedBook = Book::findOne($book->id);
        $this->assertNull($deletedBook);
        // Проверка, что книга была удалена
    }

    // Тестирование API для авторов

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testGetAuthors()
    {
        // Тестирование метода GET /authors
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['baseUrl'] . '/authors')
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $data = $response->getData();
        // Выполнение проверок на данные ответа
        $this->assertNotEmpty($data);

    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testCreateAuthor()
    {
        // Тестирование метода POST /authors
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl(Yii::$app->params['baseUrl'] . '/authors')
            ->setData([
                'name' => 'Новый автор',
                'birth_year' => 1980,
                'country' => 'Россия'
            ])
            ->send();

        $this->assertSame(201, $response->getStatusCode());
        $createdAuthor = Author::findOne(['name' => 'Новый автор']);
        $this->assertNotNull($createdAuthor);
        // Выполнение проверок на созданного автора
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testUpdateAuthor()
    {
        // Тестирование метода PUT /authors/:id
        $author = Author::findOne(['name' => 'Новый автор']);
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('PUT')
            ->setUrl(Yii::$app->params['baseUrl'] . '/authors/' . $author->id)
            ->setData([
                'name' => 'Обновленное имя автора',
                // Другие обновленные поля автора
            ])
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $updatedAuthor = Author::findOne($author->id);
        // Выполнение проверок на обновленного автора
        $this->assertEquals('Обновленное имя автора', $updatedAuthor->name);

    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function testDeleteAuthor()
    {
        // Тестирование метода DELETE /authors/:id
        $author = Author::findOne(['name' => 'Новый автор']);
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('DELETE')
            ->setUrl(Yii::$app->params['baseUrl'] . '/authors/' . $author->id)
            ->send();

        $this->assertSame(200, $response->getStatusCode());
        $deletedAuthor = Author::findOne($author->id);
        $this->assertNull($deletedAuthor);
        // Проверка, что автор был удален
    }
}
