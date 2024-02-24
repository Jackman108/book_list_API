<?php

namespace app\controllers;

use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\rest\ActiveController;
use app\models\Author;
use yii\web\Response;


class AuthorController extends ActiveController
{
public $modelClass = 'app\models\Author';

    public function actionIndex(): array
    {
        return Author::find()->all();
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        $author = new Author();
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