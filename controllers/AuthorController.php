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
use app\models\Author;
use yii\web\Response;


class AuthorController extends ActiveController
{
    public $modelClass = 'app\models\Author';

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
     * Метод для получения списка авторов.
     *
     * Метод: GET
     * URL: /authors
     * Ответ: массив объектов авторов.
     */
    public function actionIndex(): array
    {
        return Author::find()->all();
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
                    'searchModel' => 'app\models\AuthorSearch',
                ],
            ],
        ]);
    }

    /**
     * Метод для создания нового автора.
     *
     * Метод: POST
     * URL: /authors
     * Тело запроса: JSON объект с данными нового автора.
     * Ответ: созданный объект автора.
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $author = new Author();
        Yii::info(Yii::$app->getRequest()->getBodyParams(), 'debug');

        $author->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($author->save()) {
            Yii::$app->response->setStatusCode(201);
            return $author;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $author->getErrors();
        }
    }

    /**
     * Метод для редактирования существующего автора.
     *
     * Метод: PUT
     * URL: /authors/:id
     * Параметры запроса: id - идентификатор автора.
     * Тело запроса: JSON объект с данными для обновления автора.
     * Ответ: обновленный объект автора.
     * @throws InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $author = Author::findOne($id);
        if ($author === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Автор не найден'];
        }

        $author->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($author->save()) {
            return $author;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $author->getErrors();
        }
    }

    /**
     * Метод для удаления автора.
     *
     * Метод: DELETE
     * URL: /authors/:id
     * Параметры запроса: id - идентификатор автора.
     * Ответ: сообщение об успешном удалении автора.
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $author = Author::findOne($id);
        if ($author === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Автор не найден'];
        }

        if ($author->delete()) {
            Yii::$app->response->setStatusCode(204);
            return ['message' => 'Автор успешно удален'];
        } else {
            Yii::$app->response->setStatusCode(500);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Ошибка при удалении автора'];
        }
    }
}