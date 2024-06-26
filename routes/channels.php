<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать все каналы трансляции событий, которые поддерживает ваше приложение
| Данные обратные вызовы для авторизации канала
| используются для проверки того, может ли аутентифицированный пользователь прослушивать канал.|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
