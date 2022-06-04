<?php
session_start();

require __DIR__ . '/vendor/auth.php';

$error_msg = '';
if (isset($_SESSION['error-msg'])) {
    $error_msg = $_SESSION['error-msg'];
    unset($_SESSION['error-msg']);
}

if (isUserLoggedIn())
    header('Location: /index.php');
?>

<html>

<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <form action="/vendor/reg.php" method="post">
        <h1>Регистрация</h1>
        <div class="login">
            <label for="reg-login">Логин: </label>
            <input type="text" name="reg-login" id="reg-login" placeholder="Введите логин">
        </div>
        <div class="password">
            <label for="reg-password">Пароль: </label>
            <input type="password" name="reg-password" id="reg-password" placeholder="Введите пароль">
        </div>
        <div class="password">
            <label for="confirm_password">Подтвердите пароль: </label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Введите пароль">
        </div>
        <input class="log-button" type="submit" value="Зарегистрироваться">
        <?php if (!empty($error_msg)) : ?>
            <span class="error-msg">
                <?= $error_msg ?>
            </span>
        <?php endif; ?>
        <p class="go-to-log">У вас уже есть аккаунт? <a href="login.php">Войти</a></p>
    </form>

</body>

</html>