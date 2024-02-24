<?php

namespace app\controllers;

use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;
use app\models\Book;
use yii\web\Response;

class BooksController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    public function actionIndex(): array
    {
        return Book::find()->all();
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new Book();
        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201);
            return $model;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['errors' => $model->errors];
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = Book::findOne($id);
        if ($model === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Book not found'];
        }
        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        } else {
            Yii::$app->response->setStatusCode(422);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['errors' => $model->errors];
        }
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): ?array
    {
        $model = Book::findOne($id);
        if ($model === null) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Book not found'];
        }
        if ($model->delete()) {
            Yii::$app->response->setStatusCode(204);
            return null;
        } else {
            Yii::$app->response->setStatusCode(500);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['error' => 'Error deleting book'];
        }
    }
}
