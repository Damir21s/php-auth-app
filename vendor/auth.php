<?php

// Поиск в БД пользователя с данными, которые были введены во время авторизации
// Если такой пользователь есть и данные совпадают, возвращаем true, иначе false
function checkAuth(string $login, string $password): bool
{
    $file = file_get_contents('../data/usersDB.json');

    $users = json_decode($file, true);
    unset($file);

    foreach ($users as $user) {
        if (
            $user['login'] === $login
            && password_verify($password, $user['password'])
        ) {
            return true;
        }
    }

    return false;
}

// Функция для проверки авторизован пользователь или нет
function isUserLoggedIn(): bool
{
    if (isset($_SESSION['user'])) {

        $login = $_SESSION['user']['login'] ?? '';
        $hash = $_SESSION['user']['hash'] ?? '';

        $file = file_get_contents(dirname(__DIR__) . '/data/usersDB.json');

        $users = json_decode($file, true);
        unset($file);

        foreach ($users as $user) {
            if (
                $user['login'] === $login
                && $user['hash'] === $hash
            ) {
                return true;
            }
        }
    }

    if (isset($_SESSION['user']))
        unset($_SESSION['user']);
    return false;
}
