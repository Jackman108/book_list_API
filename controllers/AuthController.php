<?php

namespace app\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * OAuth2 authentication action.
     *
     * @return string[]
     * @throws Exception
     */
    public function actionOAuth(): array
    {
        // Получаем компонент authClientCollection
        $authClientCollection = Yii::$app->get('authClientCollection');
        // Инициализация клиента OAuth2
        $authClient = $authClientCollection->getClient('oauth2');

        // Проверка наличия кода авторизации
        $code = Yii::$app->request->get('code');
        if (!$code) {
            // Возвращаем ошибку, если код авторизации не предоставлен
            Yii::$app->response->statusCode = 400;
            return Yii::$app->response->data = ['error' => 'Authorization code is missing'];
        } else {
            try {
                // Обработка ответа от провайдера аутентификации
                $authClient->handleCallback($_POST);

                // Получение данных пользователя
                $userAttributes = $authClient->getUserAttributes();
                // Генерация токена доступа (ваша реализация этой части)
                $accessToken = $this->generateAccessToken($userAttributes);

                // Возвращаем успешный ответ с данными пользователя и токеном доступа
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'user' => $userAttributes,
                    'access_token' => $accessToken
                ];
            } catch (Exception $e) {
                // Обработка ошибок, возникших во время обработки ответа
                Yii::error('Error handling OAuth callback: ' . $e->getMessage());
                Yii::$app->response->statusCode = 500;
                return ['error' => 'Internal Server Error'];
            }
        }
    }

    /**
     * Генерация JWT токена доступа.
     *
     * @param array $userAttributes
     * @return string
     */
    private function generateAccessToken(array $userAttributes): string
    {
        // Генерация токена с использованием JWT
        $tokenPayload = [
            'user' => $userAttributes,
            'exp' => time() + (7 * 24 * 60 * 60) // Токен действителен 7 дней
        ];
        $jwtSecretKey = Yii::$app->params['jwtSecretKey']; // Параметр секретного ключа, храните его в настройках приложения
        return JWT::encode($tokenPayload, $jwtSecretKey, 'HS256');
    }
}
