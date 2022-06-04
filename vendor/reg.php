<?php
session_start();

// Проверяем заполнены ли все поля формы
if (!empty($_POST['reg-login']) && !empty($_POST['reg-password']) && !empty($_POST['confirm_password'])) {
    $login = $_POST['reg-login'] ?? '';
    $password = $_POST['reg-password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Проверяем совпадают ли введенные пароли
    if ($password == $confirm_password) {
        $user_data = array(
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'hash' => ''
        );

        // Считываем данные из БД
        $file = file_get_contents('../data/usersDB.json');

        $users = json_decode($file, true);
        unset($file);

        // Проверяем существует ли пользователь с введенным логином в БД
        for ($counter = 0; $counter < count($users); $counter++) {
            if ($users[$counter]['login'] == $user_data['login']) {
                $_SESSION['error-msg'] = 'Пользователь с таким логином уже существует!';
                header('Location: /register.php');
                exit();
            }
        }

        // Производим добавление нового пользователя в БД
        array_push($users, $user_data);
        unset($user_data);

        file_put_contents('../data/usersDB.json', json_encode($users, JSON_UNESCAPED_UNICODE));
        unset($users);

        $_SESSION['reg-success'] = 'Регистрация прошла успешно! Теперь Вы можете войти в свой аккаунт.';
        header('Location: /login.php');
    } else {
        $_SESSION['error-msg'] = 'Введенные пароли  не совпадают!';
        header('Location: /register.php');
        exit();
    }
} else if (!empty($_POST)) {
    $_SESSION['error-msg'] = 'Все поля должны быть заполнены!';
    header('Location: /register.php');
    exit();
}
