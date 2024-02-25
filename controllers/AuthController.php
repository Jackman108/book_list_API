<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function actionIndex(): array
    {
        // Получаем access token из POST-запроса
        $accessToken = Yii::$app->request->post('access_token');

        // Проверяем, существует ли access token
        if ($accessToken) {
            // Получаем клиент Google OAuth2 из authClientCollection
            $googleClient = Yii::$app->authClientCollection->getClient('google');

            // Устанавливаем полученный access token для клиента Google OAuth2
            $googleClient->setAccessToken(['access_token' => $accessToken]);

            // Получаем информацию о пользователе с помощью клиента Google OAuth2
            $userInfo = $googleClient->api('https://www.googleapis.com/oauth2/v1/userinfo');

            // Если удалось получить информацию о пользователе, возвращаем её
            if (!empty($userInfo)) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'user' => $userInfo,
                ];
            }
        }

        // Если access token не был предоставлен или произошла ошибка, возвращаем сообщение об ошибке
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => false,
            'error' => 'Failed to authenticate user with provided access token',
        ];
    }
}
