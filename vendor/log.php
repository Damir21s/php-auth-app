<?php
session_start();
require __DIR__ . '/auth.php';

// Проверяем на заполненность поля формы
if (!empty($_POST['login']) && !empty($_POST['password'])) {

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверяем существует ли в БД пользователь с такими данными
    if (checkAuth($login, $password)) {

        // Генерируем ключ для проверки авторизован пользовтель или нет
        $hash = password_hash(generateCode(10), PASSWORD_DEFAULT);

        // Собираем данные в  массив и сохраняем их в сессию
        $user_data = array(
            'login' => $login,
            'hash' => $hash
        );
        $_SESSION['user'] = $user_data;

        // Заполняем ключ проверки в БД
        $file = file_get_contents(dirname(__DIR__) . '/data/usersDB.json');

        $users = json_decode($file, true);
        unset($file);

        for ($counter = 0; $counter < count($users); $counter++) {
            if ($users[$counter]['login'] == $login &&  password_verify($password, $users[$counter]['password'])) {
                $users[$counter]['hash'] = $hash;
            }
        }
        file_put_contents('../data/usersDB.json', json_encode($users, JSON_UNESCAPED_UNICODE));
        unset($users);

        header('Location: /index.php');
    } else {
        $_SESSION['error-msg'] = 'Введен неверный логин или пароль. Попробуйте еще раз.';
        header('Location: /login.php');
        exit();
    }
} else if (!empty($_POST)) {
    $_SESSION['error-msg'] = 'Оба поля должны быть заполнены!';
    header('Location: /login.php');
    exit();
}

// Фнукция для генерации ключа проверки авторизован пользовтель или нет
function generateCode($length = 6)
{

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {

        $code .= $chars[mt_rand(0, $clen)];
    }

    return $code;
}
