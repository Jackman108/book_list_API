<?php

namespace app\controllers;

use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\DataFilter;
use yii\db\StaleObjectException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\Book;
use yii\web\Response;

class BookController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    /**
     * Метод для получения списка книг.
     *
     * Метод: GET
     * URL: /books
     * Ответ: массив объектов книг.
     */
    public function actionIndex(): array
    {
        return Book::find()->all();
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'dataFilter' => [
                    'class' => DataFilter::class,
                    'searchModel' => 'app\models\BookSearch',
                ],
            ],
        ]);
    }

    /**
     * Метод для создания новой книги.
     *
     * Метод: POST
     * URL: /books
     * Тело запроса: JSON объект с данными новой книги.
     * Ответ: созданный объект книги.
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $book = new Book();
        Yii::info(Yii::$app->getRequest()->getBodyParams(), 'debug');

        $book->load(Yii::$app->request->getBodyParams(), '');

        if ($book->save()) {
            Yii::$app->response->setStatusCode(201);
            return $book;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $book->getErrors();
        }
    }

    /**
     * Метод для редактирования существующей книги.
     *
     * Метод: PUT
     * URL: /books/:id
     * Параметры запроса: id - идентификатор книги.
     * Тело запроса: JSON объект с данными для обновления книги.
     * Ответ: обновленный объект книги.
     * @throws InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $book = Book::findOne($id);
        if ($book === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Книга не найдена'];
        }
        $book->load(Yii::$app->request->getBodyParams(), '');

        if ($book->save()) {
            return $book;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $book->getErrors();
        }
    }

    /**
     * Метод для удаления книги.
     *
     * Метод: DELETE
     * URL: /books/:id
     * Параметры запроса: id - идентификатор книги.
     * Ответ: сообщение об успешном удалении книги.
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): ?array
    {
        $book = Book::findOne($id);
        if ($book === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Книга не найдена'];
        }
        if ($book->delete()) {
            Yii::$app->response->setStatusCode(204);
            return ['message' => 'Книга успешно удалена'];
        } else {
            Yii::$app->response->setStatusCode(500);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Ошибка удаления книги'];
        }
    }
}
